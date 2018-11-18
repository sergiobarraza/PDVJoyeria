<?php
	include 'conexion.php';
	$folio = $_GET['folio'];
	$array = [];

	$sql = "DELETE FROM pedido WHERE folio= $folio";
	$result = mysqli_query($con, $sql);
	$sql2 = "DELETE FROM cola WHERE folio= $folio";
	$result = mysqli_query($con, $sql2);

?>
