<?php
/*Función llenarDatos.php
*	Es mandada a llamar desde Myclick() y obtiene los datos de un cierto forlio para permitir que el operador los visualice y 
*	si así lo desea pueda editarlos o eliminar el folio.
*/
	include 'conexion.php';
	$folio = $_GET['folio'];
	$array = [];

	$sql = "SELECT idTrabajo, tiempo_estimado, precio, idCliente, comentario from trabajo  where idTrabajo =$folio limit 1;";

	$result = mysqli_query($con, $sql);
	$count = $result->num_rows;
	
	for ($i=0; $i < $result->num_rows; $i++) {      
	    $opcion = $result->fetch_assoc();
	    $idCliente = $opcion["idCliente"];
	    array_push($array, $opcion);
	}

	include "../config/database.php";
	try 
	{
      $connection = new PDO($dsn, $username, $password, $options );
	  $sql0 = "SELECT  nombre, apellido from Persona where idPersona =$idCliente;";
	  $query0 = $connection->query($sql0);
	  $row0 = $query0->fetch(PDO::FETCH_ASSOC);
	  //$nombre = "".$row0["nombre"]." ".$row0["apellido"];
	  array_push($array, $row0);
		  
	} catch (PDOException $error0) {
	  echo $sql0 . "<br>" . $error0->getMessage();
	
	}

	echo json_encode($array);



?>