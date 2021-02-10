$(document).ready(function(){
    tablaObjetivos = $("#tablaObjetivos").DataTable({
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
        $("#formObjetivos").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Objetivo");
        $("#modalCRUD").modal("show");
        id_objetivo = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_objetivo = parseInt(fila.find('td:eq(0)').text());
        objetivo = fila.find('td:eq(1)').text();
        descripcion = fila.find('td:eq(2)').text();

        $("#objetivo").val(objetivo);
        $("#descripcion").val(descripcion);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Objetivo");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_objetivo = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_objetivo+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_objetivos.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_objetivo:id_objetivo},
                success: function () {
                    tablaObjetivos.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formObjetivos").submit(function (e) { 
        e.preventDefault();
        objetivo = $.trim($("#objetivo").val());
        descripcion = $.trim($("#descripcion").val());
        $.ajax({
            url: "../controllers/crud_objetivos.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_objetivo:id_objetivo, objetivo:objetivo, descripcion:descripcion},
            success: function (data) {
                id_objetivo = data[0].id_objetivo;
                objetivo = data[0].objetivo;
                descripcion = data[0].descripcion;
                if(opcion == 1){
                    tablaObjetivos.row.add([id_objetivo, objetivo, descripcion]).draw();
                } else {
                    tablaObjetivos.row(fila).data([id_objetivo, objetivo, descripcion]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});