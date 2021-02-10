<?php
include ("conexion.php");

$id_gestion_academica = (isset($_POST['id_gestion_academica'])) ? $_POST['id_gestion_academica'] : '';
$responsabilidad = (isset($_POST['responsabilidad'])) ? $_POST['responsabilidad'] : '';
$funcion_encomendada = (isset($_POST['funcion_encomendada'])) ? $_POST['funcion_encomendada'] : '';
$id_tipo_gestion = (isset($_POST['id_tipo_gestion'])) ? $_POST['id_tipo_gestion'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO gestion_academica (responsabilidad, funcion_encomendada, id_tipo_gestion, id_anio) VALUES('$responsabilidad', '$funcion_encomendada', '$id_tipo_gestion', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_gestion_academica, responsabilidad, funcion_encomendada, id_tipo_gestion, id_anio FROM gestion_academica ORDER BY id_gestion_academica DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE gestion_academica SET  responsabilidad = '$responsabilidad', funcion_encomendada = '$funcion_encomendada', id_tipo_gestion = '$id_tipo_gestion', id_anio = '$id_anio' WHERE id_gestion_academica = '$id_gestion_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_gestion_academica,  responsabilidad, funcion_encomendada, id_tipo_gestion, id_anio FROM gestion_academica WHERE id_gestion_academica = '$id_gestion_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM gestion_academica WHERE id_gestion_academica = '$id_gestion_academica'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>