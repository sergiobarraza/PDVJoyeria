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
	if (isset($_GET['cambio'])) {
		$cambio = $_GET['cambio'];
	}
	if (isset($_GET['cantidad_efectivo'])) {
		$cantidadPagada = $_GET['cantidad_efectivo'];
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

      <p style="padding:0; margin: 0;text-align: left;">Proceso: Devolucion</p>
      <p style="padding:0; margin: 0;text-align: left;">Folio: <?php echo $folio; ?></p>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;">Cliente: <?php echo $rowcliente["nombre"]." ".$rowcliente["apellido"]; ?></p>
     <table style="width: 100%;">
      	<thead >

	      	<tr style="border-top: 1px dashed;">	
	      		<td> </td>
	      		<td colspan="3">Articulo(s) Devuelto</td>
	      		<td></td>
	      	</tr>
	      	<tr style="border-bottom: 1px dashed;">
	      		<td># </td>
	      		<td colspan="3">Nombre</td>
	      		
	      	</tr>
      </thead>
      <tbody>
		    <?php 
		    	$sqlProductos = "SELECT Producto.codigo, Producto.nombre 
				from Venta 
				join Inventario on Inventario.idInventario = Venta.idInventario
				
				join Producto on Producto.idProducto = Inventario.idProducto
				where idFolio = 436 and estado = 'Entrada de producto';";							   
		    

			    $query2 = $connection->query($sqlProductos);
			    $articulos=0;			    	 
			    foreach($query2->fetchAll() as $row) 
			    {
			    	$articulos++;
			    	
			    	
				  echo "<tr>
      						<td class ='pr-3'>".$row["codigo"]."</td>
      						<td colspan='3'>".$row["nombre"]."</td>
      						
      					</tr>
      					
      						";
				}

		    
	      		
      		?>
  		<tr style="border-top: 1px dashed;">
      		<td colspan="4"><?php echo $articulos; ?> Art(s)</td>
	      		
      	</tr>
      </tbody>
  </table><br>
  <table style="width: 100%;">
  	<thead>	
  			<tr style="border-top: 1px dashed;">	
	      		<td> </td>
	      		<td colspan="3">Articulo(s) Nuevos</td>
	      		<td></td>
	      	</tr>
	      	<tr style="border-bottom: 1px dashed;">
	      		<td># </td>
	      		<td colspan="3">Nombre</td>
	      		<td></td>
	      	</tr>
  	</thead>
  	<tbody>
      	<?php 
		    	$sqlProductos = "SELECT Producto.codigo, Producto.nombre, Transaccion.monto 
				from Venta 
				join Inventario on Inventario.idInventario = Venta.idInventario
				join Transaccion on Transaccion.idTransaccion = Venta.idTransaccion
				
				join Producto on Producto.idProducto = Inventario.idProducto
				where idFolio = 436 and estado = 'Salida de producto';";							   
		    

			    $query2 = $connection->query($sqlProductos);
			    $articulos=0;
			    $monto = 0;			    	 
			    foreach($query2->fetchAll() as $row) 
			    {
			    	$articulos++;
			    	$monto = $monto + $row["monto"];
			    	
			    	
				  echo "<tr>
      						<td class ='pr-3'>".$row["codigo"]."</td>
      						<td colspan='3'>".$row["nombre"]."</td>
      						<td></td>
      					</tr>
      					
      						";
				}

		    
	      		
      		?>
		<tr style="border-top: 1px dashed;">
      		<td colspan="2"><?php echo $articulos; ?> Art(s)</td>
      		<td colspan="2">Subtotal</td>
      		<td><?php echo floor($monto*pow(10,2))/pow(10,2); ?></td>
      	</tr>
      	<tr>
      		<td colspan="2"></td>
      		<td colspan="2">Dcto: </td>

      		<td><?php  echo floor(0*pow(10,2))/pow(10,2); ?></td>
      	</tr>
      	<tr>
      		<td colspan="2"></td>
      		<td colspan="2">Total: </td>
      		<td><?php $Total = floor($monto*pow(10,2))/pow(10,2); echo $Total; ?></td>
      	</tr>
      	<tr style="border-bottom: 1px dashed;">
      		<td colspan="5">
      			<?php include "numero_letras.php";echo numtowords($Total); ?>
      		</td>
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
      <br><br>
     
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
	    	//window.print();
	    	document.body.innerHTML = originalContents;
	    	//location.href= "Trabajos/index.php?folio=$folio";
	    	//window.close();
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

