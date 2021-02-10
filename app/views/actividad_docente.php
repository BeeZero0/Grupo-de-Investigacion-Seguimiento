<?php

include("../views/layouts/header.php");
include("../controllers/conexion.php");

$sentencia_select = $conect->prepare('SELECT *FROM actividad_docente ORDER BY id_actividad_docente ASC');
$sentencia_select->execute();
$respuesta = $sentencia_select->fetchAll(PDO::FETCH_ASSOC);
//Query de materias
$select_materia = $conect->prepare('SELECT * FROM materias ORDER BY materia ASC');
$select_materia->execute();
$respuesta_materia = $select_materia->fetchAll(PDO::FETCH_ASSOC);
//Query programas_educativos
$select_programa_educativo = $conect->prepare('SELECT * FROM programas_educativos ORDER BY programa_educativo ASC');
$select_programa_educativo->execute();
$respuesta_programa_educativo = $select_programa_educativo->fetchAll(PDO::FETCH_ASSOC);
//Query integrantes
$select_integrante = $conect->prepare('SELECT * FROM integrantes ORDER BY nombre_integrante ASC');
$select_integrante->execute();
$respuesta_integrante = $select_integrante->fetchAll(PDO::FETCH_ASSOC);
//Query lineas
$select_linea = $conect->prepare('SELECT * FROM lineas ORDER BY linea ASC');
$select_linea->execute();
$respuesta_linea = $select_linea->fetchAll(PDO::FETCH_ASSOC);
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
                    <li class="breadcrumb-item active">Actividad Docente</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Registros de Actividad Docente
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button id="btnNew" type="button" class="btn btn-success">Nuevo Registro</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaActividadDocente" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Materia</th>
                                        <th>Programa Educativo</th>
                                        <th>Integrante</th>
                                        <th>Líneas</th>
                                        <th>Año</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($respuesta as $fila) : ?>
                                        <tr>
                                            <td><?php echo $fila['id_actividad_docente']; ?></td>
                                            <td><?php echo $fila['id_materia']; ?></td>
                                            <td><?php echo $fila['id_programa_educativo']; ?></td>
                                            <td><?php echo $fila['id_integrante']; ?></td>
                                            <td><?php echo $fila['id_linea']; ?></td>
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
                    <form id="formActividadDocente">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_materia" class="col-form-label">Materia</label>
                                <select class="form-control" name="id_materia" id="id_materia">
                                    <option value="0">Seleccionar Materia</option>
                                    <?php foreach ($respuesta_materia as $fila_materia) :?>
                                    <option value="<?php echo $fila_materia['id_materia'];?>"><?php echo $fila_materia['materia'];?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_programa_educativo" class="col-form-label">Programa Educativo</label>
                                <select class="form-control" name="id_programa_educativo" id="id_programa_educativo">
                                    <option value="0">Seleccionar Programa Educativo</option>
                                    <?php foreach ($respuesta_programa_educativo as $fila_programa_educativo) :?>
                                    <option value="<?php echo $fila_programa_educativo['id_programa_educativo'];?>"><?php echo $fila_programa_educativo['programa_educativo'];?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_integrante" class="col-form-label">Integrante</label>
                                <select class="form-control" name="id_integrante" id="id_integrante">
                                    <option value="0">Seleccionar Integrante</option>
                                    <?php foreach ($respuesta_integrante as $fila_integrante) :?>
                                    <option value="<?php echo $fila_integrante['id_integrante'];?>"><?php echo $fila_integrante['nombre_integrante'];?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_linea" class="col-form-label">Línea</label>
                                <select class="form-control" name="id_linea" id="id_linea">
                                    <option value="0">Seleccionar Línea</option>
                                    <?php foreach ($respuesta_linea as $fila_linea) :?>
                                    <option value="<?php echo $fila_linea['id_linea'];?>"><?php echo $fila_linea['linea'];?></option>
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
<script src="../../js/actividad_docente.js"></script>
</body>

</html>