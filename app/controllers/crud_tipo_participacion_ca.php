<?php
include ("conexion.php");

$id_tipo_participacion_ca = (isset($_POST['id_tipo_participacion_ca'])) ? $_POST['id_tipo_participacion_ca'] : '';
$tipo_participacion_ca = (isset($_POST['tipo_participacion_ca'])) ? $_POST['tipo_participacion_ca'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO tipo_participacion_ca (tipo_participacion_ca) VALUES('$tipo_participacion_ca')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_participacion_ca, tipo_participacion_ca FROM tipo_participacion_ca ORDER BY id_tipo_participacion_ca DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE tipo_participacion_ca SET tipo_participacion_ca = '$tipo_participacion_ca' WHERE id_tipo_participacion_ca = '$id_tipo_participacion_ca'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_participacion_ca, tipo_participacion_ca FROM tipo_participacion_ca WHERE id_tipo_participacion_ca = '$id_tipo_participacion_ca'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM tipo_participacion_ca WHERE id_tipo_participacion_ca = '$id_tipo_participacion_ca'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>