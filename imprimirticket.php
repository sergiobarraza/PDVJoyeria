<?php

	if (isset($_GET['folio'])) {
		$folio = $_GET['folio'];
		if ($folio == "") {
			echo "fallo";
			header("Location: error.php");
			exit;
		}
	}else{
		header("Location: error.php");
		exit;
	}
	$pageSecurity = array("admin");
	require "config/security.php";
	include("header-pdv.php");
	require "config/database.php";
	try {
	    $connection = new PDO($dsn, $username, $password, $options );
	    $sql = "SELECT * from  Folio where idFolio = $folio and estado = 'venta';";							   
	    $query = $connection->query($sql);
	      

	    } 	catch(PDOException $error) {
	      	echo $sql . "<br>" . $error->getMessage();

	    }
?>
<div id="printableArea" class="text-center" style="width: 4in; margin: auto;">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <center style="padding:0; margin: 0;"> Sandra Luz Arellano Urrutia </center>
      <h3 style="padding:0; margin: 0;"> Blanco Sur 316 Local 16 <br>Torreón, Coahuila </h3>
      <h4 style="padding:0; margin: 0;"> RFC: BART090807</h4>
      <p style="padding:0; margin: 0;"> C.P. 27900, Tel: 712-40-60 </p>
      <p style="padding:0; margin: 0;"> Fecha: 24/Sept/208 </p>
      <p style="padding:0; margin: 0;">Folio: <?php echo $folio;?></p>
      <p style="padding:0; margin: 0;">Proceso: Venta de Contado</p>
      <table style="width: 100%;">
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

<?php
	include "footer-pdv.php";
?>
<script type="text/javascript">
	window.onload = function(){
		var divName = 'printableArea';
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>