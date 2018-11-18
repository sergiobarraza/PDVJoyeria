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
		$cantidad = 5;
			$sql7 = "INSERT INTO Inventario (idProducto, tipo, fecha, idFolio) VALUES (1, -$cantidad, 'Hoy', 5);";
			echo $sql7;
		?>
<div id="printableArea" class="text-center" style="width: 4in; ">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <center style="padding:0; margin: 0;"> Sandra Luz Arellano Urrutia </center>
      <h3 style="padding:0; margin: 0;"> Blanco Sur 316 Local 16 <br>Torreón, Coahuila </h3>
      <h4 style="padding:0; margin: 0;"> RFC: BART090807</h4>
      <p style="padding:0; margin: 0;"> C.P. 27900, Tel: 712-40-60 </p>
      <p style="padding:0; margin: 0;"> Fecha: 24/Sept/208 </p>
      <p style="padding:0; margin: 0;">Folio: 789</p>
      <p style="padding:0; margin: 0;">Proceso: Venta de Contado</p>
      <table >
      	<thead >
	      	<tr style="border-top: 1px dashed;">
	      		<td># </td>
	      		<td colspan="3">Nombre</td>
	      		<td>Cantidad</td>
	      	</tr>
	      	<tr style="border-bottom: 1px dashed;">
	      		<td></td>
	      		<td>P.Unit</td>
	      		<td></td>
	      		<td>Dcto</td>
	      		
	      		<td>Importe</td>
	      	</tr>
      </thead>
      <tbody>
      	<tr>
      		<td class ="pr-3">1234</td>	
      		<td colspan="3">Collar de persona</td>
      		<td>2</td>
      	</tr>
      	<tr>
      		<td></td>
      		<td>167.00</td>
      		<td></td>
      		<td>0%</td>
      		<td>334.00</td>
      	</tr>
      </tbody>
      </table>
</div>
<style>
@page { size: auto;  margin: 0mm; }
</style>

<input type="button" onclick="printDiv('printableArea')" value="print a div!" />
<?php
include "footer.php";
?>

<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>