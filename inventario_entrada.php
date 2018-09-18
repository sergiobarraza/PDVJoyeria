<?php
	//include 'conexion.php';

	$sku = $_POST["sku"];
	//$cantidad = $_POST["quant[1]"];
	$sql= array();
	$sql1 = "SELECT distinct idProducto from Producto where idProducto =$sku;";
	$fecha = date("Y-m-d H:i:s");
	$persona =0;
	//$result1 = mysqli_query($con, $sql1);

	if (isset($_POST['imprimir']) && $_POST['imprimir'] == 'Yes') 
	{
	    echo "Imprimiendo etiquetas";
	}
	else
	{
	    echo "No imprimir etiquetas";
	}

	for ($i=0; $i < 10 ; $i++) { 	
		$sql[$i] = "INSERT INTO Entrada ( idAlmacen, idProducto, date, tipo, idPersona) VALUES (1, $sku, $fecha, 'entrada', $persona);";
		//$result[$i] = mysqli_query($con, $sql[$i]);

		echo $sql[$i]."<br>";
	}
	//echo $fecha;
	//$sql = "INSERT INTO Departamento(nombre) VALUES ('$depto');";
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=inventario.php?status=successentrada#nuevoDepto");

?>