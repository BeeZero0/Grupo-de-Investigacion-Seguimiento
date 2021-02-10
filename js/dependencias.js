$(document).ready(function(){
    tablaDependencia = $("#tablaDependencia").DataTable({
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
        $("#formDependencias").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Dependencia");
        $("#modalCRUD").modal("show");
        id_dependencia = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_dependencia = parseInt(fila.find('td:eq(0)').text());
        dependencia = fila.find('td:eq(1)').text();

        $("#dependencia").val(dependencia);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Dependencia");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_dependencia = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_dependencia+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_dependencias.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_dependencia:id_dependencia},
                success: function () {
                    tablaDependencia.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formDependencias").submit(function (e) { 
        e.preventDefault();
        dependencia = $.trim($("#dependencia").val());
        $.ajax({
            url: "../controllers/crud_dependencias.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_dependencia:id_dependencia, dependencia:dependencia},
            success: function (data) {
                id_dependencia = data[0].id_dependencia;
                dependencia = data[0].dependencia;
                if(opcion == 1){
                    tablaDependencia.row.add([id_dependencia, dependencia]).draw();
                } else {
                    tablaDependencia.row(fila).data([id_dependencia, dependencia]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});