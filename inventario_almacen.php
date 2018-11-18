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
  $razon = $_POST["razon"];

  $IVA = 0;
	try {
      $connection = new PDO($dsn, $username, $password, $options );
      $sql0= "SELECT idAlmacen from Almacen where name <> 'apartado' ORDER BY CAST(idAlmacen AS unsigned) desc limit 1;";
      $query0 = $connection->query($sql0);
      $row0 = $query0->fetch(PDO::FETCH_ASSOC);
      $IDnuevo = $row0["idAlmacen"] + 1;
      $sql = "INSERT INTO Almacen(idAlmacen, name,address, rfc, tel, iva, nombrefiscal) VALUES ($IDnuevo, '$name', '$address', '$RFC', $tel, $IVA, '$razon') ;";

      $query = $connection->query($sql);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=inventario.php?status=erroralmacen#NuevoAlmacen");

    }

	header("Refresh:0; url=inventario.php?status=successalmacen#NuevoAlmacen");

?>