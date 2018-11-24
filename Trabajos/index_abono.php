<?php
/*Función llenarDatos.php
*	Es mandada a llamar desde Myclick() y obtiene los datos de un cierto forlio para permitir que el operador los visualice y 
*	si así lo desea pueda editarlos o eliminar el folio.
*/
	include 'conexion.php';
	$folio = $_GET['folio'];
	$array = [];

	$sql = "SELECT SUM(Transaccion.monto) from transaccion_trabajo join Transaccion on transaccion_trabajo.idTransaccion = Transaccion.idTransaccion where transaccion_trabajo.idTrabajo = $folio";

	$result = mysqli_query($con, $sql);
	//$count = $result->num_rows;
	
	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);



?>