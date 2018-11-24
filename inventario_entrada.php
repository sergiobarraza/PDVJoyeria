<?php
	$pageSecurity = array("admin");
  require "config/security.php";
	//include 'conexion.php';
	require "config/database.php";
    //require "config/common.php";

	$codigo = $_POST["sku"];
	$cantidad = $_POST["cantidad"];
	$fecha = date("Y-m-d H:i:s");
	$persona =$_SESSION['user'];
	$almacen = $_POST["almacen"];
	//$result1 = mysqli_query($con, $sql1);

	if (isset($_POST['imprimir']) && $_POST['imprimir'] == 'Yes') 
	{
	    echo "Imprimiendo etiquetas";
	}
	else
	{
	    echo "No imprimir etiquetas";
	}
	//Verifica que el producto introducido sea existente.
	try {
	      $connection = new PDO($dsn, $username, $password, $options );
	      $sql1 = "SELECT idProducto, codigo from Producto where codigo = $codigo limit 1;";
		      $query1 = $connection->query($sql1);
		      if ($query1->rowCount() == 0){
		     		 header("Location: inventario.php?status=errorentrada&articulo=$codigo#nuevoDepto");
		     		exit;
		     	}else {
		     		$row1 = $query1->fetch(PDO::FETCH_ASSOC);
		     		$idProducto = $row1["idProducto"];

		     	}
			
	    } catch(PDOException $error) {
	      echo $sql1 . "<br>" . $error->getMessage();
			header("Location: inventario.php?status=errorconexion");
		     		exit;
	    }
					
		 try {/*
		 	  $sql5 = "SELECT codigo FROM Folio ORDER BY CAST(codigo AS unsigned) desc limit 1;";
    		  $query5 = $connection->query($sql5);
    		  $row5 = $query5->fetch(PDO::FETCH_ASSOC);
  		      $codigonuevo = $row5["codigo"];
  		      $codigonuevo = $codigonuevo + 1;

    		  $sql2 = "INSERT INTO Folio (idAlmacen, idPersona, estado, codigo) VALUES ($almacen, $persona , 'Entrada Producto', $codigonuevo);";
    		  echo $sql2;
    		  $query2 = $connection->query($sql2);

    		  $sql3 = "SELECT idFolio from Folio order by idFolio desc limit 1;";
    		  $query3 = $connection->query($sql3);
    		  $row3 = $query3->fetch(PDO::FETCH_ASSOC);
  		      $folionuevo = $row3["idFolio"];*/

		      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idAlmacen) VALUES ($idProducto, $cantidad, '$fecha', $almacen);";
		      $query4 = $connection->query($sql4);
		    } catch(PDOException $error2) {
		      echo $sql2 . "<br>" . $error2->getMessage();
		      header("Location: inventario.php?status=errorconexion");
  		     		exit;

		    }
			
		header("Location: inventario.php?status=successentrada&articulo=$codigo&cantidad=$cantidad");

?>