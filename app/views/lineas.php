<?php

include("../views/layouts/header.php");
include("../controllers/conexion.php");

$sentencia_select = $conect->prepare('SELECT *FROM lineas ORDER BY id_linea ASC');
$sentencia_select->execute();
$respuesta = $sentencia_select->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="layoutSidenav">
    <?php include("../views/layouts/sidebar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Catálogos para Investigadores</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">LGAIC</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Listado de LGAIC
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button id="btnNew" type="button" class="btn btn-success">Nuevo Registro</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaLinea" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Linea</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($respuesta as $fila) : ?>
                                        <tr>
                                            <td><?php echo $fila['id_linea']; ?></td>
                                            <td><?php echo $fila['linea']; ?></td>
                                            <td><?php echo $fila['descripcion']; ?></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!--Modal CRUD-->
        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="formLinea">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="linea" class="col-form-label">Linea</label>
                                <input type="text" class="form-control" name="linea" id="linea">
                            </div>
                            <div class="form-group">
                                <label for="linea" class="col-form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include("../views/layouts/footer.php"); ?>
    </div>
</div>
<?php include("../views/layouts/scripts.php") ?>
<script src="../../js/lineas.js"></script>
</body>

</html>