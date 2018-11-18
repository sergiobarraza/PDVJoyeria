<?php
/*Función llenarDatos.php
*	Es mandada a llamar desde Myclick() y obtiene los datos de un cierto forlio para permitir que el operador los visualice y 
*	si así lo desea pueda editarlos o eliminar el folio.
*/
	include 'conexion.php';
	$folio = $_GET['folio'];
	$array = [];

	$sql = "SELECT distinct prenda_proceso.prenda, prenda_proceso.proceso, prenda.nombre_prenda, proceso.nombre_proceso 
			FROM Fila 
			JOIN prenda_proceso ON Fila.prenda_proceso = prenda_proceso.id
			JOIN prenda ON prenda_proceso.prenda = prenda.id_prenda 
			JOIN proceso ON prenda_proceso.proceso = proceso.id_proceso WHERE idFolio = $folio;";

	$result = mysqli_query($con, $sql);
	$count = $result->num_rows;
	
	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    array_push($array, $opcion);
	}

	echo json_encode($array);



?>