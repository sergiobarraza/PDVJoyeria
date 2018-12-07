<?php
	//include 'conexion.php';

  require "config/database.php";
   // require "config/common.php";

	$proveedor = $_POST["proveedor"];
	
	//echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );
      $sql = "INSERT INTO Proveedor(nombre) VALUES ('$proveedor');";
      $query = $connection->query($sql);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorproveedor#nuevoproveedor");
      exit;
    }
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successproveedor&articulo=$proveedor#nuevoproveedor");

?>