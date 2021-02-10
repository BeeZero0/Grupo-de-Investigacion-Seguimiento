<?php

include("../views/layouts/header.php");
include("../controllers/conexion.php");

$sentencia_select = $conect->prepare('SELECT *FROM proyectos_desarrollados ORDER BY id_participacion_ca ASC');
$sentencia_select->execute();
$respuesta = $sentencia_select->fetchAll(PDO::FETCH_ASSOC);
// Query Participacion
$select_tipo_participacion_ca = $conect->prepare('SELECT *FROM tipo_participacion_ca ORDER BY id_tipo_participacion_ca ASC');
$select_tipo_participacion_ca->execute();
$respuesta_tipo_participacion_ca = $select_tipo_participacion_ca->fetchAll(PDO::FETCH_ASSOC);
//Query integrantes
$select_integrante = $conect->prepare('SELECT * FROM integrantes ORDER BY nombre_integrante ASC');
$select_integrante->execute();
$respuesta_integrante = $select_integrante->fetchAll(PDO::FETCH_ASSOC);

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
                    <li class="breadcrumb-item active">Participaciones con otros CA</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Registros de Participaciones con otros CA
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button id="btnNew" type="button" class="btn btn-success">Nuevo Registro</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaParticipacionesCA" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre de la Participación</th>
                                        <th>Tipo de Participación</th>
                                        <th>Fecha de inicio</th>
                                        <th>Fecha de finalización</th>
                                        <th>Año</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($respuesta as $fila) : ?>
                                        <tr>
                                            <td><?php echo $fila['id_participacion_ca']; ?></td>
                                            <td><?php echo $fila['nombre_participacion']; ?></td>
                                            <td><?php echo $fila['id_tipo_participacion_ca']; ?></td>
                                            <td><?php echo $fila['fecha_inicio']; ?></td>
                                            <td><?php echo $fila['fecha_fin']; ?></td>
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
                    <form id="formParticipacionesCA">
                        <div class="modal-body">
                        <div class="form-group">
                                <label for="nombre_participacion" class="col-form-label">Nombre de la Participación</label>
                                <input type="text" class="form-control" name="nombre_participacion" id="nombre_participacion">
                            </div>
                            <div class="form-group">
                                <label for="id_tipo_participacion_ca" class="col-form-label">Tipo de Particpación</label>
                                <select class="form-control" name="id_tipo_participacion_ca" id="id_tipo_participacion_ca">
                                    <option value="0">Seleccionar un Tipo de Participación</option>
                                    <?php foreach ($respuesta_tipo_participacion_ca as $fila_tipo_participacion_ca) :?>
                                    <option value="<?php echo $fila_tipo_participacion_ca['id_tipo_participacion_ca'];?>"><?php echo $fila_tipo_participacion_ca['tipo_participacion_ca'];?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio" class="col-form-label">Fecha de inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin" class="col-form-label">Fecha de finalización</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
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
<script src="../../js/participaciones_ca.js"></script>
</body>

</html>