<?php
	$pageSecurity = array("admin");
  	require "config/security.php";
	//include 'conexion.php';
	require "config/database.php";
    //require "config/common.php";

	$codigo = $_POST["idAlmacen"];
	$Nombre = $_POST["Nombre"];
	$Direccion = $_POST["Direccion"];
	$RFC = $_POST["RFC"];
	$Tel = $_POST["Tel"];
	$IVA = $_POST["IVA"];
	$percent = $_POST["percent"];
	$razon = $_POST["razon"];
	try {
		      $connection = new PDO($dsn, $username, $password, $options );
		      $sql1 = "UPDATE Almacen SET name = '$Nombre', address = '$Direccion', rfc='$RFC', tel=$Tel, iva=$IVA, modPrecio = $percent, nombrefiscal = '$razon'   where idAlmacen = $codigo;";
  		      $query1 = $connection->query($sql1);
  		       echo $sql1;
				
		    } catch(PDOException $error) {
		      echo $sql1 . "<br>" . $error->getMessage();
			  header("Location: settings.php?status=error");
  		     		exit;
		    }
		     header("Location: settings.php?status=success&idAlmacen=$codigo");
	//$result1 = mysqli_query($con, $sql1);

?>