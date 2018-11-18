<?php
	include 'conexion.php';
	$prenda = $_GET['prenda'];
	$array = [];

	$sql = "SELECT proceso, nombre_proceso, prenda_proceso.prenda, prenda.nombre_prenda FROM proceso  JOIN prenda_proceso ON proceso.id_proceso = prenda_proceso.proceso JOIN prenda on prenda.id_prenda = prenda_proceso.prenda WHERE prenda_proceso.prenda= $prenda;";
	$result = mysqli_query($con, $sql);


	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);


?>
