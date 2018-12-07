<?php
	//include 'conexion.php';

  require "config/database.php";
   // require "config/common.php";

	$nombresub = $_POST["nombresub"];
	
	//echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );
      $sql = "INSERT INTO Subdepartamento(nombre) VALUES ('$nombresub');";
      $query = $connection->query($sql);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorsubdepto#nuevoDepto");
      exit;
    }
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successsubdepto&articulo=$nombresub#nuevoDepto");

?>