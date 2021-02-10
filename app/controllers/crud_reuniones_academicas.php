<?php
include ("conexion.php");

$id_reunion_academica = (isset($_POST['id_reunion_academica'])) ? $_POST['id_reunion_academica'] : '';
$nombre_reunion = (isset($_POST['nombre_reunion'])) ? $_POST['nombre_reunion'] : '';
$periodicidad = (isset($_POST['periodicidad'])) ? $_POST['periodicidad'] : '';
$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';
$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO reuniones_academicas (nombre_reunion, periodicidad, fecha_inicio, fecha_fin, id_anio) VALUES('$nombre_reunion', '$periodicidad', '$fecha_inicio', '$fecha_fin', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_reunion_academica, nombre_reunion, periodicidad, fecha_inicio, fecha_fin, id_anio FROM reuniones_academicas ORDER BY id_reunion_academica DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE reuniones_academicas SET nombre_reunion = '$nombre_reunion', periodicidad = '$periodicidad', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', id_anio = '$id_anio' WHERE id_reunion_academica = '$id_reunion_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_reunion_academica, nombre_reunion, periodicidad, fecha_inicio, fecha_fin, id_anio FROM reuniones_academicas WHERE id_reunion_academica = '$id_reunion_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM reuniones_academicas WHERE id_reunion_academica = '$id_reunion_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>