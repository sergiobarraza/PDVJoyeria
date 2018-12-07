<?php
	//include 'conexion.php';

  require "config/database.php";
   // require "config/common.php";

	$tipo = $_POST["tipo"];
	
	//echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );
      $sql = "INSERT INTO Tipoprod(nombre) VALUES ('$tipo');";
      $query = $connection->query($sql);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errortipo#nuevotipo");
      exit;
    }
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successtipo&articulo=$tipo#nuevotipo");

?>