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
    <?php 
      try {
                      $almacen = $_SESSION['almacen'];
                      $connection = new PDO($dsn, $username, $password, $options );
                      $sql = "SELECT name From Almacen where idAlmacen = $almacen;";                
                      $query = $connection->query($sql);
                      foreach($query->fetchAll() as $row) {
                      echo "<h3>Sucursal: ".$row["name"]."</h3>";
                    }
                      

                    } catch(PDOException $error) {
                      echo $sql . "<br>" . $error->getMessage();

                    }
     ?>
    <h3>
    <?php
    	echo "Bienvenido(a) ";
    	echo $_SESSION['username'];
    ?>
		</h3>
    <img src="img/index.jpg" style="display: block; margin: auto;width: 80%;">
  </div>
<?php
	include "footer.php";
?>
