<?php
	include 'conexion.php';
	$prenda = $_GET['prenda'];
	$array = [];

	$sql = "SELECT proceso, nombre_proceso FROM proceso  JOIN prenda_proceso ON proceso.id_proceso = prenda_proceso.proceso WHERE prenda_proceso.prenda= $prenda;";
	$result = mysqli_query($con, $sql);


	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);


?>
