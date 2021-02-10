<?php
include ("conexion.php");

$id_tipo_producto = (isset($_POST['id_tipo_producto'])) ? $_POST['id_tipo_producto'] : '';
$tipo_producto = (isset($_POST['tipo_producto'])) ? $_POST['tipo_producto'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO tipos_productos (tipo_producto) VALUES('$tipo_producto')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_producto, tipo_producto FROM tipos_productos ORDER BY id_tipo_producto DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE tipos_productos SET tipo_producto = '$tipo_producto' WHERE id_tipo_producto = '$id_tipo_producto'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_producto, tipo_producto FROM tipos_productos WHERE id_tipo_producto = '$id_tipo_producto'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM tipos_productos WHERE id_tipo_producto = '$id_tipo_producto'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>