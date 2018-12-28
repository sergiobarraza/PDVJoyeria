<?php
	//include 'Trabajos/conexion.php';
	$pageSecurity = array("admin","supervisor","venta");
	require "config/security.php";
	$cantidadPagada=0;
	$cambio =0;
	
	$cliente = 34;
	if (isset($_GET['folio'])) {
		$folio = $_GET['folio'];
		
	}

	include("header-pdv.php");
	require "config/database.php";
	$almacen = $_SESSION['almacen'];
	$fecha = date("Y-m-d");
	$hora = date("H:i:s");
	try {
	    $connection = new PDO($dsn, $username, $password, $options );
	    $sql0 = "SELECT * from Almacen where idAlmacen = $almacen;";
	    $query0 = $connection->query($sql0);  		      
	    $row0 = $query0->fetch(PDO::FETCH_ASSOC);
	    

	    } 	catch(PDOException $error) {
	      	echo $sql . "<br>" . $error->getMessage();

	    }
	    try {
	    $connection = new PDO($dsn, $username, $password, $options );
	    $sql = "SELECT Venta.idFolio, Venta.idInventario, Inventario.idAlmacen, Almacen.name, Almacen.nombrefiscal, Almacen.rfc, Almacen.tel, Almacen.imagen, Almacen.address, Inventario.fecha,  Folio.idPersona, Almacen.codigoPostal, Persona.nombre, Persona.apellido
			from Venta 
			join Inventario on Venta.idInventario = Inventario.idInventario
			join Almacen on Inventario.idAlmacen = Almacen.idAlmacen
			join Folio on Folio.idFolio = Venta.idFolio
			join Persona on Folio.idPersona = Persona.idPersona
			where Venta.idFolio = $folio
			limit 1";

		    //echo $sql;
		    $query = $connection->query($sql);		    
		    $row = $query->fetch(PDO::FETCH_ASSOC);
	    	$cliente = $row["idPersona"];

	    } 	catch(PDOException $error) {
	      	echo $sql . "<br>" . $error->getMessage();

	    }
    try {
	    
	    $sqlcliente = "SELECT nombre, apellido from Persona where idPersona = $cliente;";
	    $querycliente = $connection->query($sqlcliente);  		      
	    $rowcliente = $querycliente->fetch(PDO::FETCH_ASSOC);
	    

	    } 	catch(PDOException $error) {
	      	echo $sqlcliente . "<br>" . $error->getMessage();

	    } 
	//$sql2 = "SELECT * from Trabajo where idTrabajo = $folio;";
	//$result2 = mysqli_query($con, $sql2);
	//$row2 = $result2->fetch_assoc();
	//$costo = $row2["precio"];
	//$cliente = 	$row2["idCliente"];
	//$comentario = $row2["comentario"];
	    	
