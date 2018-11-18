<?php
  $pageSecurity = array("admin");
  require "config/security.php";
	include("header.php");
  require "config/database.php";
?>
	<!-- Area Chart Example-->
  <div class="text-center">
  	<h1>Punto de Venta Joyería Claro</h1>
    <h2>Panel de Administración</h2>
    <h3>Sucursal: Almacen Central</h3>
    <h3>
    <?php
    	echo "Bienvenido(a) ";
    	echo $_SESSION['username'];
      echo $_SESSION['tipo'];
      echo $_SESSION['almacen'];
    ?>
		</h3>
    <img src="img/index.jpg" style="display: block; margin: auto;width: 80%;">
  </div>
<?php
	include "footer.php";
?>
