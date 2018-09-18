<?php
	//include 'conexion.php';

	$sku = $_POST["sku"];
	$sql1 = "SELECT distinct idProducto from Producto where idProducto =$sku;";	
	//$result1 = mysqli_query($con, $sql1);
	$result1= "asd";
	if ($result1 != ""){

		$almEntrada = $_POST["destino"];
		$almSalida = $_POST["from"];
		if ($almEntrada == $almSalida) {
			header("Refresh:0; url=inventario.php?status=errorAlm#nuevoMovimiento");
		}else{

			$fecha = date("Y-m-d H:i:s");
			//$cantidad = $_POST["quant[2]"];
			$sqlIn= array();
			$sqlOut = array();
			$fecha = date("Y-m-d H:i:s");
			$persona =0;

			for ($i=0; $i < 10 ; $i++) { 	
				$sqlIn[$i] = "INSERT INTO Entrada ( idAlmacen, idProducto, date, tipo, idPersona) VALUES ($almEntrada, $sku, $fecha, 'movimiento', $persona);";
				$sqlOut[$i] = "INSERT INTO Salida ( idAlmacen, idProducto, date, tipo, idPersona) VALUES ($almSalida, $sku, $fecha, 'movimiento', $persona);";

				//$resultIn[$i] = mysqli_query($con, $sqlIn[$i]);
				//$resultOut[$i] = mysqli_query($con, $sqlOut[$i]);

				echo $sqlIn[$i]."<br>";
				echo $sqlOut[$i]."<br>";

			}
			header("Refresh:0; url=inventario.php?status=successmovimiento#nuevoMovimiento");
		}

	}else {
		//header("Refresh:0; url=inventario.php?status=errorSKU#nuevoMovimiento");
	}
	//$result = mysqli_query($con, $sql);

?>