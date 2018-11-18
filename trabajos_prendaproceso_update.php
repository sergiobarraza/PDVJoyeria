<?php
	include('Trabajos/conexion.php');

	$id = $_POST["idproceso"];
	$nombre = $_POST["nombre"];
	$tiempo = $_POST["tiempo"];
	$costo = $_POST["costo"];
	$prenda = $_POST["idprenda"];
	$sql = "UPDATE prenda_proceso set tiempo_estimado = $tiempo, costo = $costo where id = $id; ";
	echo $sql;
	$result = mysqli_query($con, $sql);
	header("Refresh:0; url=trabajos_prendaproceso.php?prenda=$prenda");

?>