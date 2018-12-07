<?php
	if ($_SESSION['tipo'] == 'admin') {
 			header("Location: index.php");
 			exit;
 		}else if ($_SESSION['tipo'] == 'venta'){
 			header("Location: pdv2.php");
 			exit;
 		}else if ($_SESSION['tipo'] == 'operador'){
 			header("Location: Trabajos/operador.php");
 			exit;
 		}else if ($_SESSION['tipo'] == 'supervisor'){
 			header("Location: pdv2.php");
 			exit;
 		}else{
 			header("Location: login.php");
 			exit;
 		}
?>