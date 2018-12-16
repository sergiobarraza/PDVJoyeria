<?php
/*Función llenarDatos.php
*	Es mandada a llamar desde Myclick() y obtiene los datos de un cierto forlio para permitir que el operador los visualice y 
*	si así lo desea pueda editarlos o eliminar el folio.
*/
	//include 'conexion.php';
	$nombre = $_GET['nombre'];
	$apellido = $_GET['apellido'];
	$tel = $_GET['tel'];
	$rfc = $_GET['rfc'];
	$mail = $_GET['mail'];

	$array = [];
	include "../config/database.php";
	try 
	{
      $connection = new PDO($dsn, $username, $password, $options );
      $sql = "INSERT into Persona (nombre, apellido, tel,rfc, email, tipo) VALUES ('$nombre', '$apellido', '$tel', '$rfc', '$mail', 'cliente')";
     
      $query = $connection->query($sql);
	  $sql0 = "SELECT  idPersona, nombre, apellido from Persona where nombre ='$nombre' order by idPersona desc limit 1;";
	   //echo $sql0;
	  $query0 = $connection->query($sql0);
	  $row0 = $query0->fetch(PDO::FETCH_ASSOC);
	  //$nombre = "".$row0["nombre"]." ".$row0["apellido"];
	  array_push($array, $row0);
		  
	} catch (PDOException $error0) {
	  echo $sql0 . "<br>" . $error0->getMessage();
	
	}
	

	

	

	echo json_encode($array);



?>