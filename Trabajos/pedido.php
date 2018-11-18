<?php
	include 'conexion.php';
	
	
	$nombreCliente = $_POST["nombreCliente"];
	$folio = $_POST["folio"];
	$pp = $_POST["tablaName"];
	$operador = $_POST["operador_select"];
	$urgencia = $_POST["urgencia_select"];
	$tiempo_estimado = $_POST["tiempoEstimado"];
	$comentario = $_POST["comentarioName"];
	$fecha = date("Y-m-d");
	//echo $tiempo_estimado;
	$prenda_proceso= explode(",",$pp);
	
	$mod = count($prenda_proceso);
	$mod= $mod/2;

	$x = 0;
	$y = 1;


	
	for ($i=0 ; $i < $mod ; $i++){
		$prenda = $prenda_proceso[$x];
		$proceso = $prenda_proceso[$y];
		
		$sql = "INSERT INTO pedido (folio, nombre_cliente, operador, prenda, proceso, comentario, tiempoEstimado, urgencia, fecha) VALUES ($folio, '$nombreCliente', '$operador', $prenda, $proceso, '$comentario', $tiempo_estimado, $urgencia, '$fecha');";
		//echo $sql;
		$result = mysqli_query($con, $sql);
		$x = $x+2;
		$y = $y+2;
	}

	$sql2 = "INSERT INTO cola VALUES ($folio, '$operador', $tiempo_estimado, $urgencia);";
	//echo $sql2;
	$result = mysqli_query($con, $sql2);
	
	header("Refresh:0; url=index.php");
	
?>