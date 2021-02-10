<?php
include ("conexion.php");

$id_programa_educativo = (isset($_POST['id_programa_educativo'])) ? $_POST['id_programa_educativo'] : '';
$programa_educativo = (isset($_POST['programa_educativo'])) ? $_POST['programa_educativo'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO programas_educativos (programa_educativo) VALUES('$programa_educativo')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_programa_educativo, programa_educativo FROM programas_educativos ORDER BY id_programa_educativo DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE programas_educativos SET programa_educativo = '$programa_educativo' WHERE id_programa_educativo = '$id_programa_educativo'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_programa_educativo, programa_educativo FROM programas_educativos WHERE id_programa_educativo = '$id_programa_educativo'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM programas_educativos WHERE id_programa_educativo = '$id_programa_educativo'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>
