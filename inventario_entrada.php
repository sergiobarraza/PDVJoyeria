<?php
	//include 'conexion.php';
	require "config/database.php";
    require "config/common.php";

	$codigo = $_POST["sku"];
	$cantidad = $_POST["cantidad"];
	$fecha = date("Y-m-d H:i:s");
	$persona =1;
	//$result1 = mysqli_query($con, $sql1);

	if (isset($_POST['imprimir']) && $_POST['imprimir'] == 'Yes') 
	{
	    echo "Imprimiendo etiquetas";
	}
	else
	{
	    echo "No imprimir etiquetas";
	}
		try {
		      $connection = new PDO($dsn, $username, $password, $options );
		      $sql1 = "SELECT idProducto, codigo from Producto where codigo = $codigo limit 1;";
  		      $query1 = $connection->query($sql1);
  		      if ($query1->rowCount() == 0){
  		     		 header("Location: inventario.php?status=errorentrada#nuevoDepto");
  		     		exit;
  		     	}else {
  		     		$row1 = $query1->fetch(PDO::FETCH_ASSOC);
  		     		$idProducto = $row1["idProducto"];

  		     	}
				
		    } catch(PDOException $error) {
		      echo $sql1 . "<br>" . $error->getMessage();
				header("Location: inventario.php?status=errorentrada#nuevoDepto");
  		     		exit;
		    }
					
		 try {
    		  $sql2 = "INSERT INTO Folio (idAlmacen, idPersona, estado) VALUES (1, 1, 'Entrada Producto');";
    		  $query2 = $connection->query($sql2);

    		  $sql3 = "SELECT idFolio from Folio order by idFolio desc limit 1;";
    		  $query3 = $connection->query($sql3);
    		  $row3 = $query3->fetch(PDO::FETCH_ASSOC);
  		      $folionuevo = $row3["idFolio"];

		      $sql4 = "INSERT INTO Inventario (idProducto, tipo, fecha, idFolio) VALUES ($idProducto, 1, '$fecha', $folionuevo);";						   
			  $query4=[];						   
		   
				for ($i=0; $i < $cantidad ; $i++) { 
					$query4[$i] = $connection->query($sql4);
				}		     

  		      
		    } catch(PDOException $error2) {
		      echo $sql2 . "<br>" . $error2->getMessage();
		      header("Location: inventario.php?status=errorentrada#nuevoDepto");
  		     		exit;

		    }
			
		header("Location: inventario.php?status=successentrada#nuevoDepto");

?>