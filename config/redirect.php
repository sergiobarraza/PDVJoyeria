<?php
	if ($_SESSION['tipo'] == 'admin') {
 			header("Location: /PDVJoyeria/index.php");
 			exit;
 		}else if ($_SESSION['tipo'] == 'venta'){
 			header("Location: /PDVJoyeria/pdv2.php");
 			exit;
 		}else if ($_SESSION['tipo'] == 'operador'){
 			header("Location: /PDVJoyeria/Trabajos/operador.php");
 			exit;
 		}else if ($_SESSION['tipo'] == 'supervisor'){
 			header("Location: pdv2.php");
 			exit;
 		}else{
 			header("Location: /PDVJoyeria/login.php");
 			exit;
 		}
?>