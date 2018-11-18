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

	//Busca el ultimo codigo e incrementa uno para agregar uno nuevo
	try 
	{
      $connection = new PDO($dsn, $username, $password, $options );
	  $sql0 = "SELECT codigo from Producto order by cast(codigo as unsigned)desc limit 1;";
	  $query0 = $connection->query($sql0);
	  $row0 = $query0->fetch(PDO::FETCH_ASSOC);
  	  $codigo = $row0["codigo"];
  	  $codigo++;
	} catch (PDOException $error0) {
	  echo $sql0 . "<br>" . $error0->getMessage();
	
	}
//Da de alta el nuevo producto
	try 
	{
      $sql = "INSERT INTO Producto (descuento, idDepartamento, idLinea, precio, imagenUrl, nombre, codigo) VALUES (0, $depto, $linea, $precio, 'img/no-image-placeholder.jpg','$nombre', $codigo);";							   
      $query = $connection->query($sql);
		      

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }

//Revisa el id del producto recien agregado
    try 
    {
  	  $sql1 = "SELECT idProducto from Producto order by idProducto desc limit 1;";
      $query1 = $connection->query($sql1);
      $row = $query1->fetch(PDO::FETCH_ASSOC);
      $idProducto = $row["idProducto"];
    	
    } catch (PDOException $error1) {
    	echo $sql1 . "<br>" . $error1->getMessage();
    }

// Da entrada al nuevo producto
    try 
    {    		  
      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen) VALUES ($idProducto, $cantidad, '$fecha', $almacen);";	  
	  $query4 = $connection->query($sql4);
				     	      
    } catch(PDOException $error2) {
      echo $sql4 . "<br>" . $error2->getMessage();

    }
	
			
			

	header("Refresh:0; url=articulos.php?status=successarticulo#nuevoArticulo");

?>