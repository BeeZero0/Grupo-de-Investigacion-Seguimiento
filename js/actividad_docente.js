$(document).ready(function(){
    tablaActividadDocente = $("#tablaActividadDocente").DataTable({
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
        $("#formActividadDocente").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Actividad Docente");
        $("#modalCRUD").modal("show");
        id_actividad_docente = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_actividad_docente = parseInt(fila.find('td:eq(0)').text());
        id_materia = parseInt(fila.find('td:eq(1)').text());
        id_programa_educativo = parseInt(fila.find('td:eq(2)').text());
        id_integrante = parseInt(fila.find('td:eq(3)').text());
        id_linea = parseInt(fila.find('td:eq(4)').text());
        id_anio = parseInt(fila.find('td:eq(5)').text());

        $("#id_materia").val(id_materia);
        $("#id_programa_educativo").val(id_programa_educativo);
        $("#id_integrante").val(id_integrante);
        $("#id_linea").val(id_linea);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Actividad Docente");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_actividad_docente = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_actividad_docente+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_actividad_docente.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_actividad_docente:id_actividad_docente},
                success: function () {
                    tablaActividadDocente.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formActividadDocente").submit(function (e) { 
        e.preventDefault();
        id_materia = parseInt($.trim($("#id_materia").val()));
        id_programa_educativo = parseInt($.trim($("#id_programa_educativo").val()));
        id_integrante = parseInt($.trim($("#id_integrante").val()));
        id_linea = parseInt($.trim($("#id_linea").val()));
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_actividad_docente.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_actividad_docente:id_actividad_docente, id_materia:id_materia, id_programa_educativo:id_programa_educativo, id_integrante:id_integrante, id_linea:id_linea, id_anio:id_anio},
            success: function (data) {
                id_actividad_docente = data[0].id_actividad_docente;
                id_materia = data[0].id_materia;
                id_programa_educativo = data[0].id_programa_educativo;
                id_integrante = data[0].id_integrante;
                id_linea = data[0].id_linea;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaActividadDocente.row.add([id_actividad_docente, id_materia, id_programa_educativo, id_integrante, id_linea, id_anio]).draw();
                } else {
                    tablaActividadDocente.row(fila).data([id_actividad_docente, id_materia, id_programa_educativo, id_integrante, id_linea, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});