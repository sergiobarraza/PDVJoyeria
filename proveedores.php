<?php
	$pageSecurity = array("admin");
  	require "config/security.php";
	include("header.php");
	require "config/database.php";
    //require "config/common.php";
	$status="nada";
	$codigo = "";
	$cantidad = 0;
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
	if (isset($_GET['articulo'])) {
		$codigo = $_GET['articulo'];
	}
	if (isset($_GET['cantidad'])) {
		$cantidad = $_GET['cantidad'];
	}
	if ($status == 'successarticulo') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Nuevo Producto Creado!</strong> Código de producto = '.$codigo.' / Cantidad = '.$cantidad.' articulos 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}
?>

<?php 
include "footer.php"; ?>