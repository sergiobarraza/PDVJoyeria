<?php
	include 'conexion.php';
	$folio = $_GET['folio'];
	$array = [];

	$sql = "SELECT DISTINCT pedido.prenda, pedido.proceso, prenda.nombre_prenda, proceso.nombre_proceso FROM pedido JOIN prenda ON pedido.prenda = prenda.id_prenda JOIN prenda_proceso ON pedido.prenda = prenda_proceso.prenda JOIN proceso ON pedido.proceso = proceso.id_proceso WHERE folio = $folio;";
	$result = mysqli_query($con, $sql);

	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);


?>
