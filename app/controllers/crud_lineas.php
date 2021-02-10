<?php
include ("conexion.php");

$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$linea = (isset($_POST['linea'])) ? $_POST['linea'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO lineas (linea, descripcion) VALUES('$linea', '$descripcion')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_linea, linea, descripcion FROM lineas ORDER BY id_linea DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE lineas SET linea = '$linea', descripcion = '$descripcion' WHERE id_linea = '$id_linea'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_linea, linea, descripcion FROM lineas WHERE id_linea = '$id_linea'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM lineas WHERE id_linea = '$id_linea'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>