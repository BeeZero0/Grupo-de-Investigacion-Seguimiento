<?php
include ("conexion.php");

$id_dependencia = (isset($_POST['id_dependencia'])) ? $_POST['id_dependencia'] : '';
$dependencia = (isset($_POST['dependencia'])) ? $_POST['dependencia'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO dependencias (dependencia) VALUES('$dependencia')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_dependencia, dependencia FROM dependencias ORDER BY id_dependencia DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE dependencias SET dependencia = '$dependencia' WHERE id_dependencia = '$id_dependencia'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_dependencia, dependencia FROM dependencias WHERE id_dependencia = '$id_dependencia'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM dependencias WHERE id_dependencia = '$id_dependencia'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>
