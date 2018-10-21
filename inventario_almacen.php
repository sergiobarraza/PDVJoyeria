<?php
	$pageSecurity = array("admin");
  require "config/security.php";
  //include 'conexion.php';
    require "config/database.php";
  //require "config/common.php";

	$name = $_POST["alm4"];
  $address = $_POST["direccion"];
  $RFC = $_POST["rfc"];
  $tel = $_POST["tel"];
  $IVA = 0;
	try {
      $connection = new PDO($dsn, $username, $password, $options );
      $sql = "INSERT INTO Almacen(name,address, rfc, tel, iva) VALUES ('$name', '$address', '$RFC', $tel, $IVA);";
      echo $sql;
      $query = $connection->query($sql);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=inventario.php?status=erroralmacen#NuevoAlmacen");

    }

	header("Refresh:0; url=inventario.php?status=successalmacen#NuevoAlmacen");

?>