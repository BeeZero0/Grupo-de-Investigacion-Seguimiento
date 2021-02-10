<?php
include ("conexion.php");

$id_objetivo = (isset($_POST['id_objetivo'])) ? $_POST['id_objetivo'] : '';
$objetivo = (isset($_POST['objetivo'])) ? $_POST['objetivo'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO objetivos (objetivo, descripcion) VALUES('$objetivo', '$descripcion')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_objetivo, objetivo, descripcion FROM objetivos ORDER BY id_objetivo DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE objetivos SET objetivo = '$objetivo', descripcion = '$descripcion' WHERE id_objetivo = '$id_objetivo'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_objetivo, objetivo, descripcion FROM objetivos WHERE id_objetivo = '$id_objetivo'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM objetivos WHERE id_objetivo = '$id_objetivo'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>