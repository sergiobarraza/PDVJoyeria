<?php
$pageSecurity = array("admin");
require "config/security.php";
include("header-pdv.php");
require "config/database.php";
		?>
<div class="container text-center mt-5">
	<h2>Folios de venta</h2>
	<div class="row">
		<div class="col-sm-0 col-md-2"></div>
		<label for="folioid" class="col-sm-2 col-form-label">Folio de Venta:<i class="fa fa-search pl-4 pt-2"></i></label>
		<div class="col-sm-10 col-md-6">
			<form>
				<input type="text" name="folioid" class="form-control col-sm-10" style="margin: 0px;width:100%;display: inline-block;" id="folioid" autofocus="autofocus" onchange="foliofield();">
			</form>
		</div>
		<div class="col-sm-0 col-md-2"></div>

	</div>
	<?php
	  try 
	  {
        $connection = new PDO($dsn, $username, $password, $options );
        $sql0= "SELECT Folio.idFolio, Folio.idPersona, Folio.fechaDeCreacion, EstadoDeFolio.nombre, Persona.nombre as cliente, Persona.apellido  
		from Venta 
		join Folio on Venta.idFolio = Folio.idFolio
		join EstadoDeFolio on EstadoDeFolio.idEstadosDeFolio = Folio.idEstadoDeFolio
		join Persona on Folio.idPersona = Persona.idPersona
		group by Folio.idFolio
		limit 10000;";
        $query0 = $connection->query($sql0);
        
       
      } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
        header("Refresh:0; url=pdv2.php");

      }
	?>
	<!-- Example DataTables Card-->
    <div class="card mb-3 mt-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Folios de Venta</div>	
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>	
							<th>Codigo</th>
							<th>#Cliente</th>
							<th>Cliente</th>
							<th>Fecha</th>
							<th>Estado</th>
							<th>Seleccionar</th>
						</tr>
						
					</thead>
					<tbody>
						<?php 
							foreach($query0->fetchAll() as $row) {
							  echo "<tr>
							  			<td>".$row["idFolio"]."</td>
										<td>".$row["idPersona"]."</td>
										<td>".$row["cliente"]." ".$row["apellido"]."</td>
										<td>".$row["fechaDeCreacion"]."</td>
										<td>".$row["nombre"]."</td>
										<td><input href='foliosventa.php?folio=".$row["idFolio"]."' class='btn btn-success' value='Seleccionar' onclick='myFunction(".$row["idFolio"].")'></td>
									</tr>";
							}
						 ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php 
		include "footer-pdv.php";

?>
<script type="text/javascript">
	<?php 
		if (isset($_GET['folioid'])) {
			$folio = $_GET['folioid'];
			echo 'window.open("imprimirticket_reimpresion.php?folio="+'.$folio.', "_blank");';
		}
	 ?>
	function myFunction(idfolio){
		//locaition.href="mprimirticket.php?folio="+idfolio;
		//var url = 
		window.open("imprimirticket_reimpresion.php?folio="+idfolio, "_blank"); // will open new tab on window.onload
	}
</script>