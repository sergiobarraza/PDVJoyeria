<?php
	session_start();
	include 'conexion.php';
	
	$usuario = $_REQUEST["usuario"];
	$contrasena = $_REQUEST["clave"];
	$_SESSION["logueado"] = false;

	$sql = "SELECT * FROM usuario WHERE usuario='$usuario'";
	$result = mysqli_query($con, $sql);
	$_SESSION["logueado"] = 0;
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        	if ($row["usuario"] == $usuario && $row["password"]==$contrasena ){
        		$_SESSION["logueado"] = true;
        		break;
        	}
    	}
	}

	if ($_SESSION["logueado"]==true){

		if ($row["tipo"] == "operador" ){
			header("Location: operador2.php");
		}else{
			header("Location: index.php");
		}
	}
	else{
		header("Location: inicio.php");
	}
?>