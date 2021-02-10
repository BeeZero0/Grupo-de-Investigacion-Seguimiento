<?php
include ("conexion.php");

$id_participacion_ca = (isset($_POST['id_participacion_ca'])) ? $_POST['id_participacion_ca'] : '';
$nombre_participacion = (isset($_POST['nombre_participacion'])) ? $_POST['nombre_participacion'] : '';
$id_tipo_participacion_ca = (isset($_POST['id_tipo_participacion_ca'])) ? $_POST['id_tipo_participacion_ca'] : '';
$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';
$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO participaciones_ca (nombre_participacion, id_tipo_participacion_ca, fecha_inicio, fecha_fin, id_anio) VALUES('$nombre_participacion', '$id_tipo_participacion_ca', '$fecha_inicio', '$fecha_fin', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_participacion_ca, nombre_participacion, id_tipo_participacion_ca, fecha_inicio, fecha_fin, id_anio FROM participaciones_ca ORDER BY id_participacion_ca DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE participaciones_ca SET nombre_participacion = '$nombre_participacion', id_tipo_participacion_ca = '$id_tipo_participacion_ca', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', id_anio = '$id_anio' WHERE id_participacion_ca = '$id_participacion_ca'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_participacion_ca, nombre_participacion, id_tipo_participacion_ca, fecha_inicio, fecha_fin, id_anio FROM participaciones_ca WHERE id_participacion_ca = '$id_participacion_ca'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM participaciones_ca WHERE id_participacion_ca = '$id_participacion_ca'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>