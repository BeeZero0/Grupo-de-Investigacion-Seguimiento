$(document).ready(function(){
    tablaFuentesFinanciamiento = $("#tablaFuentesFinanciamiento").DataTable({
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
        $("#formFuentesFinanciamiento").trigger("reset");
        $(".modal-header").css("background-color", "#28A745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Fuente de Financiamiento");
        $("#modalCRUD").modal("show");
        id_fuente_financiamiento = null;
        opcion = 1;
    });

    let fila;
    //Botón editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id_fuente_financiamiento = parseInt(fila.find('td:eq(0)').text());
        fuente = fila.find('td:eq(1)').text();

        $("#fuente").val(fuente);
        opcion = 2;

        $(".modal-header").css("background-color", "#007BFF");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Fuente de Financiamiento");
        $("#modalCRUD").modal("show");
    });

    //Botón borrar
    $(document).on("click", ".btnEliminar", function(){
        fila = $(this);
        id_fuente_financiamiento = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;

        let respuesta = confirm("¿Está seguro de eliminar el registro "+id_fuente_financiamiento+ "?");
        if(respuesta){
            $.ajax({
                url: "../controllers/crud_fuentes_financiamiento.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, id_fuente_financiamiento:id_fuente_financiamiento},
                success: function () {
                    tablaFuentesFinanciamiento.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formFuentesFinanciamiento").submit(function (e) { 
        e.preventDefault();
        fuente = $.trim($("#fuente").val());
        $.ajax({
            url: "../controllers/crud_fuentes_financiamiento.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_fuente_financiamiento:id_fuente_financiamiento, fuente:fuente},
            success: function (data) {
                id_fuente_financiamiento = data[0].id_fuente_financiamiento;
                fuente = data[0].fuente;
                if(opcion == 1){
                    tablaFuentesFinanciamiento.row.add([id_fuente_financiamiento, fuente]).draw();
                } else {
                    tablaFuentesFinanciamiento.row(fila).data([id_fuente_financiamiento, fuente]).draw();
                }
            }
        });
        $("#modalCRUD").modal("hide");
    });
});