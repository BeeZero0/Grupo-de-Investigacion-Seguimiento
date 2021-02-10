$(document).ready(function(){
    tablaProgramaEducativo = $("#tablaProgramaEducativo").DataTable({
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
        $("#formProgramaEducativo").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Programa Educativo");
        $("#modalCRUD").modal("show");
        id_programa_educativo = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_programa_educativo = parseInt(fila.find('td:eq(0)').text());
        programa_educativo = fila.find('td:eq(1)').text();

        $("#programa_educativo").val(programa_educativo);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Programa Educativo");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_programa_educativo = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_programa_educativo+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_programas_educativos.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_programa_educativo:id_programa_educativo},
                success: function () {
                    tablaProgramaEducativo.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formProgramaEducativo").submit(function (e) { 
        e.preventDefault();
        programa_educativo = $.trim($("#programa_educativo").val());
        $.ajax({
            url: "../controllers/crud_programas_educativos.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_programa_educativo:id_programa_educativo, programa_educativo:programa_educativo},
            success: function (data) {
                id_programa_educativo = data[0].id_programa_educativo;
                programa_educativo = data[0].programa_educativo;
                if(opcion == 1){
                    tablaProgramaEducativo.row.add([id_programa_educativo, programa_educativo]).draw();
                } else {
                    tablaProgramaEducativo.row(fila).data([id_programa_educativo, programa_educativo]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});