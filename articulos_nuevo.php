<?php
	//include 'conexion.php';
	$sku = $_POST["sku"];
	$nombre = $_POST["Descripcion"];
	$linea = $_POST["linea"];
	$depto = $_POST["depto"];
	$precio = $_POST["price"];
	$cantidad = $_POST["cantidad"];
	if($sku != ""){
		$sql = "INSERT INTO Producto (idProducto, descuento, idDepartamento, idLinea, precio, imagenUrl, nombre) VALUES ($sku,0, $depto, $linea, $precio, 'img/no-image-placeholder.jpg','$nombre');";
	}else{
		$sql = "INSERT INTO Producto (descuento, idDepartamento, idLinea, precio, imagenUrl, nombre) VALUES (0, $depto, $linea, $precio, 'img/no-image-placeholder.jpg','$nombre');";
	}
	
	//$result = mysqli_query($con, $sql);

	for ($i=0; $i < $cantidad ; $i++) { 

	}


	echo $sql;
	//header("Refresh:0; url=articulos.php?status=successarticulo#nuevoArticulo");

?>