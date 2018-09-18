<?php
	//include 'conexion.php';

	$linea = $_POST["linea"];
	$sql = "INSERT INTO Linea(nombre) VALUES ('$linea');";
	echo $sql;
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successlinea#nuevaLinea");

?>