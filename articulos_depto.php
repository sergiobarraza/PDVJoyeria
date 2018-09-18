<?php
	//include 'conexion.php';

	$depto = $_POST["depto"];
	$sql = "INSERT INTO Departamento(nombre) VALUES ('$depto');";
	echo $sql;
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successdepto#nuevoDepto");

?>