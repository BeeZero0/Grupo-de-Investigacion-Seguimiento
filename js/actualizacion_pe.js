$(document).ready(function(){
    tablaActualizacionPE = $("#tablaActualizacionPE").DataTable({
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
        $("#formActualizacionPE").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Actualización de PE");
        $("#modalCRUD").modal("show");
        id_actualizacion_pe = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_actualizacion_pe = parseInt(fila.find('td:eq(0)').text());
        id_programa_educativo = parseInt(fila.find('td:eq(1)').text());
        fecha_implementacion = fila.find('td:eq(2)').text();
        id_anio = parseInt(fila.find('td:eq(3)').text());

        $("#id_programa_educativo").val(id_programa_educativo);
        $("#fecha_implementacion").val(fecha_implementacion);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Actualización PE");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_actualizacion_pe = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_actualizacion_pe+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_actualizacion_pe.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_actualizacion_pe:id_actualizacion_pe},
                success: function () {
                    tablaActualizacionPE.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formActualizacionPE").submit(function (e) { 
        e.preventDefault();
        id_programa_educativo = parseInt($.trim($("#id_programa_educativo").val()));
        fecha_implementacion = $.trim($("#fecha_implementacion").val());
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_actualizacion_pe.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_actualizacion_pe:id_actualizacion_pe, id_programa_educativo:id_programa_educativo, fecha_implementacion:fecha_implementacion, id_anio:id_anio},
            success: function (data) {
                id_actualizacion_pe = data[0].id_actualizacion_pe;
                id_programa_educativo = data[0].id_programa_educativo;
                fecha_implementacion = data[0].fecha_implementacion;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaActualizacionPE.row.add([id_actualizacion_pe, id_programa_educativo, fecha_implementacion, id_anio]).draw();
                } else {
                    tablaActualizacionPE.row(fila).data([id_actualizacion_pe, id_programa_educativo, fecha_implementacion, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});