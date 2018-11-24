<?php
	include 'conexion.php';
	//$folio = $_GET['folio'];
	//$folio = 5;
	$array = [];
	$sql0 = "SELECT asignado.idasignado, Fila.idFolio FROM asignado join Fila on asignado.idFila = Fila.idFila where Fila.idFolio = $folio;";
	$result0 = mysqli_query($con, $sql0);
	$rows0 = $result0->num_rows;

	for ($i=0 ; $i < $rows0 ; $i++){
		$row0 = $result0 -> fetch_assoc();
		$idasignado = $row0["idasignado"];
		$sql = "DELETE FROM asignado where idasignado =$idasignado;";
		$result = mysqli_query($con, $sql);
		echo $sql;
	}

	//$sql = "DELETE FROM asignado where idasignado =$idasignado;";
	//$result = mysqli_query($con, $sql);
	$sql1 = "UPDATE Fila set estado = 5 where idFolio = $folio";
	//echo $sql1;
	$result1 = mysqli_query($con, $sql1);

?>
