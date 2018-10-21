<?php
	//include 'conexion.php';
	require "config/database.php";
    require "config/common.php";

	//$sku = $_POST["sku"];
	$nombre = $_POST["Descripcion"];
	$linea = $_POST["linea"];
	$depto = $_POST["depto"];
	$precio = $_POST["price"];
	$cantidad = $_POST["cantidad"];
	$persona = $_SESSION['user'];
	$fecha = date("Y-m-d H:i:s");
	$almacen = $_POST["almacen"];	
	
	try {
		      $connection = new PDO($dsn, $username, $password, $options );
			  $sql0 = "SELECT codigo from Producto order by codigo desc limit 1;";
			  $query0 = $connection->query($sql0);
			  $row0 = $query0->fetch(PDO::FETCH_ASSOC);
	      	  $codigo = $row0["codigo"];
	      	  $codigo++;
	} catch (PDOException $error0) {
		echo $sql0 . "<br>" . $error0->getMessage();
	
	}

	try {
		      $sql = "INSERT INTO Producto (descuento, idDepartamento, idLinea, precio, imagenUrl, nombre, codigo) VALUES (0, $depto, $linea, $precio, 'img/no-image-placeholder.jpg','$nombre', $codigo);";							   
		      $query = $connection->query($sql);
		      

		    } catch(PDOException $error) {
		      echo $sql . "<br>" . $error->getMessage();

		    }

    try {
      	  $sql1 = "SELECT idProducto from Producto order by idProducto desc limit 1;";
	      $query1 = $connection->query($sql1);
	      $row = $query1->fetch(PDO::FETCH_ASSOC);
	      $idProducto = $row["idProducto"];
    	
    } catch (PDOException $error1) {
    	echo $sql1 . "<br>" . $error1->getMessage();
    }

    try {
    		  $sql2 = "INSERT INTO Folio (idAlmacen, idPersona, estado) VALUES ($almacen, $persona, 'Entrada Producto');";
    		  $query2 = $connection->query($sql2);

    		  $sql3 = "SELECT idFolio from Folio order by idFolio desc limit 1;";
    		  $query3 = $connection->query($sql3);
    		  $row3 = $query3->fetch(PDO::FETCH_ASSOC);
  		      $folionuevo = $row3["idFolio"];

		      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idFolio) VALUES ($idProducto, $cantidad, '$fecha', $folionuevo);";	  
			  $query4 = $connection->query($sql4);
						     

  		      
		    } catch(PDOException $error2) {
		      echo $sql2 . "<br>" . $error2->getMessage();

		    }
	
			
			

	header("Refresh:0; url=articulos.php?status=successarticulo#nuevoArticulo");

?>