<?php

require_once "connection.php";

$nombre_integrante = "";
$email = "";
$contrasenia = "";

$nombre_integrante_err = "";
$email_err = "";
$contrasenia_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validación de nombre
    if (empty(trim($_POST["nombre_integrante"]))) {
        $nombre_integrante_err = "Por favor, ingrese su nombre completo";
    } else {
        $sql = "SELECT id_integrante FROM integrantes WHERE nombre_integrante = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_nombre_integrante);

            $param_nombre_integrante = trim($_POST["nombre_integrante"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $nombre_integrante_err = "Ya existe una cuenta registrada con este nombre";
                } else {
                    $nombre_integrante = trim($_POST["nombre_integrante"]);
                }
            } else {
                echo "UPS Algo salió mal, intente más tarde";
            }
        }
    }

    // Validación de email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor, ingrese su dirección de email";
    } else {
        $sql = "SELECT id_integrante FROM integrantes WHERE email = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = trim($_POST["email"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "Ya existe una cuenta registrada con esta dirección de email";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "UPS Algo salió mal, intente más tarde";
            }
        }
    }

    //Validación de contraseña
    if(empty(trim($_POST["contrasenia"]))){
        $contrasenia_err = "Por favor, ingrese su contraseña";
    } elseif(strlen(trim($_POST["contrasenia"])) < 4){
        $contrasenia_err = "La contraseña debe tener al menos 4 caracteres";
    } else {
        $contrasenia = trim($_POST["contrasenia"]);
    }

    //Comprobación de errores
    if(empty($nombre_integrante_err && $email_err && $contrasenia_err)){
        $sql = "INSERT INTO integrantes (nombre_integrante, email, contrasenia) VALUES (?,?,?)";

        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_nombre_integrante, $param_email, $param_contrasenia);

            $param_nombre_integrante = $nombre_integrante;
            $param_email = $email;
            $param_contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

            if(mysqli_stmt_execute($stmt)){
                header("location: ../../index.php");
            } else{
                echo "Algos salió mal.";
            }
        }
    }

    mysqli_close($con);
}
