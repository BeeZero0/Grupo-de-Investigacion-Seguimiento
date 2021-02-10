<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: app/views/welcome.php");
    exit;
}

require_once "connection.php";

$email = "";
$contrasenia = "";

$email_err = "";
$contrasenia_err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor, introduzca su dirección de email";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["contrasenia"]))) {
        $contrasenia_err = "Por favor, introduzca su contraseña";
    } else {
        $contrasenia = trim($_POST["contrasenia"]);
    }

    //Validación de credenciales
    if (empty($email_err) && empty($contrasenia_err)) {
        $sql = "SELECT id_integrante, nombre_integrante, email, contrasenia FROM integrantes WHERE email =?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_emal);
            $param_emal = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
            }

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id_integrante, $nombre_integrante, $email, $hashed_contrasenia);
                if (mysqli_stmt_fetch($stmt)) {
                    echo $hashed_contrasenia;
                    echo "<br>";
                    echo $contrasenia;
                    if (password_verify($contrasenia, $hashed_contrasenia)) {
                        session_start();

                        //Almacenar datos en variables de sesión

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id_integrante"] = $id_integrante;
                        $_SESSION["email"] = $email;

                        header("location: app/views/welcome.php");
                    } else {
                        $contrasenia_err = "La contraseña es incorrecta";
                    }
                }
            } else {
                $email_err = "No se ha encontrado ninguna cuenta con esa dirección de email";
            }
        } else {
            echo "Ups! Algo salió mal.";
        }
    }
    mysqli_close($con);
}
