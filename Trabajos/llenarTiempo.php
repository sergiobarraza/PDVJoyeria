
<?php
/*
*	Función: llenarTiempo.php
*		Esta función es llamada por usuarioselect() para calcular el tiempo en cola del usuario seleccionado.
*/
	include 'conexion.php';
	$operador = $_GET['operador'];
	$array = [];

	$sql = "SELECT SUM(tiempoEstimado) as tiempoTotal FROM cola WHERE operador = '$operador';";

	$result = mysqli_query($con, $sql);
	$count = $result->num_rows;
	
	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);



?>