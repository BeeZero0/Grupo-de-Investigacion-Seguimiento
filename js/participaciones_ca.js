$(document).ready(function(){
    tablaParticipacionesCA = $("#tablaParticipacionesCA").DataTable({
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
        $("#formParticipacionesCA").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Participación");
        $("#modalCRUD").modal("show");
        id_participacion_ca = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_participacion_ca = parseInt(fila.find('td:eq(0)').text());
        nombre_participacion = fila.find('td:eq(1)').text();
        id_tipo_participacion_ca = parseInt(fila.find('td:eq(2)').text());
        fecha_inicio = fila.find('td:eq(3)').text();
        fecha_fin = fila.find('td:eq(4)').text();
        id_anio = parseInt(fila.find('td:eq(5)').text());

        $("#nombre_participacion").val(nombre_participacion);
        $("#id_tipo_participacion_ca").val(id_tipo_participacion_ca);
        $("#fecha_inicio").val(fecha_inicio);
        $("#fecha_fin").val(fecha_fin);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Proyecto Desarrollado");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_participacion_ca = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_participacion_ca+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_participaciones_ca.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_participacion_ca:id_participacion_ca},
                success: function () {
                    tablaParticipacionesCA.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formParticipacionesCA").submit(function (e) { 
        e.preventDefault();
        nombre_participacion = $.trim($("#nombre_participacion").val());
        id_tipo_participacion_ca = parseInt($.trim($("#id_tipo_participacion_ca").val()));
        fecha_inicio = $.trim($("#fecha_inicio").val());
        fecha_fin = $.trim($("#fecha_fin").val());
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_participaciones_ca.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_participacion_ca:id_participacion_ca, nombre_participacion:nombre_participacion, id_tipo_participacion_ca:id_tipo_participacion_ca, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, id_anio:id_anio},
            success: function (data) {
                id_participacion_ca = data[0].id_participacion_ca;
                nombre_participacion = data[0].nombre_participacion;
                id_tipo_participacion_ca = data[0].id_tipo_participacion_ca;
                fecha_inicio = data[0].fecha_inicio;
                fecha_fin = data[0].fecha_fin;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaParticipacionesCA.row.add([id_participacion_ca, nombre_participacion, id_tipo_participacion_ca, fecha_inicio, fecha_fin, id_anio]).draw();
                } else {
                    tablaParticipacionesCA.row(fila).data([id_participacion_ca, nombre_participacion, id_tipo_participacion_ca, fecha_inicio, fecha_fin, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});