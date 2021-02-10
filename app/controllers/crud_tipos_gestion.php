<?php
include ("conexion.php");

$id_tipo_gestion = (isset($_POST['id_tipo_gestion'])) ? $_POST['id_tipo_gestion'] : '';
$tipo_gestion = (isset($_POST['tipo_gestion'])) ? $_POST['tipo_gestion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO tipos_gestion (tipo_gestion) VALUES('$tipo_gestion')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_gestion, tipo_gestion FROM tipos_gestion ORDER BY id_tipo_gestion DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE tipos_gestion SET tipo_gestion = '$tipo_gestion' WHERE id_tipo_gestion = '$id_tipo_gestion'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_gestion, tipo_gestion FROM tipos_gestion WHERE id_tipo_gestion = '$id_tipo_gestion'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM tipos_gestion WHERE id_tipo_gestion = '$id_tipo_gestion'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>