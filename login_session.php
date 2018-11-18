<?php
    require "config/database.php";

session_start();
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$user=$_POST['username'];
	$pass=$_POST['password'];
	$almacen =$_POST['almacen'];
	echo $user;
	echo $password;
	echo $almacen;
	try {
		$connection = new PDO($dsn, $username, $password, $options );
      	$sql = "SELECT idUsuario, tipo From Usuario where nombre = '$user' and password = '$pass';";							   
      	$query = $connection->query($sql);
  		      if ($query->rowCount() == 0){
  		     		 header("Location: login.php?status=errorlogin");
  		     		exit;
  		     	}else {
  		     		$row = $query->fetch(PDO::FETCH_ASSOC);
  		     		$idUser = $row["idUsuario"];
  		     		$tipo = $row["tipo"];
  		     		$_SESSION['user']=$idUser;
  		     		$_SESSION['username']=$user;
  		     		$_SESSION['tipo']=$tipo;
  		     		$_SESSION['almacen']=$almacen;
  		     		if ($tipo == 'admin') {
  		     			header("Location: index.php");
  		     			exit;
  		     		}else if ($tipo == 'venta'){
  		     			header("Location: pdv2.php");
  		     			exit;
  		     		}else if ($tipo == 'operador'){
  		     			header("Location: sistemajoyeria.php");
  		     			exit;
  		     		}
 

  		     	}
	} catch(PDOException $error) {
	    echo $sql . "<br>" . $error->getMessage();
		header("Location: login.php?status=errorconnection");
     	exit;
    }
	/*
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter
	$connection = mysql_connect("localhost", "root", "");
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	// Selecting Database
	$db = mysql_select_db("company", $connection);
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select * from login where password='$password' AND username='$username'", $connection);
	$rows = mysql_num_rows($query);
	if ($rows == 1) {
	$_SESSION['login_user']=$username; // Initializing Session
	header("location: profile.php"); // Redirecting To Other Page
	} else {
	$error = "Username or Password is invalid";
	}
	mysql_close($connection); // Closing Connection
	
    header("Location: index.php");*/
  
?>