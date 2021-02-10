$(document).ready(function(){
    tablaEstanciasAcademicas = $("#tablaEstanciasAcademicas").DataTable({
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
        $("#formEstanciasAcademicas").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Estancia Académica");
        $("#modalCRUD").modal("show");
        id_estancias_academicas = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_estancias_academicas = parseInt(fila.find('td:eq(0)').text());
        institucion = fila.find('td:eq(1)').text();
        proposito = fila.find('td:eq(2)').text();
        fecha_inicio = fila.find('td:eq(3)').text();
        fecha_fin = fila.find('td:eq(4)').text();
        id_linea = parseInt(fila.find('td:eq(5)').text());
        id_anio = parseInt(fila.find('td:eq(6)').text());

        $("#institucion").val(institucion);
        $("#proposito").val(proposito);
        $("#fecha_inicio").val(fecha_inicio);
        $("#fecha_fin").val(fecha_fin);
        $("#id_linea").val(id_linea);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Estancia Académica");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_estancias_academicas = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_estancias_academicas+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_estancias_academicas.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_estancias_academicas:id_estancias_academicas},
                success: function () {
                    tablaEstanciasAcademicas.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formEstanciasAcademicas").submit(function (e) { 
        e.preventDefault();
        institucion = $.trim($("#institucion").val());
        proposito = $.trim($("#proposito").val());
        fecha_inicio = $.trim($("#fecha_inicio").val());
        fecha_fin = $.trim($("#fecha_fin").val());
        id_linea = parseInt($.trim($("#id_linea").val()));
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_estancias_academicas.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_estancias_academicas:id_estancias_academicas, institucion:institucion, proposito:proposito, id_linea:id_linea, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, id_anio:id_anio},
            success: function (data) {
                id_estancias_academicas = data[0].id_estancias_academicas;
                institucion = data[0].institucion;
                proposito = data[0].proposito;
                fecha_inicio = data[0].fecha_inicio;
                fecha_fin = data[0].fecha_fin;
                id_linea = data[0].id_linea;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaEstanciasAcademicas.row.add([id_estancias_academicas, institucion, proposito, fecha_inicio, fecha_fin, id_linea, id_anio]).draw();
                } else {
                    tablaEstanciasAcademicas.row(fila).data([id_estancias_academicas, institucion, proposito, fecha_inicio, fecha_fin, id_linea, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});