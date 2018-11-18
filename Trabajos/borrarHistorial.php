<?php
	include 'conexion.php';
	mysqli_query($con, "TRUNCATE TABLE historial");
	header("Location: historial.php"); 
?>