<?php
include ("conexion.php");

$id_proyecto_desarrollado = (isset($_POST['id_proyecto_desarrollado'])) ? $_POST['id_proyecto_desarrollado'] : '';
$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
$id_fuente_financiamiento = (isset($_POST['id_fuente_financiamiento'])) ? $_POST['id_fuente_financiamiento'] : '';
$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';
$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO proyectos_desarrollados (titulo, id_fuente_financiamiento, fecha_inicio, fecha_fin, id_linea, id_anio) VALUES('$titulo', '$id_fuente_financiamiento', '$fecha_inicio', '$fecha_fin', '$id_linea', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_proyecto_desarrollado, titulo, id_fuente_financiamiento, fecha_inicio, fecha_fin, id_linea, id_anio FROM proyectos_desarrollados ORDER BY id_proyecto_desarrollado DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE proyectos_desarrollados SET titulo = '$titulo', id_fuente_financiamiento = '$id_fuente_financiamiento', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', id_linea = '$id_linea', id_anio = '$id_anio' WHERE id_proyecto_desarrollado = '$id_proyecto_desarrollado'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_proyecto_desarrollado, titulo, id_fuente_financiamiento, fecha_inicio, fecha_fin, id_linea, id_anio FROM proyectos_desarrollados WHERE id_proyecto_desarrollado = '$id_proyecto_desarrollado'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM proyectos_desarrollados WHERE id_proyecto_desarrollado = '$id_proyecto_desarrollado'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>