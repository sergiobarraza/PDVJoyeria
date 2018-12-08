<?php
	//include 'conexion.php';
	require "config/database.php";
    require "config/common.php";

	$sku = $_POST["sku"];
	$nombre = $_POST["desc"];
	$linea = $_POST["linea"];
	$depto = $_POST["depto"];
	$precio = $_POST["price"];
	$cantidad = $_POST["cantidad"];
	$persona = $_SESSION['user'];
	$fecha = date("Y-m-d H:i:s");
	$Tipoprod = $_POST["Tipo"];
	$Proveedor = $_POST["Proveedor"];
	$subdepto = $_POST["Subdepartamento"];
	$almacen = $_POST["almacen"];
	$Min = $_POST["Min"];
	$costo = $_POST["costo"];
	$idProducto = $_POST["idProd"];

	
	
	try 
	{
	  $connection = new PDO($dsn, $username, $password, $options );
      $sql = "UPDATE Producto set  idDepartamento = $depto, idLinea = $linea, precio = $precio, nombre = '$nombre',  idProveedor = $Proveedor, idTipoprod = $Tipoprod, idSubdepartamento = $subdepto, costo = $costo, preciomin = $Min where idProducto = $idProducto;";
      //echo $sql;							   
      $query = $connection->query($sql);
		      

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorarticulo");
      exit;
    }


if (isset($_POST['agregar']) && $_POST['agregar'] == 'Yes') 
	{
	    //echo "Agregar Producto";
		
	// Da entrada al nuevo producto
	    try 
	    {    		  
	      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen) VALUES ($idProducto, $cantidad, '$fecha', $almacen);";	  
		  $query4 = $connection->query($sql4);
		  //echo $sql4;
		  header("Refresh:0; url=articulos_editar.php?sku=$idProducto&status=successarticulo&articulo=$codigo&cantidad=$cantidad");
		  exit;			     	      
	    } catch(PDOException $error2) {
	      echo $sql4 . "<br>" . $error2->getMessage();
	      header("Refresh:0; url=articulos.php?sku=$idProducto&status=errorarticulo");
	      exit;
	    }
	}else{
		echo "<br>No se agrega Producto";
	}

	if (isset($_POST['imprimir']) && $_POST['imprimir'] == 'Yes') 
	{
	    header("Refresh:0; url=etiquetas_editar.php?producto=$idProducto&cantidad=$cantidad");
	    exit;
	}
	else
	{
	    header("Refresh:0; url=articulos_editar.php?sku=$idProducto&status=successarticulo&articulo=$sku");
	    exit;
	}



	

?>