<?php
/*Función llenarDatos.php
*	Es mandada a llamar desde Myclick() y obtiene los datos de un cierto forlio para permitir que el operador los visualice y 
*	si así lo desea pueda editarlos o eliminar el folio.
*/
	include 'conexion.php';
	$folio = $_GET['folio'];
	$array = [];

	$sql = "SELECT DISTINCT pedido.folio, pedido.nombre_cliente, pedido.operador,pedido.prenda, pedido.proceso, prenda.nombre_prenda, proceso.nombre_proceso, pedido.tiempoEstimado, pedido.urgencia, comentario FROM pedido JOIN prenda ON pedido.prenda = prenda.id_prenda JOIN prenda_proceso ON pedido.prenda = prenda_proceso.prenda JOIN proceso ON pedido.proceso = proceso.id_proceso WHERE folio = $folio;";

	$result = mysqli_query($con, $sql);
	$count = $result->num_rows;
	
	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);



?>