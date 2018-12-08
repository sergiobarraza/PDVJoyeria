<?php
	$fecha = date("Y-m-d");
	$hora = date("H:i:s");
	$pageSecurity = array("admin");
	require "config/security.php";
	include("header-pdv.php");
	require "config/database.php";
	
	if (isset($_GET['entrada'])) {
		$almEntrada = $_GET['entrada'];
		
	}
	
	if (isset($_GET['articulo'])) {
		$sku = $_GET['articulo'];
		
	}
	if (isset($_GET['cantidad'])) {
		$cantidad = $_GET['cantidad'];
		
	}
	$almacen = $_SESSION['almacen'];
	
	
	try {
		$connection = new PDO($dsn, $username, $password, $options );    
	    $sqldest = "SELECT * from Almacen where idAlmacen = $almEntrada;";
	    $querydest = $connection->query($sqldest);  		      
	    $rowdest = $querydest->fetch(PDO::FETCH_ASSOC);
	    $destName = $rowdest["name"];
	    }catch(PDOException $error) {
	      	echo $sqldest . "<br>" . $error->getMessage();

	    }
	try {    
	    $sql0 = "SELECT * from Almacen where idAlmacen = $almacen;";
	    $query0 = $connection->query($sql0);  		      
	    $row0 = $query0->fetch(PDO::FETCH_ASSOC);

	    } 	catch(PDOException $error) {
	      	echo $sql0 . "<br>" . $error->getMessage();

	    }
	
?>
<div id="printableArea" style="width: 4in; margin: 0; text-align: center;">
	  <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 60%;">
	  <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 38%;">
      <h2 style="padding:0; margin: 0;text-transform: uppercase;">JOYERIA CLAROS</h2>
      <h4 style="padding:0; margin: 0;text-transform: uppercase;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;text-transform: uppercase;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p><br><br>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;"> Fecha: <?php echo $fecha; ?>&nbsp;&nbsp;&nbsp;&nbsp; Hora: <?php echo $hora;?> </p>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;"> Sucursal Origen: <?php echo $row0["name"]; ?> </p>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;"> Sucursal Destino: <?php echo $destName ?> </p>
      <p style="padding:0; margin: 0;text-align: left;">Proceso: Prestamo de producto</p>
      <table style="width: 100%;">
      	<thead style="border-top: 1px dashed;border-bottom: 1px dashed;">

	      	<tr >
	      		<td>Articulo </td>
	      		<td colspan="2"></td>	      			         
	            <td>Cantidad</td>
	      	</tr>
	      	<tr>
	      		<td colspan="2">Proveedor</td>
	      		<td></td>
	      		<td>Tipo</td>
	      	</tr>
	      	
      </thead>
      <tbody>
      	<?php 
      	try 
	      	{
		    
		    	$sqlProductos = "SELECT Producto.codigo, Proveedor.nombre,  Producto.nombre as producto, Tipoprod.nombre as 			tipoprod
								from  Producto 
								join Proveedor on Producto.idProveedor = Proveedor.idProveedor
								join Tipoprod on Tipoprod.idTipoprod = Producto.idTipoprod
								where Producto.codigo = $sku;";							   		    

			    $query1 = $connection->query($sqlProductos);
			    	
	      	 	foreach($query1->fetchAll() as $row1) 
				{
	           
			          
		      		echo '<tr>
		                    <td >'.$row1['codigo'].'</td>  
		                    <td colspan="2">'.$row1['producto'].'</td>
		                    
		                    <td>1</td>
		                                         
		                  </tr>';
		            echo '<tr>
		                    <td colspan="2">'.$row1['nombre'].'</td>  
		                    <td></td>
		                    
		                    <td>'.$row1['tipoprod'].'</td>
		                                         
		                  </tr>';

			    }	 
			      
          		

		    } 	catch(PDOException $error) {
		      	echo $sqlProductos . "<br>" . $error->getMessage();

		    }       	
	    	
      		
      	 ?>
      	
        <tr>
          <td><br></td>
          <td style="border-bottom: 1px dashed;height: 20px;">         </td>
          <td></td>
          <td style="border-bottom: 1px dashed;">         </td>
          <td></td>
        </tr>
      	<tr>
          <td></td>
          <td>Entrega</td>
          <td></td>
          <td>Recibe</td>
          <td></td>
        </tr>

      </tbody>
      </table><br><br>
     
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
					    	window.close();
					    	//location.href= "inventario.php?status=successmovimiento&entrada=$almEntrada&salida=$almSalida&articulo=$sku&cantidad=$cantidad#nuevoMovimiento";
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

