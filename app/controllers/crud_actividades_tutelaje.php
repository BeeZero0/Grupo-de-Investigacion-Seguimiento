<?php
include ("conexion.php");

$id_actividad_tutelaje = (isset($_POST['id_actividad_tutelaje'])) ? $_POST['id_actividad_tutelaje'] : '';
$alumno = (isset($_POST['alumno'])) ? $_POST['alumno'] : '';
$id_programa_educativo = (isset($_POST['id_programa_educativo'])) ? $_POST['id_programa_educativo'] : '';
$id_tipo_tutelaje = (isset($_POST['id_tipo_tutelaje'])) ? $_POST['id_tipo_tutelaje'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$id_integrante = (isset($_POST['id_integrante'])) ? $_POST['id_integrante'] : '';
$id_linea = (isset($_POST['id_linea'])) ? $_POST['id_linea'] : '';
$id_anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $sentencia = "INSERT INTO actividades_tutelaje (alumno, id_programa_educativo, id_tipo_tutelaje, descripcion, id_integrante, id_linea, id_anio) VALUES('$alumno', '$id_programa_educativo', '$id_tipo_tutelaje', '$descripcion', '$id_integrante', '$id_linea', '$id_anio')";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_actividad_tutelaje, alumno, id_programa_educativo, id_tipo_tutelaje, descripcion, id_integrante, id_linea, id_anio FROM actividades_tutelaje ORDER BY id_actividad_tutelaje DESC LIMIT 1";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $sentencia = "UPDATE actividades_tutelaje SET alumno = '$alumno',  id_programa_educativo = '$id_programa_educativo', id_tipo_tutelaje = '$id_tipo_tutelaje', descripcion = '$descripcion', id_integrante = '$id_integrante', id_linea = '$id_linea', id_anio = '$id_anio' WHERE id_actividad_tutelaje = '$id_actividad_tutelaje'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();

        $sentencia = "SELECT id_actividad_tutelaje, alumno, id_programa_educativo, id_tipo_tutelaje, descripcion, id_integrante, id_linea, id_anio FROM actividades_tutelaje WHERE id_actividad_tutelaje = '$id_actividad_tutelaje'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $sentencia = "DELETE FROM actividades_tutelaje WHERE id_actividad_tutelaje = '$id_actividad_tutelaje'";
        $resultado = $conect->prepare($sentencia);
        $resultado->execute();
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conect = null;
?>
