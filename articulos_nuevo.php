<?php
	//include 'conexion.php';
//$pageSecurity = array("admin");
  //require "config/security.php";
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
	$Tipoprod = $_POST["Tipoprod"];
	$Proveedor = $_POST["Proveedor"];
	$subdepto = $_POST["subdepto"];
	$almacen = $_POST["almacen"];
	$Min = $_POST["Min"];
	$Costo = $_POST["Costo"];
	$Procedencia = $_POST["Procedencia"];

	
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
      $sql = "INSERT INTO Producto (descuento, idDepartamento, idLinea, precio, imagenUrl, nombre, codigo, idProveedor, idTipoprod, idSubdepartamento, costo, preciomin, procedencia ) VALUES (0, $depto, $linea, $precio, 'img/no-image-placeholder.jpg','$nombre', $codigo, $Proveedor, $Tipoprod, $subdepto, $Costo, $Min, '$Procedencia');";
      //echo $sql;							   
      $query = $connection->query($sql);
		      

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorarticulo");
      exit;
    }

//Revisa el id del producto recien agregado
    try 
    {
  	  $sql1 = "SELECT idProducto, codigo from Producto order by idProducto desc limit 1;";
      $query1 = $connection->query($sql1);
      $row = $query1->fetch(PDO::FETCH_ASSOC);
      $idProducto = $row["idProducto"];
      $codigo = $row["codigo"];
    	
    } catch (PDOException $error1) {
    	echo $sql1 . "<br>" . $error1->getMessage();
    	header("Refresh:0; url=articulos.php?status=errorarticulo");
      exit;
    }

// Da entrada al nuevo producto
    try 
    {    		  
      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen, comentario) VALUES ($idProducto, $cantidad, '$fecha', $almacen, 'entrada');";	  
	  $query4 = $connection->query($sql4);
	  //echo $sql4;
				     	      
    } catch(PDOException $error2) {
      echo $sql4 . "<br>" . $error2->getMessage();
      header("Refresh:0; url=articulos.php?status=errorarticulo");
      exit;
    }
	
	if (isset($_POST['imprimir']) && $_POST['imprimir'] == 'Yes') 
	{
	    header("Refresh:0; url=etiquetas.php?producto=$idProducto&cantidad=$cantidad");
	}
	else
	{
	    header("Refresh:0; url=articulos.php?status=successarticulo&articulo=$codigo&cantidad=$cantidad");
	}
			
			

	//header("Refresh:0; url=articulos.php?status=successarticulo&articulo=$codigo&cantidad=$cantidad");

?>