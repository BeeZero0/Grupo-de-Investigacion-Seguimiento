<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'kaos_r3lentless');
define('DB_NAME', 'grupo-investigacion');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($con === false) {
    die("Error en la conexión" .mysqli_connect_error());
}
?>