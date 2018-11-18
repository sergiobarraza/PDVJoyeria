<?php
	session_start(); 
	if($_SESSION["logueado"] != true){	 
	  	header("Location: inicio.php"); 
	  	exit(); 
	}


?>