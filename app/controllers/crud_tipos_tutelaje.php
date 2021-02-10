<?php
include ("conexion.php");

$id_tipo_tutelaje = (isset($_POST['id_tipo_tutelaje'])) ? $_POST['id_tipo_tutelaje'] : '';
$tipo_tutelaje = (isset($_POST['tipo_tutelaje'])) ? $_POST['tipo_tutelaje'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO tipos_tutelaje (tipo_tutelaje) VALUES('$tipo_tutelaje')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_tutelaje, tipo_tutelaje FROM tipos_tutelaje ORDER BY id_tipo_tutelaje DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE tipos_tutelaje SET tipo_tutelaje = '$tipo_tutelaje' WHERE id_tipo_tutelaje = '$id_tipo_tutelaje'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_tipo_tutelaje, tipo_tutelaje FROM tipos_tutelaje WHERE id_tipo_tutelaje = '$id_tipo_tutelaje'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM tipos_tutelaje WHERE id_tipo_tutelaje = '$id_tipo_tutelaje'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>