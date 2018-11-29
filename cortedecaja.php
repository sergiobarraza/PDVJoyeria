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
      <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 45%;">
      <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 45%;">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <h4 style="padding:0; margin: 0;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p>
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $fecha; ?> Hora: <?php echo $hora; ?> </p>

      <p style="padding:0; margin: 0;">Proceso: Corte de caja</p>
      <?php 
      	$sql1 = "SELECT * from Transaccion where fecha = '$fecha' and idAlmacen = $almacen order by tipoDePago asc;";
        //echo $sql1;
        $query1 = $connection->query($sql1);
      ?>
      <table style="width: 100%;">
      	<thead >
	      	<tr style="border-top: 1px dashed;border-bottom: 1px dashed;">
	      		<td># </td>
	      		<td colspan="2">Concepto</td>
	      		
            <td>Tipo</td>
            <td>$$</td>
	      	</tr>
	      	
      </thead>
      <tbody style="border-bottom: 1px dashed;">
        <?php 
          foreach($query1->fetchAll() as $row1) {
            $formatted_number = number_format((float)$row1["monto"], 2, '.', '');
            echo '<tr>
                    <td >'.$row1['idTransaccion'].'</td>  
                    <td colspan="2">'.$row1['concepto'].'</td>
                    <td>'.$row1['tipoDePago'].'</td>
                    <td>'.$formatted_number.'</td>
                                         
                  </tr>';
          }
        ?>      	      	
      </tbody >
      <tfoot >
      	<tr>
      	<?php 
          $sql2= "SELECT sum(monto) as monto from Transaccion where fecha = '$fecha' and idAlmacen = $almacen and tipoDePago ='efectivo';";
          $query2 = $connection->query($sql2);
          $row2 = $query2->fetch(PDO::FETCH_ASSOC);
          $formatted_number = number_format((float)$row2["monto"], 2, '.', '');
         ?>	
      		<td colspan="3"></td>
      		<td>Total Efectivo:</td>
      		<td> <?php echo $formatted_number ?> </td>

      	</tr>
        <tr>
          <?php 
            $sql3= "SELECT sum(monto) as monto from Transaccion where fecha = '$fecha' and idAlmacen = $almacen and tipoDePago ='tarjeta';";
            $query3 = $connection->query($sql3);
            $row3 = $query3->fetch(PDO::FETCH_ASSOC);
            $formatted_number = number_format((float)$row3["monto"], 2, '.', '');
           ?> 
          <td colspan="3"></td>
          <td>Total Tarjeta:</td>
          <td style="border-bottom: 1px dashed;"> <?php echo $formatted_number ?> </td>

        </tr>
        <tr style="border-bottom: 1px dashed;height: 20px;">
        <?php 
          $sql4= "SELECT sum(monto) as monto from Transaccion where fecha = '$fecha' and idAlmacen = $almacen;";
          $query4 = $connection->query($sql4);
          $row4 = $query4->fetch(PDO::FETCH_ASSOC);
          $formatted_number = number_format((float)$row4["monto"], 2, '.', '');
         ?> 
          <td colspan="3"></td>
          <td>Total:</td>
          <td> <?php echo $formatted_number ?> </td>

        </tr>
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
      </tfoot>
      </table>
</div>
<style>
@page { size: auto;  margin: 0mm; }
</style>

<input type="button" class="btn btn-success" onclick="printDiv('printableArea')" value="Corte de Caja" style="margin-top: 50px;" />
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