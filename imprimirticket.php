<?php
	$cantidadPagada=0;
	$cambio =0;
	$tarjeta=0;
	if (isset($_GET['folio'])) {
		$folio = $_GET['folio'];
	}
	if (isset($_GET['cambio'])) {
		$cambio = $_GET['cambio'];
	}
	if (isset($_GET['cantidad_efectivo'])) {
		$cantidadPagada = $_GET['cantidad_efectivo'];
	}
	if (isset($_GET['cantidad'])) {
		$tarjeta = $_GET['cantidad_tarjeta'];
	}
	
	$pageSecurity = array("admin");
	require "config/security.php";
	include("header-pdv.php");
	require "config/database.php";
	try {
	    $connection = new PDO($dsn, $username, $password, $options );
	    $sql = "SELECT Venta.idFolio, Venta.idInventario, Inventario.idAlmacen, Almacen.name, Almacen.nombrefiscal, Almacen.rfc, Almacen.tel, Almacen.imagen, Almacen.address, Inventario.fecha,  Folio.idPersona, Almacen.codigoPostal
			from Venta 
			join Inventario on Venta.idInventario = Inventario.idInventario
			join Almacen on Inventario.idAlmacen = Almacen.idAlmacen
			join Folio on Folio.idFolio = Venta.idFolio
			where Venta.idFolio = $folio
			limit 1";

		    //echo $sql;
		    $query = $connection->query($sql);
		    $rows = $query->rowCount();
		    $row0 = $query->fetch(PDO::FETCH_ASSOC);
	    

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
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $row0["fecha"]; ?> </p>
      <p style="padding:0; margin: 0;">Folio: <?php echo $row0["idFolio"]; ?></p>
      <p style="padding:0; margin: 0;">Cliente: <?php echo $row0["idPersona"]; ?></p>
      <p style="padding:0; margin: 0;">Proceso: Venta</p>
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
      	<?php 
	      	try 
	      	{
		    
		    	$sqlProductos = "SELECT Venta.idFolio,  Venta.idInventario, Producto.codigo, Producto.nombre,Inventario.tipo, SUM(Transaccion.monto), Venta.descuento
				from Venta
				join Transaccion on Venta.idTransaccion = Transaccion.idTransaccion
				join Inventario on Venta.idInventario = Inventario.idInventario 
				join Producto on Inventario.idProducto = Producto.idProducto
				group by Venta.idFolio,  Venta.idInventario,Venta.descuento,Producto.codigo,Producto.nombre,Inventario.tipo
				having Venta.idFolio = $folio";							   
		    

			    $query2 = $connection->query($sqlProductos);
			    $Subtotal = 0;
			    $articulos = 0;	
			    $Total = 0;	
			    $descuentopesos=0;	 
			    foreach($query2->fetchAll() as $row) 
			    {
			    	
			    	$totalpagado = $row["SUM(Transaccion.monto)"];
			    	$totalpagadoR = floor($totalpagado*pow(10,2))/pow(10,2);
			    	$Total = $Total + $totalpagadoR;
			    	$descuento = $row["descuento"];

			    	$cantidad = $row["tipo"] * (-1);
			    	$articulos= $articulos + $cantidad;
			    	//echo "Cantidad= ".$cantidad;
			    	$unitario= (($totalpagadoR / (1-$descuento/100)))/$cantidad;
			    	$descuentopesos= $descuentopesos - $totalpagadoR + $unitario * $cantidad;
			    	$Subtotal = $Subtotal + $unitario*$cantidad;
			    	//echo "Unitairo= ".$unitario;
			    //echo floor($totalpagado*pow(10,2))/pow(10,2);
				  echo "<tr>
      						<td class ='pr-3'>".$row["codigo"]."</td>
      						<td colspan='3'>".$row["nombre"]."</td>
      						<td>".$cantidad."</td>
      					</tr>
      					<tr>
      						<td></td>
      						<td>".$unitario."</td>
      						<td></td>
      						<td>".$descuento."%</td>
      						<td>".$totalpagadoR."</td>
      					</tr>
      						";
				}

		    } 	catch(PDOException $error) {
		      	echo $sql . "<br>" . $error->getMessage();

		    }
      		
      	 ?>
      	<tr style="border-top: 1px dashed;">
      		<td colspan="2"><?php echo $articulos; ?> Art(s)</td>
      		<td colspan="2">Subtotal</td>
      		<td><?php echo floor($Subtotal*pow(10,2))/pow(10,2); ?></td>
      	</tr>
      	<tr>
      		<td colspan="2"></td>
      		<td colspan="2">Dcto: </td>

      		<td><?php  echo floor($descuentopesos*pow(10,2))/pow(10,2); ?></td>
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
      	<tr>
      		<td></td>
      		<td>Pago Tarjeta:</td>
      		<td></td>
      		<td><?php echo $tarjeta; ?> </td>
      	</tr>
      	<tr>
      		<td></td>
      		<td>Efectivo Entregado:</td>
      		<td></td>
      		<td><?php echo $cantidadPagada; ?> </td>
      	</tr>
      	<tr>
      		<td></td>
      		<td>Cambio:</td>
      		<td></td>
      		<td><?php echo $cambio; ?> </td>
      	</tr>
      	<tr style="border-top: 1px dashed;">
      		<td colspan="5">Esta nota sera incluida en la Factura Global</td>
      	</tr>

      </tbody>
      </table>
      <BR>
      <h5>NO HAY CAMBIO NI DEVOLUCIONES</h5>
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

