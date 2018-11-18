<?php 
	include 'conexion.php';
	$Fila = $_POST["Filaselected"];
	$User = $_POST["Userselected"];
	$fecha = date("Y-m-d H:i:s");
	$sql0 = "INSERT into asignado(idfila, operador, fechaInicio) values ($Fila, '$User', '$fecha');";
	echo $sql0;
	//$result0 = mysqli_query($con, $sql0);
	$sql1 = "UPDATE Fila SET estado = 1 where idFila = $Fila;";
	echo $sql1;
	//$result1 = mysqli_query($con, $sql1);
 ?>
