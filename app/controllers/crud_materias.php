<?php
include ("conexion.php");

$id_materia = (isset($_POST['id_materia'])) ? $_POST['id_materia'] : '';
$materia = (isset($_POST['materia'])) ? $_POST['materia'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO materias (materia) VALUES('$materia')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_materia, materia FROM materias ORDER BY id_materia DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE materias SET materia = '$materia' WHERE id_materia = '$id_materia'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_materia, materia FROM materias WHERE id_materia = '$id_materia'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM materias WHERE id_materia = '$id_materia'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>
