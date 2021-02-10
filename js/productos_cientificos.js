$(document).ready(function(){
    tablaProductosCientificos = $("#tablaProductosCientificos").DataTable({
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
        $("#formProductosCientificos").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Producto Científicco");
        $("#modalCRUD").modal("show");
        id_producto_cientifico = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_producto_cientifico = parseInt(fila.find('td:eq(0)').text());
        id_tipo_producto = parseInt(fila.find('td:eq(1)').text());
        titulo = fila.find('td:eq(2)').text();
        lugar = fila.find('td:eq(3)').text();
        fecha = fila.find('td:eq(4)').text();
        id_linea = parseInt(fila.find('td:eq(5)').text());
        id_anio = parseInt(fila.find('td:eq(6)').text());

        $("#id_tipo_producto").val(id_tipo_producto);
        $("#titulo").val(titulo);
        $("#lugar").val(lugar);
        $("#fecha").val(fecha);
        $("#id_linea").val(id_linea);
        $("#id_anio").val(id_anio);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Producto Científico");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_producto_cientifico = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_producto_cientifico+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_productos_cientificos.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_producto_cientifico:id_producto_cientifico},
                success: function () {
                    tablaProductosCientificos.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formProductosCientificos").submit(function (e) { 
        e.preventDefault();
        id_tipo_producto = parseInt($.trim($("#id_tipo_producto").val()));
        titulo = $.trim($("#titulo").val());
        lugar = $.trim($("#lugar").val());
        fecha = $.trim($("#fecha").val());
        id_linea = parseInt($.trim($("#id_linea").val()));
        id_anio = parseInt($.trim($("#id_anio").val()));
        $.ajax({
            url: "../controllers/crud_productos_cientificos.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_producto_cientifico:id_producto_cientifico, id_tipo_producto:id_tipo_producto, titulo:titulo, lugar:lugar, fecha:fecha, id_linea:id_linea, id_anio:id_anio},
            success: function (data) {
                id_producto_cientifico = data[0].id_producto_cientifico;
                id_tipo_producto = data[0].id_tipo_producto;
                titulo = data[0].titulo;
                lugar = data[0].lugar;
                fecha = data[0].fecha;
                id_linea = data[0].id_linea;
                id_anio = data[0].id_anio;
                if(opcion == 1){
                    tablaProductosCientificos.row.add([id_producto_cientifico, id_tipo_producto, titulo, lugar, fecha, id_linea, id_anio]).draw();
                } else {
                    tablaProductosCientificos.row(fila).data([id_producto_cientifico, id_tipo_producto, titulo, lugar, fecha, id_linea, id_anio]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});