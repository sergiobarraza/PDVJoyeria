<?php
  $pageSecurity = array( "admin", "supervisor");
  require "config/security.php";
  require "config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);
  $fecha = date("Y-m-d ");
  $hora = date("H:i:s");
  $almacen = $_SESSION['almacen'];
  include "header-pdv.php";
  
  try   
  {
		  $sql0 = "SELECT * from Almacen where idAlmacen = $almacen;";
	      $query0 = $connection->query($sql0);  		      
	      $row0 = $query0->fetch(PDO::FETCH_ASSOC);
			
	} catch(PDOException $error) {
	  echo $sql0 . "<br>" . $error->getMessage();
	}

  

?>
<div id="printableArea" class="text-center" style="width: 4in; ">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <h5 style="padding:0; margin: 0;"> Sandra Luz Arellano Urrutia </center>
      <h5 style="padding:0; margin: 0;"> <?php echo $row0["address"]; ?></h3>
      <h5 style="padding:0; margin: 0;"> RFC:  <?php echo $row0["rfc"]; ?></h4>
      <p style="padding:0; margin: 0;">Tel:  <?php echo $row0["tel"]; ?> </p>
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $fecha; ?> Hora: <?php echo $hora; ?> </p>

      <p style="padding:0; margin: 0;">Proceso: Corte de caja</p>
      <?php 
      	$sql1 = "SELECT Folio.idAlmacen,Folio.idFolio, Folio.codigo, Transaccion.monto, Transaccion.fecha, Transaccion.tipoDePago 
			from Folio 
			join Transaccion on Folio.idFolio = Transaccion.idFolio";
      ?>
      <table style="width: 100%;">
      	<thead >
	      	<tr style="border-top: 1px dashed;border-bottom: 1px dashed;">
	      		<td># </td>
	      		<td colspan="2">Nombre</td>
	      		<td>Tipo</td>
	      		<td>Cantidad</td>
	      		<td>$$</td>
	      	</tr>
	      	
      </thead>
      <tbody style="border-bottom: 1px dashed;">
      	<tr>
      		<td >1234</td>	
      		<td colspan="2">Collar de persona</td>
      		<td>Venta</td>
      		<td>2</td>
      		<td>200.00</td>
      	</tr>
      	<tr>
      		<td >1234</td>	
      		<td colspan="2">Collar de persona</td>
      		<td>Venta</td>
      		<td>2</td>
      		<td>200.00</td>
      	</tr>
      	<tr>
      		<td >1234</td>	
      		<td colspan="2">Collar de persona</td>
      		<td>Venta</td>
      		<td>2</td>
      		<td>200.00</td>
      	</tr>
      	
      </tbody >
      <tfoot>
      	<tr>
      		<td></td>
      		<td colspan="2"></td>
      		<td></td>
      		<td>Total:</td>
      		<td>600.00</td>

      	</tr>
      </tfoot>
      </table>
</div>
<style>
@page { size: auto;  margin: 0mm; }
</style>

<input type="button" class="btn btn-success" onclick="printDiv('printableArea')" value="Corte de Caja" />
<?php
	include "footer-pdv.php";
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