<?php
include ("conexion.php");

$id_area_academica = (isset($_POST['id_area_academica'])) ? $_POST['id_area_academica'] : '';
$area_academica = (isset($_POST['area_academica'])) ? $_POST['area_academica'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO areas_academicas (area_academica) VALUES('$area_academica')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_area_academica, area_academica FROM areas_academicas ORDER BY id_area_academica DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE areas_academicas SET area_academica = '$area_academica' WHERE id_area_academica = '$id_area_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_area_academica, area_academica FROM areas_academicas WHERE id_area_academica = '$id_area_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM areas_academicas WHERE id_area_academica = '$id_area_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>