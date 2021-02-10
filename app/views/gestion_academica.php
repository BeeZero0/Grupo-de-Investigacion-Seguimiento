<?php

include("../views/layouts/header.php");
include("../controllers/conexion.php");

$sentencia_select = $conect->prepare('SELECT * FROM gestion_academica ORDER BY id_gestion_academica ASC');
$sentencia_select->execute();
$respuesta = $sentencia_select->fetchAll(PDO::FETCH_ASSOC);
//Tipo gestion
$sentencia_tipo_gestion = $conect->prepare('SELECT * FROM tipos_gestion ORDER BY tipo_gestion ASC');
$sentencia_tipo_gestion->execute();
$respuesta_tipo_gestion = $sentencia_tipo_gestion->fetchAll(PDO::FETCH_ASSOC);
//Query anio
$select_anio = $conect->prepare('SELECT id_anio, anio FROM anios ORDER BY anio ASC');
$select_anio->execute();
$respuesta_anio = $select_anio->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="layoutSidenav">
    <?php include("../views/layouts/sidebar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Registros</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Gestión Académica</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Registros de Gestión Académica
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button id="btnNew" type="button" class="btn btn-success">Nuevo Registro</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaGestionAcademica" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Responsabilidad</th>
                                        <th>Funcion encomendada</th>
                                        <th>Tipo de Gestión</th>
                                        <th>Año</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($respuesta as $fila) : ?>
                                        <tr>
                                            <td><?php echo $fila['id_gestion_academica']; ?></td>
                                            <td><?php echo $fila['responsabilidad']; ?></td>
                                            <td><?php echo $fila['funcion_encomendada']; ?></td>
                                            <td><?php echo $fila['id_tipo_gestion']; ?></td>
                                            <td><?php echo $fila['id_anio']; ?></td>
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
                    <form id="formGestionAcademica">
                        <div class="modal-body">
            
                        <div class="form-group">
                                <label for="responsabilidad" class="col-form-label">Responsabilidad</label>
                                <input type="text" class="form-control" name="responsabilidad" id="responsabilidad">
                            </div>
                            <div class="form-group">
                                <label for="funcion_encomendada" class="col-form-label">Función Encomendada</label>
                                <input type="text" class="form-control" name="funcion_encomendada" id="funcion_encomendada">
                            </div>

                            <div class="form-group">
                                <label for="id_tipo_gestion" class="col-form-label">Típo de gestión</label>
                                <select class="form-control" name="id_tipo_gestion" id="id_tipo_gestion">
                                    <option value="0">Seleccionar Gestión</option>
                                    <?php foreach ($respuesta_tipo_gestion as $fila_gestion) :?>
                                    <option value="<?php echo $fila_gestion['id_tipo_gestion'];?>"><?php echo $fila_gestion['tipo_gestion'];?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_anio" class="col-form-label">Año</label>
                                <select class="form-control" name="id_anio" id="id_anio">
                                    <option value="0">Seleccionar Año</option>
                                    <?php foreach ($respuesta_anio as $fila_anio) :?>
                                    <option value="<?php echo $fila_anio['id_anio'];?>"><?php echo $fila_anio['anio'];?></option>
                                    <?php endforeach ?>
                                </select>
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
<script src="../../js/gestion_academica.js"></script>
</body>

</html>