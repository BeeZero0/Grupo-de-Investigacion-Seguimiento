<?php
	$database="grupo-investigacion";
	$user='root';
	$password='kaos_r3lentless';


try {
	
	$conect=new PDO('mysql:host=localhost;dbname='.$database,$user,$password);

} catch (PDOException $e) {
	echo "Error".$e->getMessage();
}

?>