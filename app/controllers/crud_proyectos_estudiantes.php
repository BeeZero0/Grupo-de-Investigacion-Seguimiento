<?php
include ("conexion.php");

$id_proyecto_estudiante = (isset($_POST['id_proyecto_estudiante'])) ? $_POST['id_proyecto_estudiante'] : '';
$id_programa_educativo = (isset($_POST['id_programa_educativo'])) ? $_POST['id_programa_educativo'] : '';
$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO proyectos_estudiantes (id_programa_educativo, titulo, estado, id_linea, id_anio) VALUES('$id_programa_educativo','$titulo', '$estado', '$id_linea', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_proyecto_estudiante, id_programa_educativo, titulo, estado, id_linea, id_anio FROM proyectos_estudiantes ORDER BY id_proyecto_estudiante DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE proyectos_estudiantes SET id_programa_educativo = '$id_programa_educativo', titulo = '$titulo', estado = '$estado', id_linea = '$id_linea', id_anio = '$id_anio' WHERE id_proyecto_estudiante = '$id_proyecto_estudiante'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_proyecto_estudiante, id_programa_educativo, titulo, estado, id_linea, id_anio FROM proyectos_estudiantes WHERE id_proyecto_estudiante = '$id_proyecto_estudiante'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM proyectos_estudiantes WHERE id_proyecto_estudiante = '$id_proyecto_estudiante'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>