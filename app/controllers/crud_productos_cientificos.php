<?php
include ("conexion.php");

$id_producto_cientifico = (isset($_POST['id_producto_cientifico'])) ? $_POST['id_producto_cientifico'] : '';
$id_tipo_producto = (isset($_POST['id_tipo_producto'])) ? $_POST['id_tipo_producto'] : '';
$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
$lugar = (isset($_POST['lugar'])) ? $_POST['lugar'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO productos_cientificos (id_tipo_producto, titulo, lugar, fecha, id_linea, id_anio) VALUES('$id_tipo_producto','$titulo', '$lugar', '$fecha', '$id_linea', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_producto_cientifico, id_tipo_producto, titulo, lugar, fecha, id_linea, id_anio FROM productos_cientificos ORDER BY id_producto_cientifico DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE productos_cientificos SET id_tipo_producto = '$id_tipo_producto', titulo = '$titulo', lugar = '$lugar', fecha = '$fecha', id_linea = '$id_linea', id_anio = '$id_anio' WHERE id_producto_cientifico = '$id_producto_cientifico'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_producto_cientifico, id_tipo_producto, titulo, lugar, fecha, id_linea, id_anio FROM productos_cientificos WHERE id_producto_cientifico = '$id_producto_cientifico'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM productos_cientificos WHERE id_producto_cientifico = '$id_producto_cientifico'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>