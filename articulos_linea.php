<?php
	$pageSecurity = array("admin");
  require "config/security.php";
  //include 'conexion.php';
  require "config/database.php";
  //require "config/common.php";

	$linea = $_POST["linea"];
	$sql = "INSERT INTO Linea(nombre) VALUES ('$linea');";
	echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );

      $new_user = array(
        "nombre" => $_POST['linea']
      );


      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorlinea#nuevaLinea");
      exit;
    }
 
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successlinea#nuevaLinea");

?>