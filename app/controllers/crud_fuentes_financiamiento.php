<?php
include ("conexion.php");

$id_fuente_financiamiento = (isset($_POST['id_fuente_financiamiento'])) ? $_POST['id_fuente_financiamiento'] : '';
$fuente = (isset($_POST['fuente'])) ? $_POST['fuente'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO fuentes_financiamiento (fuente) VALUES('$fuente')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_fuente_financiamiento, fuente FROM fuentes_financiamiento ORDER BY id_fuente_financiamiento DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE fuentes_financiamiento SET fuente = '$fuente' WHERE id_fuente_financiamiento = '$id_fuente_financiamiento'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_fuente_financiamiento, fuente FROM fuentes_financiamiento WHERE id_fuente_financiamiento = '$id_fuente_financiamiento'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM fuentes_financiamiento WHERE id_fuente_financiamiento = '$id_fuente_financiamiento'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>