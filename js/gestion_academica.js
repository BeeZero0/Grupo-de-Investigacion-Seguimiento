$(document).ready(function(){
    tablaGestionAcademica = $("#tablaGestionAcademica").DataTable({
        "columnDefs":[{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnEliminar'>Eliminar</button></div></div>"
        }],
        //Lenguaje español
        "language":{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }
    });

    $("#btnNew").click(function(){
        $("#formGestionAcademica").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Gestión Académica");
        $("#modalCRUD").modal("show");
        id_gestion_academica = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_gestion_academica = parseInt(fila.find('td:eq(0)').text());
        responsabilidad = fila.find('td:eq(1)').text();
        funcion_encomendada = fila.find('td:eq(2)').text();
        id_tipo_gestion = parseInt(fila.find('td:eq(3)').text());
        id_anio = parseInt(fila.find('td:eq(4)').text());


        $("#responsabilidad").val(responsabilidad);
        $("#funcion_encomendada").val(funcion_encomendada);
        $("#id_tipo_gestion").val(id_tipo_gestion);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Proyecto de Estudiante");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_gestion_academica = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_gestion_academica+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_gestion_academica.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_gestion_academica:id_gestion_academica},
                success: function () {
                    tablaGestionAcademica.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formGestionAcademica").submit(function (e) { 
        e.preventDefault();
        responsabilidad = $.trim($("#responsabilidad").val());
        funcion_encomendada = $.trim($("#funcion_encomendada").val());
        id_tipo_gestion = parseInt($.trim($("#id_tipo_gestion").val()));
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_gestion_academica.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_gestion_academica:id_gestion_academica, responsabilidad:responsabilidad, funcion_encomendada:funcion_encomendada, id_tipo_gestion:id_tipo_gestion, id_anio:id_anio},
            success: function (data) {
                id_gestion_academica = data[0].id_gestion_academica;
                responsabilidad = data[0].responsabilidad;
                funcion_encomendada = data[0].funcion_encomendada;
                id_tipo_gestion = data[0].id_tipo_gestion;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaGestionAcademica.row.add([id_gestion_academica, responsabilidad, funcion_encomendada, id_tipo_gestion, id_anio]).draw();
                } else {
                    tablaGestionAcademica.row(fila).data([id_gestion_academica, responsabilidad, funcion_encomendada, id_tipo_gestion, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});