<?php
	include 'conexion.php';
	$prenda = $_GET['prenda'];
	$proceso = $_GET['proceso'];
	$array = [];

	$sql = "SELECT nombre_prenda, nombre_proceso, tiempo_estimado FROM prenda JOIN prenda_proceso ON prenda.id_prenda = prenda_proceso.prenda JOIN proceso ON proceso.id_proceso = prenda_proceso.proceso WHERE id_prenda = $prenda AND id_proceso = $proceso;";
	
	$result = mysqli_query($con, $sql);

	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);


?>
