<?php
	$fecha = date("Y-m-d");
	$hora = date("H:i:s");
	$pageSecurity = array("admin");
	require "config/security.php";
	include("header-pdv.php");
	require "config/database.php";
	
	if (isset($_GET['sucursal'])) {
		$sucursal = $_GET['sucursal'];
		
	}
	
	if (isset($_GET['articulo'])) {
		$sku = $_GET['articulo'];
		
	}
	if (isset($_GET['cantidad'])) {
		$cantidad = $_GET['cantidad'];
		
	}
	$almacen = $_SESSION['almacen'];
	$origen = 0;
	//$almacen = $_SESSION['almacen'];
	try {
		    $connection = new PDO($dsn, $username, $password, $options );
		    $sqlorigen = "SELECT * from Almacen where idAlmacen = $sucursal;";
		    $queryorigen = $connection->query($sqlorigen);  		      
		    $roworigen = $queryorigen->fetch(PDO::FETCH_ASSOC);
		    $origenName = $roworigen["name"];
	    } 	catch(PDOException $error) {
	      	echo $sqlorigen . "<br>" . $error->getMessage();

	    }
	
	try {    
	    $sql0 = "SELECT * from Almacen where idAlmacen = $almacen;";
	    $query0 = $connection->query($sql0);  		      
	    $row0 = $query0->fetch(PDO::FETCH_ASSOC);

	    } 	catch(PDOException $error) {
	      	echo $sql0 . "<br>" . $error->getMessage();

	    }
	
?>
<div id="printableArea" style="width: 4in; margin: auto; text-align: center;">
      <h2 style="padding:0; margin: 0;">JOYERIA CLAROS</h2>
      <h4 style="padding:0; margin: 0;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p><br>
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $fecha; ?> Hora: <?php echo $hora; ?> </p>
      <p style="padding:0; margin: 0;"> Sucursal: <?php echo $origenName ?> </p>
      <p style="padding:0; margin: 0;">Proceso: Salida de producto</p>
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
		    
		    	$sqlProductos = "SELECT Producto.codigo, Proveedor.nombre, Inventario.tipo, Producto.nombre as producto, Tipoprod.nombre as 			tipoprod
								from Inventario 
								join Producto on Inventario.idProducto = Producto.idProducto
								join Proveedor on Producto.idProveedor = Proveedor.idProveedor
								join Tipoprod on Tipoprod.idTipoprod = Producto.idTipoprod
								where Producto.codigo =$sku
								order by idInventario desc
								limit 1;";							   		    

			    $query1 = $connection->query($sqlProductos);
			    	
	      	 	foreach($query1->fetchAll() as $row1) 
				{
	           
			          
		      		echo '<tr>
		                    <td >'.$row1['codigo'].'</td>  
		                    <td colspan="2">'.$row1['producto'].'</td>
		                    
		                    <td>'.($row1['tipo']*-1).'</td>
		                                         
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
          <td>Autoriza</td>
          <td></td>
          <td>Realiza</td>
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
					    	location.href= "inventario.php?status=successesalida&sucursal='.$sucursal.'&articulo='.$sku.'&cantidad='.$cantidad.'#nuevaSalida";
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

