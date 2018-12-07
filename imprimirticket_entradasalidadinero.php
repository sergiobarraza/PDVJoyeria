<?php
	$cantidadPagada=0;
	$cambio =0;
	if (isset($_GET['idTransaccion'])) {
		$folio = $_GET['idTransaccion'];
		}
	$pageSecurity = array("admin", "supervisor","venta");
	require "config/security.php";
	include("header-pdv.php");
	require "config/database.php";
	$almacen = $_SESSION['almacen'];
	try {
	    $connection = new PDO($dsn, $username, $password, $options );
	    $sql0 = "SELECT * from Almacen where idAlmacen = $almacen;";
	    $query0 = $connection->query($sql0);  		      
	    $row0 = $query0->fetch(PDO::FETCH_ASSOC);
	    

	    } 	catch(PDOException $error) {
	      	echo $sql . "<br>" . $error->getMessage();

	    }
	try 
	      	{
		    
		    	$sqlProductos = "SELECT * from Transaccion where idTransaccion = $folio";							   		    

			    $query1 = $connection->query($sqlProductos);
			    $Subtotal = 0;
			    $articulos = 0;	
			    $Total = 0;		 
			    $row1 = $query1->fetch(PDO::FETCH_ASSOC);
            		$formatted_number = number_format((float)$row1["monto"], 2, '.', '');
            		$fecha = $row1["fecha"];
		            
          		

		    } 	catch(PDOException $error) {
		      	echo $sql . "<br>" . $error->getMessage();

		    }       	
	    	
?>
<div id="printableArea" style="width: 4in; margin: auto; text-align: center;">
	  <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 45%;">
      <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 45%;">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <h4 style="padding:0; margin: 0;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p>
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $fecha; ?> </p>

      <p style="padding:0; margin: 0;">Proceso: Entrada de dinero</p>
      <table style="width: 100%;">
      	<thead >

	      	<tr style="border-top: 1px dashed;border-bottom: 1px dashed;">
	      		<td># </td>
	      		<td colspan="2">Concepto</td>
	      		
            <td>Tipo</td>
            <td>$$</td>
	      	</tr>
      </thead>
      <tbody>
      	<?php 
	      	echo '<tr>
		                    <td >'.$row1['idTransaccion'].'</td>  
		                    <td colspan="2">'.$row1['concepto'].'</td>
		                    <td>'.$row1['tipoDePago'].'</td>
		                    <td>'.$formatted_number.'</td>
		                                         
		                  </tr>';
      		
      	 ?>
      	<tr>
          <td></td>
          <td>Cajero</td>
          <td></td>
          <td>Autoriza</td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td style="border-bottom: 1px dashed;height: 20px;">         </td>
          <td></td>
          <td style="border-bottom: 1px dashed;">         </td>
          <td></td>
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
    	 
	    		
	    		echo '<script type="text/javascript">
						window.onload = function(){
							var divName = "printableArea";
					    	var printContents = document.getElementById(divName).innerHTML;
					    	var originalContents = document.body.innerHTML;
						    document.body.innerHTML = printContents;
					    	window.print();
					    	document.body.innerHTML = originalContents;
					    	//window.close();
						}
					</script>';
			

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

