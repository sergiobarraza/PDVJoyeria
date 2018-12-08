<?php
	include 'Trabajos/conexion.php';
	$cantidadPagada=0;
	$cambio =0;
	$folio=9;
	$cliente = "Nombre del cliente";
	if (isset($_GET['folio'])) {
		$folio = $_GET['folio'];
		
	}
	$pageSecurity = array("admin", "supervisor","venta");
	require "config/security.php";
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
	$sql2 = "SELECT * from trabajo where idTrabajo = $folio;";
	$result2 = mysqli_query($con, $sql2);
	$row2 = $result2->fetch_assoc();
	$costo = $row2["precio"];
	$cliente = 	$row2["idCliente"];
	$comentario = $row2["comentario"];
	try {
	    
	    $sqlcliente = "SELECT nombre, apellido from Persona where idPersona = $cliente;";
	    $querycliente = $connection->query($sqlcliente);  		      
	    $rowcliente = $querycliente->fetch(PDO::FETCH_ASSOC);
	    

	    } 	catch(PDOException $error) {
	      	echo $sqlcliente . "<br>" . $error->getMessage();

	    }    	
?>
<div id="printableArea" style="width: 4in; margin: 0; text-align: center;">
	  <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 60%;">
      <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 38%;">
      <h2 style="padding:0; margin: 0;text-transform: uppercase;">Joyeria Claros</h2>
      <h4 style="padding:0; margin: 0;text-transform: uppercase;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;text-transform: uppercase;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p><br><br>
      <p style="padding:0; margin: 0;text-align: left;font-weight: bold"> Fecha: <?php echo $fecha; ?> &nbsp;&nbsp;&nbsp;&nbsp; Hora: <?php echo $hora; ?> </p>

      <p style="padding:0; margin: 0;text-align: left;">Proceso: Anticipo de Trabajo</p>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;">Folio: <?php echo $folio; ?></p>
      <p style="padding:0; margin: 0;font-weight: bold;text-align: left;">Cliente: <?php echo $rowcliente["nombre"]." ".$rowcliente["apellido"]; ?></p>
      <table style="width: 100%;">
      	<thead >
	      	<tr style="border-top: 1px dashed;border-bottom: 1px dashed;">
	      		<td>Prenda</td>
	      		<td>Proceso</td>	      			            
	            
	      	</tr>
	    </thead>
	    <tbody >
		    <?php 
		    	$sql1 = "SELECT fila.idFolio, prenda.nombre_prenda, proceso.nombre_proceso, prenda_proceso.costo, trabajo.idCliente
						from fila 
						join prenda_proceso on prenda_proceso.id = fila.prenda_proceso
						join prenda on prenda_proceso.prenda = prenda.id_prenda
						join proceso on prenda_proceso.proceso = proceso.id_proceso
						join trabajo on fila.idFolio = trabajo.idTrabajo
						where fila.idFolio = $folio;";
				$result1 = mysqli_query($con, $sql1);
			    $rows1 = $result1->num_rows;
				for ($i=0 ; $i < $rows1 ; $i++)
				{	
					$row1 = $result1->fetch_assoc();					
			      	echo '<tr>
		                    <td >'.$row1['nombre_prenda'].'</td>  
		                    
		                    <td>'.$row1['nombre_proceso'].'</td>

		                 			                                         
		                  </tr>';
		        }
	      		
      		?>
      	</tbody>
      </table><br>
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
      			$sql3 = "SELECT transaccion_trabajo.idTrabajo, transaccion_trabajo.idTransaccion, Transaccion.fecha, Transaccion.monto, Transaccion.tipoDePago
						FROM transaccion_trabajo 
						JOIN Transaccion on transaccion_trabajo.idTransaccion = Transaccion.idTransaccion
						where transaccion_trabajo.idTrabajo = $folio;";
						//echo $sql3;
				$result3 = mysqli_query($con, $sql3);
			    $rows3 = $result3->num_rows;
				for ($i=0 ; $i < $rows3 ; $i++)
				{	
					$row3 = $result3->fetch_assoc();					
			      	echo '<tr>
		                    <td >'.$row3['fecha'].'</td>  
		                    
		                    <td>'.$row3['monto'].'</td>
		                    <td>'.$row3['tipoDePago'].'</td>
		                 			                                         
		                  </tr>';
		        }
      		 ?>
      		<tr >
      			<td>Total Abonado</td>
      			<?php 
      				$sql4 = "SELECT transaccion_trabajo.idTrabajo, SUM(Transaccion.monto) as monto
							FROM transaccion_trabajo 
							JOIN Transaccion on transaccion_trabajo.idTransaccion = Transaccion.idTransaccion
							group by transaccion_trabajo.idTrabajo
							having transaccion_trabajo.idTrabajo = $folio;";
					$result4 = mysqli_query($con, $sql4);
					$row4 = $result4->fetch_assoc();
					$abonado = $row4["monto"];
					echo "<td style='border-top: 1px dashed;'>".$abonado."</td>";
      			 ?>
      			<td></td>
      		</tr>
      		<tr>
      			<td>Costo Total</td>
      			<td><?php echo $costo; ?></td>
      			<td></td>
      		</tr>
      		<tr style="border-bottom: 1px dashed;">
      			<td>Restante</td>
      			<td><?php echo ($costo- $abonado); ?></td>
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
	    	location.href= "Trabajos/index.php?folio=$folio";
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

