$(document).ready(function(){
    tablaReunionesAcademicas = $("#tablaReunionesAcademicas").DataTable({
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
        $("#formReunionesAcademicas").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Reunión Académica");
        $("#modalCRUD").modal("show");
        id_reunion_academica = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_reunion_academica = parseInt(fila.find('td:eq(0)').text());
        nombre_reunion = fila.find('td:eq(1)').text();
        periodicidad = fila.find('td:eq(2)').text();
        fecha_inicio = fila.find('td:eq(3)').text();
        fecha_fin = fila.find('td:eq(4)').text();
        id_anio = parseInt(fila.find('td:eq(5)').text());

        $("#nombre_reunion").val(nombre_reunion);
        $("#periodicidad").val(periodicidad);
        $("#fecha_inicio").val(fecha_inicio);
        $("#fecha_fin").val(fecha_fin);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Reunión Académica");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_reunion_academica = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_reunion_academica+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_reuniones_academicas.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_reunion_academica:id_reunion_academica},
                success: function () {
                    tablaReunionesAcademicas.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formReunionesAcademicas").submit(function (e) { 
        e.preventDefault();
        nombre_reunion = $.trim($("#nombre_reunion").val());
        periodicidad = $.trim($("#periodicidad").val());
        fecha_inicio = $.trim($("#fecha_inicio").val());
        fecha_fin = $.trim($("#fecha_fin").val());
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_reuniones_academicas.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_reunion_academica:id_reunion_academica, nombre_reunion:nombre_reunion, periodicidad:periodicidad, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, id_anio:id_anio},
            success: function (data) {
                id_reunion_academica = data[0].id_reunion_academica;
                nombre_reunion = data[0].nombre_reunion;
                periodicidad = data[0].periodicidad;
                fecha_inicio = data[0].fecha_inicio;
                fecha_fin = data[0].fecha_fin;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaReunionesAcademicas.row.add([id_reunion_academica, nombre_reunion, periodicidad, fecha_inicio, fecha_fin, id_anio]).draw();
                } else {
                    tablaReunionesAcademicas.row(fila).data([id_reunion_academica, nombre_reunion, periodicidad, fecha_inicio, fecha_fin, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});