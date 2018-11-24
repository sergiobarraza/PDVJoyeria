<?php
	include('Trabajos/conexion.php');

	$id = $_POST["idproceso"];
	$nombre = $_POST["nombre"];
	$tiempoH = $_POST["tiempoH"];
	$tiempoM = $_POST["tiempoM"];
	$tiempoS = $_POST["tiempoS"];
	$costo = $_POST["costo"];
	$prenda = $_POST["idprenda"];
	$tiempo = $tiempoH * 3600 + $tiempoM * 60 + $tiempoS;
	if ($costo == "") {
		$costo = 0;
		echo $costo;
	}
	
	$sql = "UPDATE prenda_proceso set tiempo_estimado = $tiempo, costo = $costo where id = $id; ";
	echo $sql;
	$result = mysqli_query($con, $sql);
	header("Refresh:0; url=trabajos_prendaproceso.php?prenda=$prenda");

?>