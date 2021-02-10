$(document).ready(function(){
    tablaAnios = $("#tablaAnios").DataTable({
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
        $("#formAnios").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Año");
        $("#modalCRUD").modal("show");
        id_anio = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_anio = parseInt(fila.find('td:eq(0)').text());
        anio = parseInt(fila.find('td:eq(1)').text());

        $("#anio").val(anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Año");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_anio = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_anio+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_anios.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_anio:id_anio},
                success: function () {
                    tablaAnios.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formAnios").submit(function (e) { 
        e.preventDefault();
        anio = $.trim($("#anio").val());
        $.ajax({
            url: "../controllers/crud_anios.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_anio:id_anio, anio:anio},
            success: function (data) {
                id_anio = data[0].id_anio;
                anio = data[0].anio;
                if(opcion == 1){
                    tablaAnios.row.add([id_anio, anio]).draw();
                } else {
                    tablaAnios.row(fila).data([id_anio, anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});