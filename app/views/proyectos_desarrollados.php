<?php

include("../views/layouts/header.php");
include("../controllers/conexion.php");

$sentencia_select = $conect->prepare('SELECT *FROM proyectos_desarrollados ORDER BY id_proyecto_desarrollado ASC');
$sentencia_select->execute();
$respuesta = $sentencia_select->fetchAll(PDO::FETCH_ASSOC);
//Query fuentes_financiamiento
$select_fuente_financiamiento = $conect->prepare('SELECT * FROM fuentes_financiamiento ORDER BY fuente ASC');
$select_fuente_financiamiento->execute();
$respuesta_fuente_financiamiento = $select_fuente_financiamiento->fetchAll(PDO::FETCH_ASSOC);
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
                    <li class="breadcrumb-item active">Proyectos Desarrollados</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Registros de Proyectos Desarrollados
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button id="btnNew" type="button" class="btn btn-success">Nuevo Registro</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaProyectosDesarrollados" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Título</th>
                                        <th>Fuente de Financiamiento</th>
                                        <th>Fecha de inicio</th>
                                        <th>Fecha de finalización</th>
                                        <th>Líneas</th>
                                        <th>Año</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($respuesta as $fila) : ?>
                                        <tr>
                                            <td><?php echo $fila['id_proyecto_desarrollado']; ?></td>
                                            <td><?php echo $fila['titulo']; ?></td>
                                            <td><?php echo $fila['id_fuente_financiamiento']; ?></td>
                                            <td><?php echo $fila['fecha_inicio']; ?></td>
                                            <td><?php echo $fila['fecha_fin']; ?></td>
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
                    <form id="formProyectosDesarrollados">
                        <div class="modal-body">
                        <div class="form-group">
                                <label for="titulo" class="col-form-label">Título</label>
                                <input type="text" class="form-control" name="titulo" id="titulo">
                            </div>
                            <div class="form-group">
                                <label for="id_fuente_financiamiento" class="col-form-label">Fuente de Financiamiento</label>
                                <select class="form-control" name="id_fuente_financiamiento" id="id_fuente_financiamiento">
                                    <option value="0">Seleccionar Fuente de Financiamiento</option>
                                    <?php foreach ($respuesta_fuente_financiamiento as $fila_fuente_financiamiento) :?>
                                    <option value="<?php echo $fila_fuente_financiamiento['id_fuente_financiamiento'];?>"><?php echo $fila_fuente_financiamiento['fuente'];?></option>
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
<script src="../../js/proyectos_desarrollados.js"></script>
</body>

</html>