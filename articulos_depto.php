<?php
	//include 'conexion.php';
$pageSecurity = array("admin");
  require "config/security.php";
  require "config/database.php";
   // require "config/common.php";

	$depto = $_POST["depto"];
	$sql = "INSERT INTO Departamento(nombre) VALUES ('$depto');";
	//echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );

      $new_user = array(
        "nombre" => $_POST['depto']
      );


      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errordepto#nuevoDepto");

    }
	//$result = mysqli_query($con, $sql);
	header("Refresh:0; url=articulos.php?status=successdepto#nuevoDepto");

?>