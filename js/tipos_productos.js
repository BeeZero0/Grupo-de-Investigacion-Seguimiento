$(document).ready(function(){
    tablaTiposProductos = $("#tablaTiposProductos").DataTable({
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
        $("#formTiposProductos").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Tipo de Productos");
        $("#modalCRUD").modal("show");
        id_tipo_producto = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_tipo_producto = parseInt(fila.find('td:eq(0)').text());
        tipo_producto = fila.find('td:eq(1)').text();

        $("#tipo_producto").val(tipo_producto);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Tipo de Producto");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_tipo_producto = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_tipo_producto+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_tipos_productos.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_tipo_producto:id_tipo_producto},
                success: function () {
                    tablaTiposProductos.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formTiposProductos").submit(function (e) { 
        e.preventDefault();
        tipo_producto = $.trim($("#tipo_producto").val());
        $.ajax({
            url: "../controllers/crud_tipos_productos.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_tipo_producto:id_tipo_producto, tipo_producto:tipo_producto},
            success: function (data) {
                id_tipo_producto = data[0].id_tipo_producto;
                tipo_producto = data[0].tipo_producto;
                if(opcion == 1){
                    tablaTiposProductos.row.add([id_tipo_producto, tipo_producto]).draw();
                } else {
                    tablaTiposProductos.row(fila).data([id_tipo_producto, tipo_producto]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});