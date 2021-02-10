<?php
include ("conexion.php");

$id_actividad_docente = (isset($_POST['id_actividad_docente'])) ? $_POST['id_actividad_docente'] : '';
$id_materia = (isset($_POST['id_materia'])) ? $_POST['id_materia'] : '';
$id_programa_educativo = (isset($_POST['id_programa_educativo'])) ? $_POST['id_programa_educativo'] : '';
$id_integrante = (isset($_POST['id_integrante'])) ? $_POST['id_integrante'] : '';
$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $sentencia = "INSERT INTO actividad_docente (id_materia, id_programa_educativo, id_integrante, id_linea, id_anio) VALUES('$id_materia', '$id_programa_educativo', '$id_integrante', '$id_linea', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_actividad_docente, id_materia, id_programa_educativo, id_integrante, id_linea, id_anio FROM actividad_docente ORDER BY id_actividad_docente DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE actividad_docente SET id_materia = '$id_materia', id_programa_educativo = '$id_programa_educativo', id_integrante = '$id_integrante', id_linea = '$id_linea', id_anio = '$id_anio' WHERE id_actividad_docente = '$id_actividad_docente'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_actividad_docente, id_materia, id_programa_educativo, id_integrante, id_linea, id_anio FROM actividad_docente WHERE id_actividad_docente = '$id_actividad_docente'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM actividad_docente WHERE id_actividad_docente = '$id_actividad_docente'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>