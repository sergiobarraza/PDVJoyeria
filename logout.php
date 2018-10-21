<?php 
session_start();// Destruir todas las variables de sesión.
$_SESSION = array();
session_destroy();
header("Refresh:0; url=login.php");

?>