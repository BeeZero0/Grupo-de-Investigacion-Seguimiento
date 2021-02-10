$(document).ready(function(){
    tablaAreasInteres = $("#tablaAreasInteres").DataTable({
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
        $("#formAreasInteres").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Área de Interés");
        $("#modalCRUD").modal("show");
        id_area_interes = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_area_interes = parseInt(fila.find('td:eq(0)').text());
        area_interes = fila.find('td:eq(1)').text();

        $("#area_interes").val(area_interes);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Área de Interés");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_area_interes = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_area_interes+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_areas_interes.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_area_interes:id_area_interes},
                success: function () {
                    tablaAreasInteres.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formAreasInteres").submit(function (e) { 
        e.preventDefault();
        area_interes = $.trim($("#area_interes").val());
        $.ajax({
            url: "../controllers/crud_areas_interes.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_area_interes:id_area_interes, area_interes:area_interes},
            success: function (data) {
                id_area_interes = data[0].id_area_interes;
                area_interes = data[0].area_interes;
                if(opcion == 1){
                    tablaAreasInteres.row.add([id_area_interes, area_interes]).draw();
                } else {
                    tablaAreasInteres.row(fila).data([id_area_interes, area_interes]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});