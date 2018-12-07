<?php
	$pageSecurity = array("admin");
require "config/security.php";
	include('Trabajos/conexion.php');
	$prenda = $_POST["prenda"];
	
	

	try {
	$sql0= "INSERT INTO  prenda (nombre_prenda) values ('$prenda');";
	$result0 = mysqli_query($con, $sql0);
	

	
	
		
} catch (Exception $error) {
	echo $error;;
}
header("Refresh:0; url=trabajos.php?prenda=$prenda");
?>