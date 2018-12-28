<?php
$pageSecurity = array("admin", "supervisor","venta");
require "config/security.php";
include("header-pdv.php");
require "config/database.php";
$almacen = $_SESSION['almacen'];
		?>
<form>
	<div class="container text-center mt-5">
		<h2>Folios de venta</h2>
		<div class="row"style="margin-bottom: 10px;">
			<div class="col-sm-0 col-md-2"></div>
			<label for="folioid" class="col-sm-2 col-form-label">Codigo de Producto:</label>
			<div class="col-sm-10 col-md-6">
				
					<input type="text" name="folioid" class="form-control col-sm-10 has-error"  id="folioid" autofocus="autofocus"  required="">
					
				
			</div>
			<div class="col-sm-0 col-md-2"></div>

		</div>
		
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-sm-0 col-md-2"></div>
			<label for="folioid" class="col-sm-2 col-form-label">Sucural Destino:</label>
			<div class="col-sm-10 col-md-6">
				<select type="select" name="alm" class="form-control col-sm-10"  id="Alm">					
					<?php 
					$connection = new PDO($dsn, $username, $password, $options );
					$sql = "SELECT * From Almacen where name <> 'apartado' and idAlmacen <> $almacen;";

			      $query = $connection->query($sql);
			      foreach($query->fetchAll() as $row) {
					  echo "<option value='".$row["idAlmacen"]."'>".$row["name"]."</option>";
					}
										 ?>
				</select>
			</div>
			
						
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-2"></div>
			<div class="col-sm-4 col-md-6">
				<button type="success" class="btn btn-success"   autofocus="autofocus">	Prestar</button>								
			</div>
			
						
		</div>
	</div>
</form>	
<?php 
		include "footer-pdv.php";

?>
<script type="text/javascript">
	<?php 
	//$folio=0;
		if (isset($_GET['folioid'])) {
			$folio = $_GET['folioid'];
			
		}
		if(isset($_GET['alm'])) {
			$alm = $_GET['alm'];
			
		}
			
	    	//location.href= "Trabajos/index.php?folio=$folio";
	    	//window.close();
		if (isset($_GET['fallo'])) {
			
		}else{
			$sql1= "SELECT idProducto from Producto where codigo =$folio;";
			$query1 = $connection->query($sql1);
			if ($query1->rowCount() == 0){
					echo "window.onload = function(){
								location.href='prestamo.php?status=fallo';
							}
						";
			}else{

				echo "window.onload = function(){
					window.open('imprimirticket_prestamo.php?articulo=".$folio."&entrada=".$alm."', '_blank');

			}";
			}
		}

	
	 ?>
	/*function myFunction(){
		
			window.open('imprimirticket_prestamo.php?folio='+idfolio+'&almEntrada='+almacen, '_blank'); // will open new tab on 
		

	}*/
</script>