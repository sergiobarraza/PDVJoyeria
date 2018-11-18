<?php
	include 'conexion.php';
	
	
	$nombreCliente = $_POST["nombreCliente"];
	$folio = $_POST["folio"];
	$pp = $_POST["prendasprocesos"];
	$operador = $_POST["operador_select"];
	$tiempo_estimado = $_POST["tiempoEstimadoFolio"];
	$comentario = $_POST["comentarioNameFolio"];
	$fecha = date("Y-m-d");

	$prenda_proceso= explode(",",$pp);
	
	$mod = count($prenda_proceso);
	//echo "pp:".$pp;

	$mod= $mod/2;

	$x = 0;
	$y = 1;

	//echo "pp:".$mod;
	$sql1 = "DELETE FROM pedido WHERE folio = $folio;";
	mysqli_query($con, $sql1);
	//echo "<br>".$sql1;

	$sql2 = "DELETE FROM cola WHERE folio = $folio;";
	mysqli_query($con, $sql2);
	//echo "<br>".$sql2;
	
	for ($i=0 ; $i < $mod ; $i++){
		$prenda = $prenda_proceso[$x];
		$proceso = $prenda_proceso[$y];
		
		$sql3 = "INSERT INTO pedido (folio, nombre_cliente, operador, prenda, proceso, comentario, tiempoEstimado, fecha) VALUES ($folio, '$nombreCliente', '$operador', $prenda, $proceso, '$comentario', $tiempo_estimado, '$fecha');";
		//echo "<br>".$sql3;

		$result = mysqli_query($con, $sql3);
		$x = $x+2;
		$y = $y+2;
	}

	$sql4 = "INSERT INTO cola VALUES ($folio, '$operador', $tiempo_estimado, $urgencia);";
	$result = mysqli_query($con, $sql4);
	//echo "<br>".$sql4;
	
	header("Refresh:0; url=index.php");
	
		
		/*for ($i=0 ; $i < $mod ; $i++){
			$prenda = $prenda_proceso[$x];
			$proceso = $prenda_proceso[$y];
			
			
			$sql = "UPDATE pedido SET nombre_cliente = '$nombreCliente', operador= '$operador', tiempoEstimado= $tiempo_estimado , urgencia= $urgencia WHERE folio = $folio";

			$result = mysqli_query($con, $sql);
			$x = $x+2;
			$y = $y+2;
		}

		$sql2 = "UPDATE cola SET operador = '$operador', tiempoEstimado = $tiempo_estimado, urgencia = $urgencia WHERE folio= $folio ;";
		$result = mysqli_query($con, $sql2);*/
	
	

	
	

?>