?>
<div id="printableArea" style="width: 4in; margin: 0; text-align: center;">
	  <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 60%;">
      <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 38%;">
      <h2 style="padding:0; margin: 0;text-transform: uppercase;">Joyeria Claros</h2>
      <h4 style="padding:0; margin: 0;text-transform: uppercase;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;text-transform: uppercase;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p><br><br>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;"> Fecha: <?php echo $fecha; ?> &nbsp;&nbsp;&nbsp;&nbsp;Hora: <?php echo $hora; ?> </p>

      <p style="padding:0; margin: 0;text-align: left;">Proceso: Apartado</p>
      <p style="padding:0; margin: 0;text-align: left;">Folio: <?php echo $folio; ?></p>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;">Cliente: <?php echo $rowcliente["nombre"]." ".$rowcliente["apellido"]; ?></p>
     <table style="width: 100%;">
      	<thead >

	      	<tr style="border-top: 1px dashed;">
	      		<td># </td>
	      		<td colspan="3">Nombre</td>
	      		<td>Cantidad</td>
	      	</tr>
	      	<tr style="border-bottom: 1px dashed;">
	      		<td>P.Unit</td>
	      		<td>$DCTO</td>
	      		<td></td>
	      		<td>DCTO</td>
	      		
	      		<td>Importe</td>
	      	</tr>
      </thead>
      <tbody>
		    <?php 
		    	$sqlProductos = "SELECT Venta.descuento, Inventario.tipo, Producto.precio, Producto.nombre, Producto.codigo from Venta 
					join Inventario on Venta.idInventario = Inventario.idInventario
					join Producto on Producto.idProducto = Inventario.idProducto 
					where Venta.idFolio = $folio and Inventario.tipo > 0";							   
		    

			    $query2 = $connection->query($sqlProductos);
			    $Subtotal = 0;
			    $articulos = 0;	
			    $Total = 0;	
			    $descuentopesos=0;	 
			    foreach($query2->fetchAll() as $row) 
			    {
			    	
			    	$preciounitario = $row["precio"];
			    	$preciounitarioR = floor($preciounitario*pow(10,2))/pow(10,2);
			    	$cantidad = $row["tipo"];
			    	$descuento = $row["descuento"];
			    	
			    	$preciototal= $preciounitario * $cantidad * (1-$descuento/100);
			    	$preciototalR= floor($preciototal*pow(10,2))/pow(10,2);
			    	$Total = $Total + $preciototalR;
			    	$descuentop= ($preciounitarioR - $preciototalR/$cantidad)*$cantidad;
			    	$descuentopesos= $descuentopesos + $descuentop;
			    	$articulos= $articulos + $cantidad;			 			    	
			    	$Subtotal = $Subtotal + $preciounitarioR*$cantidad;
			    	
			    	//echo "Unitairo= ".$unitario;
			    //echo floor($totalpagado*pow(10,2))/pow(10,2);
				  echo "<tr>
      						<td class ='pr-3'>".$row["codigo"]."</td>
      						<td colspan='3'>".$row["nombre"]."</td>
      						<td>".$cantidad."</td>
      					</tr>
      					<tr>
      						<td>".$preciounitarioR."</td>
      						<td>".$descuento."%</td>
      						<td></td>
      						<td>".$descuentop."</td>
      						<td>".$preciototal."</td>
      					</tr>
      						";
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
      	</tbody>
      </table><br>
      <p>Abonos</p>
      <table style="width: 100%;">
      	<thead>
      		<tr style="border-top: 1px dashed;border-bottom: 1px dashed;">
      			<td>Fecha</td>
      			<td>Cantidad</td>
      			<td>Tipo</td>
      		</tr>
      	</thead>
      	<tbody>
      		<?php 
      			$sql3 = "SELECT Transaccion.monto, Transaccion.fecha, Transaccion.tipoDePago as tipo
				from Venta
				join Transaccion on Transaccion.idTransaccion = Venta.idTransaccion
				where Venta.idFolio = $folio;";
				 $query3 = $connection->query($sql3);
				 $abonado =0;
				 foreach($query3->fetchAll() as $row3) 
			    {
					$abonado = $abonado + $row3['monto'];
					
										
			      	echo '<tr>
		                    <td >'.$row3['fecha'].'</td>  
		                    
		                    <td>'.$row3['monto'].'</td>
		                    <td>'.$row3['tipo'].'</td>
		                 			                                         
		                  </tr>';
		        }
      		 ?>
      		<tr >
      			<td>Total Abonado</td>
      			<?php 
      				$restante = 0;
					echo "<td style='border-top: 1px dashed;'>".$abonado."</td>";
      			 ?>
      			<td></td>
      		</tr>
      		<?php 
      			$sqlRestante = "SELECT Cobranza.idCobranza, Cobranza.monto, Venta.idFolio from Venta 
								join Cobranza on Cobranza.idCobranza =Venta.idCobranza 
								group by Cobranza.idCobranza having Venta.idFolio=437 ";
				$queryRestante = $connection->query($sqlRestante);
				 $abonado =0;
				 foreach($queryRestante->fetchAll() as $rowRestante) 
			    {
					$restante = $restante + $rowRestante['monto'];
				}
      		 ?>
      		<tr style="border-bottom: 1px dashed;">
      			<td>Restante</td>
      			<td><?php echo $restante; ?></td>
      			<td></td>
      		</tr>
      		<?php 
	      		if (isset($_GET['cantidad'])) {
					$cantidad = $_GET['cantidad'];
					echo "<tr>
      						<td>Pago Efectivo</td>
      						<td>".$cantidad."</td>
      					  </tr>
      						";
				} 
				if (isset($_GET['cambio'])) {
					$cambio = $_GET['cambio'];
					echo "<tr>
      						<td>Cambio</td>
      						<td>".$cambio."</td>
      					  </tr>
      						";
				} 
			?>
			<tr style="border-top: 1px dashed;">
      		<td colspan="5">Esta nota sera incluida en la Factura Global</td>
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
    <script type="text/javascript">
		window.onload = function(){
			var divName = "printableArea";
	    	var printContents = document.getElementById(divName).innerHTML;
	    	var originalContents = document.body.innerHTML;
		    document.body.innerHTML = printContents;
	    	window.print();
	    	document.body.innerHTML = originalContents;
	    	//location.href= "Trabajos/index.php?folio=$folio";
	    	window.close();
		}
	</script>
			

    
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

