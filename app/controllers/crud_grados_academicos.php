<?php
include ("conexion.php");

$id_grado_academico = (isset($_POST['id_grado_academico'])) ? $_POST['id_grado_academico'] : '';
$grado_academico = (isset($_POST['grado_academico'])) ? $_POST['grado_academico'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO grados_academicos (grado_academico) VALUES('$grado_academico')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_grado_academico, grado_academico FROM grados_academicos ORDER BY id_grado_academico DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE grados_academicos SET grado_academico = '$grado_academico' WHERE id_grado_academico = '$id_grado_academico'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_grado_academico, grado_academico FROM grados_academicos WHERE id_grado_academico = '$id_grado_academico'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM grados_academicos WHERE id_grado_academico = '$id_grado_academico'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>