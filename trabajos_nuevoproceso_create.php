<?php

	include('Trabajos/conexion.php');
	$prenda = $_POST["prenda"];
	$name = $_POST["name"];
	$tiempo = $_POST["tiempo"];
	$costo = $_POST["costo"];
	

	try {
	$sql0= "INSERT INTO  proceso (nombre_proceso) values ('$name');";
	//$result0 = mysqli_query($con, $sql0);
	
	$sql1="SELECT id_proceso from proceso order by id_proceso desc;";
	$result1 = mysqli_query($con, $sql1);
	$row1 = $result1->fetch_assoc();
	$proceso= $row1["id_proceso"];

	$sql2="INSERT INTO prenda_proceso(prenda, proceso, tiempo_estimado, costo) values($prenda, $proceso, $tiempo, $costo);";
	//echo $sql2;
	//$result2 = mysqli_query($con, $sql2);
	
		
} catch (Exception $error) {
	echo $error;;
}
header("Refresh:0; url=trabajos_prendaproceso.php?prenda=$prenda");
?>