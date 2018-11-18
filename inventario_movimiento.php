<?php
	$pageSecurity = array("admin");
    require "config/security.php";
	require "config/database.php";
    //require "config/common.php";

	$sku = $_POST["sku"];
	$persona =$_SESSION['user'];

	try {
	      $connection = new PDO($dsn, $username, $password, $options );
	      $sql = "SELECT distinct idProducto, codigo from Producto where codigo =$sku limit 1;";							   
	      $query = $connection->query($sql);
	      

	    } catch(PDOException $error) {
	      echo $sql . "<br>" . $error->getMessage();

	    }
	    if ($query->rowCount() == 0){
	      	 echo "No existe SKU";
	      	 header("Location: inventario.php?status=errorSKU#nuevoDepto");
	      	 exit;
	      }else{
	      	$row = $query->fetch(PDO::FETCH_ASSOC);
	      	$idProducto = $row["idProducto"]; 
	      }

		$almEntrada = $_POST["destino"];
		$almSalida = $_POST["from"];
		if ($almEntrada == $almSalida){ 
			echo "ALMACENES IGUALES";
			header("Location: inventario.php?status=errorAlm#nuevoMovimiento");
			exit;
		}

			$fecha = date("Y-m-d H:i:s");
			$cantidad = $_POST["cantidad1"];
			
		
		//Entrada a nuevo Almacen
		try {
			  

		      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen) VALUES ($idProducto, $cantidad, '$fecha', $almEntrada);";
		      $query4 = $connection->query($sql4);						       		      
		    } catch(PDOException $error2) {
		      echo $sql4 . "<br>" . $error2->getMessage();
		      header("Location: inventario.php?status=errormovimientoa#nuevoMovimiento");
  		     		exit;

		    }
		    //Salida de producto
		    try {


		      $sql7 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen) VALUES ($idProducto, -$cantidad, '$fecha', $almSalida);";						   
			 
			  $query7 = $connection->query($sql7);
						     

  		      
		    } catch(PDOException $error3) {
		      echo $sql5 . "<br>" . $error3->getMessage();
		      header("Location: inventario.php?status=errormovimiento#nuevoMovimiento");
  		     		exit;

		    }
			
			
			header("Refresh:0; url=inventario.php?status=successmovimiento#nuevoMovimiento");


?>