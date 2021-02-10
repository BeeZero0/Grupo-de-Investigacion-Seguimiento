$(document).ready(function(){
    tablaProyectosDesarrollados = $("#tablaProyectosDesarrollados").DataTable({
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
        $("#formProyectosDesarrollados").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Proyecto");
        $("#modalCRUD").modal("show");
        id_proyecto_desarrollado = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_proyecto_desarrollado = parseInt(fila.find('td:eq(0)').text());
        titulo = fila.find('td:eq(1)').text();
        id_fuente_financiamiento = parseInt(fila.find('td:eq(2)').text());
        fecha_inicio = fila.find('td:eq(3)').text();
        fecha_fin = fila.find('td:eq(4)').text();
        id_linea = parseInt(fila.find('td:eq(5)').text());
        id_anio = parseInt(fila.find('td:eq(6)').text());

        $("#titulo").val(titulo);
        $("#id_fuente_financiamiento").val(id_fuente_financiamiento);
        $("#fecha_inicio").val(fecha_inicio);
        $("#fecha_fin").val(fecha_fin);
        $("#id_linea").val(id_linea);
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
        id_proyecto_desarrollado = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_proyecto_desarrollado+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_proyectos_desarrollados.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_proyecto_desarrollado:id_proyecto_desarrollado},
                success: function () {
                    tablaProyectosDesarrollados.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formProyectosDesarrollados").submit(function (e) { 
        e.preventDefault();
        titulo = $.trim($("#titulo").val());
        id_fuente_financiamiento = parseInt($.trim($("#id_fuente_financiamiento").val()));
        fecha_inicio = $.trim($("#fecha_inicio").val());
        fecha_fin = $.trim($("#fecha_fin").val());
        id_linea = parseInt($.trim($("#id_linea").val()));
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_proyectos_desarrollados.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_proyecto_desarrollado:id_proyecto_desarrollado, titulo:titulo, id_fuente_financiamiento:id_fuente_financiamiento, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, id_linea:id_linea, id_anio:id_anio},
            success: function (data) {
                id_proyecto_desarrollado = data[0].id_proyecto_desarrollado;
                titulo = data[0].titulo;
                id_fuente_financiamiento = data[0].id_fuente_financiamiento;
                fecha_inicio = data[0].fecha_inicio;
                fecha_fin = data[0].fecha_fin;
                id_linea = data[0].id_linea;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaProyectosDesarrollados.row.add([id_proyecto_desarrollado, titulo, id_fuente_financiamiento, fecha_inicio, fecha_fin, id_linea, id_anio]).draw();
                } else {
                    tablaProyectosDesarrollados.row(fila).data([id_proyecto_desarrollado, titulo, id_fuente_financiamiento, fecha_inicio, fecha_fin, id_linea, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});