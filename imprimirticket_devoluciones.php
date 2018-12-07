<?php
	$cantidadPagada=0;
	$cambio =0;
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
	}if (isset($_GET['cantidad'])) {
		$cantidadPagada = $_GET['cantidad'];
	}
	if (isset($_GET['cambio'])) {
		$cambio = $_GET['cambio'];
	}
	$fecha = date("d-M-Y");

	$pageSecurity = array("admin", "supervisor","venta");
	require "config/security.php";
	include("header-pdv.php");
	require "config/database.php";
	$almacen = $_SESSION['almacen'];
	try {
	    $connection = new PDO($dsn, $username, $password, $options );
	    $sql = "SELECT * from Almacen where idAlmacen = $almacen";

		    //echo $sql;
		    $query = $connection->query($sql);
		    $rows = $query->rowCount();
		    $row0 = $query->fetch(PDO::FETCH_ASSOC);
	    

	    } 	catch(PDOException $error) {
	      	echo $sql . "<br>" . $error->getMessage();

	    }
	    $sqlCliente = "SELECT Persona.nombre from Folio join Persona on Folio.idPersona = Persona.idPersona where Folio.idFolio = $folio";
	    $queryCliente = $connection->query($sqlCliente);
	    $rowCliente = $queryCliente->fetch(PDO::FETCH_ASSOC);
	       	
	    	
?>
<div id="printableArea" style="width: 4in; margin: auto; text-align: center;">
	  <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 45%;">
	  <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 45%;">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <h4 style="padding:0; margin: 0;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p><br>
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $fecha; ?> </p>
      <p style="padding:0; margin: 0;">Folio: <?php echo $folio; ?></p>
      <p style="padding:0; margin: 0;">Cliente: <?php echo $rowCliente["nombre"]; ?></p>
      <p style="padding:0; margin: 0;">Proceso: Devolucion</p>
      <table style="width: 100%;">
      	<thead >

	      	<tr style="border-top: 1px dashed;">
	      		<td># </td>
	      		<td colspan="3">Producto Devuelto</td>
	      		<td>Precio</td>
	      	</tr>
	      	
      </thead>
      <tbody>
      	
      	 <tr style="border-top: 1px dashed;border-bottom: 1px dashed;">
	      		<td># </td>
	      		<td colspan="3">Producto Entregado</td>
	      		<td>Precio</td>
      	 </tr>
      	<tr style="border-top: 1px dashed;">
      		<td colspan="2"><?php echo 5; ?> Art(s)</td>
      		<td colspan="2">Subtotal</td>
      		<td><?php echo "1500.00";$Total = 1;$Subtotal = 2; ?></td>
      	</tr>
      	<tr>
      		<td colspan="2"></td>
      		<td colspan="2">Dcto: </td>

      		<td><?php $descuento= 100- $Total * 100 /$Subtotal; echo floor($descuento*pow(10,2))/pow(10,2); ?></td>
      	</tr>
      	<tr>
      		<td colspan="2"></td>
      		<td colspan="2">Total: </td>
      		<td><?php echo $Total ?></td>
      	</tr>
      	<tr style="border-bottom: 1px dashed;">
      		<td colspan="5">
      			<?php include "numero_letras.php";echo numtowords($Total); ?>
      		</td>
      	</tr>

   

      </tbody>
      </table>
</div>
<style>
@page { size: auto;  margin: 0mm; }
</style>

<?php
	//include "footer-pdv.php";
?>
<!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <?php 
    	 
	    	if ($rows > 0) {	
	    		echo '<script type="text/javascript">
						window.onload = function(){
							var divName = "printableArea";
					    	var printContents = document.getElementById(divName).innerHTML;
					    	var originalContents = document.body.innerHTML;
						    document.body.innerHTML = printContents;
					    	window.print();
					    	document.body.innerHTML = originalContents;
					    	window.close();
						}
					</script>';
			}else{
				echo '<script type="text/javascript">
						window.onload = function(){
						window.close();
						}
					</script>';
		
			}

     ?>
<!--script type="text/javascript">
	window.onload = function(){
		var divName = 'printableArea';
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script-->

