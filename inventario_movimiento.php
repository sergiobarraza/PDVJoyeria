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
			$queryIn= [];
			$queryOut = [];
			$persona =2;
		//Entrada a nuevo Almacen
		try {
    		  $sql2 = "INSERT INTO Folio (idAlmacen, idPersona, estado) VALUES ($almEntrada, $persona, 'Movimiento Entrada Producto');";
    		  $query2 = $connection->query($sql2);

    		  $sql3 = "SELECT idFolio from Folio order by idFolio desc limit 1;";
    		  $query3 = $connection->query($sql3);
    		  $row3 = $query3->fetch(PDO::FETCH_ASSOC);
  		      $folionuevo = $row3["idFolio"];

		      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idFolio) VALUES ($idProducto, $cantidad, '$fecha', $folionuevo);";						   
			  
					$query4 = $connection->query($sql4);
						     

  		      
		    } catch(PDOException $error2) {
		      echo $sql2 . "<br>" . $error2->getMessage();
		      header("Location: inventario.php?status=errormovimientoa#nuevoMovimiento");
  		     		exit;

		    }
		    //Salida de producto
		    try {
    		  $sql5 = "INSERT INTO Folio (idAlmacen, idPersona, estado) VALUES ($almSalida, $persona, 'Movimiento Salida Producto');";
    		  $query5 = $connection->query($sql5);
    		  $sql6 = "SELECT idFolio from Folio order by idFolio desc limit 1;";
    		  $query6 = $connection->query($sql6);
    		  $row6 = $query6->fetch(PDO::FETCH_ASSOC);
  		      $folionuevo = $row6["idFolio"];

		      $sql7 = "INSERT INTO Inventario (idProducto, tipo, fecha, idFolio) VALUES ($idProducto, -$cantidad, '$fecha', $folionuevo);";						   
			 
			  $query7 = $connection->query($sql7);
						     

  		      
		    } catch(PDOException $error5) {
		      echo $sql5 . "<br>" . $error5->getMessage();
		      header("Location: inventario.php?status=errormovimiento#nuevoMovimiento");
  		     		exit;

		    }
			
			
			header("Refresh:0; url=inventario.php?status=successmovimiento#nuevoMovimiento");


?>