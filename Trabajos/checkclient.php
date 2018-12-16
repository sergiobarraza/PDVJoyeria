<?php
/*Función llenarDatos.php
*	Es mandada a llamar desde Myclick() y obtiene los datos de un cierto forlio para permitir que el operador los visualice y 
*	si así lo desea pueda editarlos o eliminar el folio.
*/
	//include 'conexion.php';
	$nombre = $_GET['nombre'];
	$apellido = $_GET['apellido'];
	

	$array = [];
	include "../config/database.php";
	try 
	{
      $connection = new PDO($dsn, $username, $password, $options );
      
	  $sql0 = "SELECT  idPersona, nombre, apellido from Persona where nombre ='$nombre' and apellido='$apellido' order by idPersona desc limit 1;";
	   //echo $sql0;

	  $query0 = $connection->query($sql0);
	  if ($query0->rowCount() == 0)
	  {
	  	array_push($array, [0,0,0]);
		
	  }
	  else
	  {
	  	$row0 = $query0->fetch(PDO::FETCH_ASSOC);	  	
	  	array_push($array, $row0);
	  	
	  }
	  
		  
	} catch (PDOException $error0) {
	  echo $sql0 . "<br>" . $error0->getMessage();
	
	}
	
	echo json_encode($array);
	



?>