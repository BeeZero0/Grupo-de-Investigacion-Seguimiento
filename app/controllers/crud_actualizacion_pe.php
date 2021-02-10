<?php
include ("conexion.php");

$id_actualizacion_pe = (isset($_POST['id_actualizacion_pe'])) ? $_POST['id_actualizacion_pe'] : '';
$id_programa_educativo = (isset($_POST['id_programa_educativo'])) ? $_POST['id_programa_educativo'] : '';
$fecha_implementacion = (isset($_POST['fecha_implementacion'])) ? $_POST['fecha_implementacion'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO actualizacion_pe (id_programa_educativo, fecha_implementacion, id_anio) VALUES('$id_programa_educativo', '$fecha_implementacion', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_actualizacion_pe, id_programa_educativo, fecha_implementacion, id_anio FROM actualizacion_pe ORDER BY id_actualizacion_pe DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE actualizacion_pe SET id_programa_educativo = '$id_programa_educativo', fecha_implementacion = '$fecha_implementacion', id_anio = '$id_anio' WHERE id_actualizacion_pe = '$id_actualizacion_pe'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_actualizacion_pe, id_programa_educativo, fecha_implementacion, id_anio FROM actualizacion_pe WHERE id_actualizacion_pe = '$id_actualizacion_pe'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM actualizacion_pe WHERE id_actualizacion_pe = '$id_actualizacion_pe'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>