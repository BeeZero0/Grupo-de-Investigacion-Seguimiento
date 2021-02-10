<?php
include ("conexion.php");

$id_estancias_academicas = (isset($_POST['id_estancias_academicas'])) ? $_POST['id_estancias_academicas'] : '';
$institucion = (isset($_POST['institucion'])) ? $_POST['institucion'] : '';
$proposito = (isset($_POST['proposito'])) ? $_POST['proposito'] : '';
$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';
$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';
$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO estancias_academicas (institucion, proposito, fecha_inicio, fecha_fin, id_linea, id_anio) VALUES('$institucion', '$proposito', '$fecha_inicio', '$fecha_fin', '$id_linea', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_estancias_academicas, institucion, proposito, fecha_inicio, fecha_fin, id_linea, id_anio FROM estancias_academicas ORDER BY id_estancias_academicas DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE estancias_academicas SET institucion = '$institucion', proposito = '$proposito', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', id_linea = '$id_linea', id_anio = '$id_anio' WHERE id_estancias_academicas = '$id_estancias_academicas'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_estancias_academicas, institucion, proposito, fecha_inicio, fecha_fin, id_linea, id_anio FROM estancias_academicas WHERE id_estancias_academicas = '$id_estancias_academicas'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM estancias_academicas WHERE id_estancias_academicas = '$id_estancias_academicas'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>