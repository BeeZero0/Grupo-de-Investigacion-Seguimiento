$(document).ready(function(){
    tablaGradosAcademicos = $("#tablaGradosAcademicos").DataTable({
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
        $("#formGradosAcademicos").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Grado Académico");
        $("#modalCRUD").modal("show");
        id_grado_academico = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_grado_academico = parseInt(fila.find('td:eq(0)').text());
        grado_academico = fila.find('td:eq(1)').text();

        $("#grado_academico").val(grado_academico);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Grado Académico");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_grado_academico = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_grado_academico+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_grados_academicos.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_grado_academico:id_grado_academico},
                success: function () {
                    tablaGradosAcademicos.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formGradosAcademicos").submit(function (e) { 
        e.preventDefault();
        grado_academico = $.trim($("#grado_academico").val());
        $.ajax({
            url: "../controllers/crud_grados_academicos.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_grado_academico:id_grado_academico, grado_academico:grado_academico},
            success: function (data) {
                id_grado_academico = data[0].id_grado_academico;
                grado_academico = data[0].grado_academico;
                if(opcion == 1){
                    tablaGradosAcademicos.row.add([id_grado_academico, grado_academico]).draw();
                } else {
                    tablaGradosAcademicos.row(fila).data([id_grado_academico, grado_academico]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});