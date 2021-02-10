<?php
include ("conexion.php");

$id_area_interes = (isset($_POST['id_area_interes'])) ? $_POST['id_area_interes'] : '';
$area_interes = (isset($_POST['area_interes'])) ? $_POST['area_interes'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO areas_interes (area_interes) VALUES('$area_interes')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_area_interes, area_interes FROM areas_interes ORDER BY id_area_interes DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE areas_interes SET area_interes = '$area_interes' WHERE id_area_interes = '$id_area_interes'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_area_interes, area_interes FROM areas_interes WHERE id_area_interes = '$id_area_interes'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM areas_interes WHERE id_area_interes = '$id_area_interes'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>