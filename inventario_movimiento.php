<?php
	$pageSecurity = array("admin");
    require "config/security.php";
	require "config/database.php";
    //require "config/common.php";

	$sku = $_POST["sku"];
	$persona =$_SESSION['user'];
	$almEntrada = $_POST["destino"];
	$almSalida = $_POST["from"];
	$fecha = date("Y-m-d H:i:s");
	$cantidad = $_POST["cantidad1"];
	try {
		$connection = new PDO($dsn, $username, $password, $options );
		$sqlcheck= "SELECT Inventario.idProducto, Producto.codigo, SUM(if(Inventario.idAlmacen = $almSalida, Inventario.tipo, 0) ) as cantidad from Inventario join Producto on Inventario.idProducto = Producto.idProducto group by Inventario.idProducto having Producto.codigo = $sku;";
		$querycheck = $connection->query($sqlcheck);
		$rowcheck = $querycheck->fetch(PDO::FETCH_ASSOC);

		if ($rowcheck["cantidad"] < $cantidad) {
			//echo "Error Cantidad";
			//echo "Cantidad: ".$cantidad;
			//echo "Inventario:". $rowcheck["cantidad"];
			header("Location: inventario.php?status=errorcantidad#nuevoMovimiento");
	      	exit;
		}
	} catch (PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}

	try {
	      
	      $sql = "SELECT distinct idProducto, codigo from Producto where codigo =$sku limit 1;";							   
	      $query = $connection->query($sql);
	      

	    } catch(PDOException $error) {
	      echo $sql . "<br>" . $error->getMessage();

	    }
	    if ($query->rowCount() == 0){
	      	 echo "No existe SKU";
	      	 header("Location: inventario.php?status=errorSKU#nuevoMovimiento");
	      	 exit;
	      }else{
	      	$row = $query->fetch(PDO::FETCH_ASSOC);
	      	$idProducto = $row["idProducto"]; 
	      }

		
		if ($almEntrada == $almSalida){ 
			echo "ALMACENES IGUALES";
			header("Location: inventario.php?status=errorAlm#nuevoMovimiento");
			exit;
		}

			
			
		
		//Entrada a nuevo Almacen
		try {
			  

		      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen, comentario) VALUES ($idProducto, $cantidad, '$fecha', $almEntrada, 'traspaso');";
		      $query4 = $connection->query($sql4);						       		      
		    } catch(PDOException $error2) {
		      echo $sql4 . "<br>" . $error2->getMessage();
		      header("Location: inventario.php?status=errormovimientoa#nuevoMovimiento");
  		     		exit;

		    }
		    //Salida de producto
		    try {


		      $sql7 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen, comentario) VALUES ($idProducto, -$cantidad, '$fecha', $almSalida, 'traspaso');";						   			 
			  $query7 = $connection->query($sql7);
						     

  		      
		    } catch(PDOException $error3) {
		      echo $sql5 . "<br>" . $error3->getMessage();
		      header("Location: inventario.php?status=errormovimiento#nuevoMovimiento");
  		     		exit;

		    }
			
			
			//header("Refresh:0; url=inventario.php?status=successmovimiento&entrada=$almEntrada&salida=$almSalida&articulo=$sku&cantidad=$cantidad#nuevoMovimiento");
			header("Refresh:0; url=imprimirticket_traspaso.php?entrada=$almEntrada&salida=$almSalida&articulo=$sku&cantidad=$cantidad");



?>