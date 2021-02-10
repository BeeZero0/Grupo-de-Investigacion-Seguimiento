$(document).ready(function(){
    tablaTiposTutelaje = $("#tablaTiposTutelaje").DataTable({
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
        $("#formTiposTutelaje").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Tipo de Tutelaje");
        $("#modalCRUD").modal("show");
        id_tipo_tutelaje = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_tipo_tutelaje = parseInt(fila.find('td:eq(0)').text());
        tipo_tutelaje = fila.find('td:eq(1)').text();

        $("#tipo_tutelaje").val(tipo_tutelaje);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Tipo de Tutelaje");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_tipo_tutelaje = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_tipo_tutelaje+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_tipos_tutelaje.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_tipo_tutelaje:id_tipo_tutelaje},
                success: function () {
                    tablaTiposTutelaje.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formTiposTutelaje").submit(function (e) { 
        e.preventDefault();
        tipo_tutelaje = $.trim($("#tipo_tutelaje").val());
        $.ajax({
            url: "../controllers/crud_tipos_tutelaje.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_tipo_tutelaje:id_tipo_tutelaje, tipo_tutelaje:tipo_tutelaje},
            success: function (data) {
                id_tipo_tutelaje = data[0].id_tipo_tutelaje;
                tipo_tutelaje = data[0].tipo_tutelaje;
                if(opcion == 1){
                    tablaTiposTutelaje.row.add([id_tipo_tutelaje, tipo_tutelaje]).draw();
                } else {
                    tablaTiposTutelaje.row(fila).data([id_tipo_tutelaje, tipo_tutelaje]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});