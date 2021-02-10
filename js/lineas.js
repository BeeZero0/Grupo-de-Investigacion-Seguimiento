$(document).ready(function(){
    tablaLinea = $("#tablaLinea").DataTable({
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
        $("#formLinea").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva LGAIC");
        $("#modalCRUD").modal("show");
        id_linea = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_linea = parseInt(fila.find('td:eq(0)').text());
        linea = fila.find('td:eq(1)').text();
        descripcion = fila.find('td:eq(2)').text();

        $("#linea").val(linea);
        $("#descripcion").val(descripcion);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar LGAIC");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_linea = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_linea+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_lineas.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_linea:id_linea},
                success: function () {
                    tablaLinea.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formLinea").submit(function (e) { 
        e.preventDefault();
        linea = $.trim($("#linea").val());
        descripcion = $.trim($("#descripcion").val());
        $.ajax({
            url: "../controllers/crud_lineas.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_linea:id_linea, linea:linea, descripcion:descripcion},
            success: function (data) {
                id_linea = data[0].id_linea;
                linea = data[0].linea;
                descripcion = data[0].descripcion;
                if(opcion == 1){
                    tablaLinea.row.add([id_linea, linea, descripcion]).draw();
                } else {
                    tablaLinea.row(fila).data([id_linea, linea, descripcion]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});