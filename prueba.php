<?php
	//include 'conexion.php';
	include("header.php");

	require "config/database.php";
    //require "config/common.php";
?>
<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Productos y etiquetas</div>	
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>	
							<th>SKU</th>
							<th>name</th>
	

<?php
    try {
		      $connection = new PDO($dsn, $username, $password, $options );
			  $sql = "SELECT idAlmacen, name from Almacen;";
			  $sqlInventario = "SELECT Inventario.idProducto, Producto.nombre ";
			  $query = $connection->query($sql);
			  $almacenes = [];
			  $i = 0;
			  foreach($query->fetchAll() as $row) {
			  	  $almacenes[$i] = $row["name"];
			  	  $i++;
				  echo "<th>".$row["name"]."</th>";
				  $sqlInventario = $sqlInventario . ", SUM(if(Folio.idAlmacen= ".$row["idAlmacen"].", Inventario.tipo, 0) ) as '".$row["name"]."'";
				}

	} catch (PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	
	}
	?>						<th>Editar</th>
							<th>Imprimir</th>
						</tr>
					</thead>
					<tbody>
	<?php
	$sqlInventario = $sqlInventario . " from Inventario join Folio on Inventario.idFolio = Folio.idFolio join Producto on Inventario.idProducto = Producto.idProducto GROUP BY Inventario.idProducto;";
	try {

		$query1 = $connection->query($sqlInventario);
		foreach($query1->fetchAll() as $row1) {
			echo "<tr>";
				echo "<td>".$row1["idProducto"]."</td>";
				echo "<td>".$row1["nombre"]."</td>";
				for ($j=0; $j <count($almacenes) ; $j++) { 
					echo "<td>".$row1[$almacenes[$j]]."</td>";
				}
			echo "<td><a class='btn btn-primary' href='articulos_editar.php?sku=".$row1["idProducto"]."'>Editar</a></td>";
			echo "<td><a class='btn btn-secondary'>Imprimir</a></td>";
			echo "</tr>";
			  	  
				}
	} catch (PDOException $error1) {
		echo $sqlInventario . "<br>" . $error1->getMessage();
	}
	
?>
					</tbody>		
				</table>
			</div>
		</div>
		<?php 
		
		//echo $sqlInventario;
		echo "<br>almacenes= " . count($almacenes);
		echo "<br>".$almacenes[0];
		echo "<br>".$almacenes[1];
		echo "<br>".$almacenes[2];
		?>

		</div>

<?php
include "footer.php";
?>