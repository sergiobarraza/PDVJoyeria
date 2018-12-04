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

  

?><div class="container">
  <form class="m-5">
    <div class="form-group row" id="divdesde">
              
              <div class="col-sm-1">

              <label for="dedia" class="col-sm-11 col-form-labe pt-1 text-center">Fecha:</label>
            </div>
            <div class="col-sm-2">
                <select type="text" class="form-control" id="dedia" placeholder="" name="dedia">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                  <option>8</option>
                  <option>9</option>
                  <option>10</option>
                  <option>11</option>
                  <option>12</option>
                  <option>13</option>
                  <option>14</option>
                  <option>15</option>
                  <option>16</option>
                  <option>17</option>
                  <option>18</option>
                  <option>19</option>
                  <option>20</option>
                  <option>21</option>
                  <option>22</option>
                  <option>23</option>
                  <option>24</option>
                  <option>25</option>
                  <option>26</option>
                  <option>27</option>
                  <option>28</option>
                  <option id="feb11">29</option>
                  <option id="feb21">30</option>
                  <option id="half1">31</option>                  
                </select>               
            </div>
            <div class="col-sm-4">
                <select type="text" class="form-control" id="mes1" placeholder="" name="demes" onchange="hidedays(1);">
                  <?php 
                  $meses = array(
                0 => "", 
                1 => "Enero", 
                2 => "Febrero", 
                3 => "Marzo", 
                4 => "Abril", 
                5 => "Mayo", 
                6 => "Junio", 
                7 => "Julio", 
                8 => "Agosto", 
                9 => "Septiembre", 
                10 => "Octubre", 
                11 => "Noviembre", 
                12 => "Diciembre", 
                

              );  
                    $month = date('m');
                    for ($i=1; $i <=12 ; $i++) { 
                      
                      echo '<option value="'.$i.'"';
                      if ($month == $i) 
                        echo "selected";
                      echo '>'. $meses[$i].'</option>';
                    }
                    
              ?>
                                                
                </select>               
            </div>
            <div class="col-sm-3">
                <select type="text" class="form-control" id="deano" placeholder="" name="deano">
            <?php 
              $year=date('Y');
              //echo $year;
              
              for ($i=2017; $i <= $year ; $i++) { 
                echo "<option value='".$i."'";
                if ($i == $year) {
                  echo " selected";
                }
                echo ">".$i."</option>";
              }
            
             ?>
              </select>
            </div>
            <div class="col-sm-1">
            <input type="success" class="btn-success btn" value="Buscar" onclick="goday();">
          </div>

          </div>
          
  </form>
</div>
<div id="printableArea" class="text-center" style="width: 4in; ">
      <img src="img/LOGOTIPO JOYERIAS_Mesa de trabajo 2.png" style="display: inline-block; width: 45%;">
      <img src="<?php echo $row0['imagen']; ?>" style="display: inline-block; width: 45%;">
      <h2 style="padding:0; margin: 0;">Joyeria Claros</h2>
      <h4 style="padding:0; margin: 0;"> <?php echo $row0["nombrefiscal"]; ?></h4>
      <h5 style="padding:0; margin: 0;"> <?php echo $row0["address"]; ?> </h5>
      <p style="padding:0; margin: 0;">C.P. <?php echo $row0["codigoPostal"]; ?> RFC: <?php echo $row0["rfc"]; ?></p>
      <p style="padding:0; margin: 0;"> Tel: <?php echo $row0["tel"]; ?></p>
      <p style="padding:0; margin: 0;"> Fecha: <?php echo $fecha; ?> Hora: <?php echo $hora; ?> </p>

      <p style="padding:0; margin: 0;">Proceso: Corte de caja del dia</p>
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

function hidedays(number){
      var mes = document.getElementById("mes"+number).value;
      //alert(mes);
      if (mes == 2) {
        document.getElementById("feb1"+number).style.display = "none";
        document.getElementById("feb2"+number).style.display = "none";
        document.getElementById("half"+number).style.display = "none";
      }else if (mes == 1 || mes == 3 || mes == 5 || mes ==7 || mes ==8 ||mes ==10||mes ==12){
        document.getElementById("feb1"+number).style.display = "block";
        document.getElementById("feb2"+number).style.display = "block";
        document.getElementById("half"+number).style.display = "block";
      }else{
        document.getElementById("feb1"+number).style.display = "block";
        document.getElementById("feb2"+number).style.display = "block";
        document.getElementById("half"+number).style.display = "none";
      }
    }
function goday(){
  var dia =document.getElementById("dedia").value;
  var mes = document.getElementById("mes1").value;
  var ano = document.getElementById("deano").value;
  var fecha = ""+ano+"-"+mes+
  location.href= "cortedecaja.php?fecha=";
}
</script>