$(document).ready(function(){
    tablaAreasAcademicas = $("#tablaAreasAcademicas").DataTable({
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
        $("#formAreasAcademicas").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Área Académica");
        $("#modalCRUD").modal("show");
        id_area_academica = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_area_academica = parseInt(fila.find('td:eq(0)').text());
        area_academica = fila.find('td:eq(1)').text();

        $("#area_academica").val(area_academica);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Área Académica");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_area_academica = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_area_academica+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_areas_academicas.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_area_academica:id_area_academica},
                success: function () {
                    tablaAreasAcademicas.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formAreasAcademicas").submit(function (e) { 
        e.preventDefault();
        area_academica = $.trim($("#area_academica").val());
        $.ajax({
            url: "../controllers/crud_areas_academicas.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_area_academica:id_area_academica, area_academica:area_academica},
            success: function (data) {
                id_area_academica = data[0].id_area_academica;
                area_academica = data[0].area_academica;
                if(opcion == 1){
                    tablaAreasAcademicas.row.add([id_area_academica, area_academica]).draw();
                } else {
                    tablaAreasAcademicas.row(fila).data([id_area_academica, area_academica]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});