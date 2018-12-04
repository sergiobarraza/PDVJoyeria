<?php
$pageSecurity = array("admin");
  	require "config/security.php";
	include("header-reportes.php");
	require "config/database.php";
?>

  <!--Reportes-->
  	<div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Reporte</div>
        <div class="card-body">
        	<form method="Post" action="reportes_select.php">
        		<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">						
				    	<label for="tipo" class="col-sm-11 col-form-labe pt-1 text-center">Tipo:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="tipo" name="tipo" onchange="hidefields();">
			      			<option value="1">Conteo por linea</option>
			      			<option selected value="2">Ventas</option>
			      			<option value="3">Inventario</option>
		      				
			      		</select>			      		
			    	</div>
			  	</div>
        		
        		<div class="form-group row" id="divsuc">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" name="sucursalcheck" id="sucursalcheck" value="Yes">
				    	<label for="from" class="col-sm-11 col-form-labe pt-1 text-center">Sucursal:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="sucursal" name="sucursal" >
			      		<?php
			      			try{
			      				$connection = new PDO($dsn, $username, $password, $options );
			      				$sql = "SELECT idAlmacen, name from Almacen where name <> 'apartado';";
			      				$query = $connection->query($sql);
								
								foreach($query->fetchAll() as $row) {
								echo "<option value='".$row["idAlmacen"]."'>".$row["name"]."</option>";
										}
			      			}catch(PDOException $error) {
								echo $sql . "<br>" . $error->getMessage();
							}
 										
								   

					      		?>	
			      			
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row" id="divlinea">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" name="lineacheck" id="lineacheck" value="Yes">
				    	<label for="linea" class="col-sm-11 col-form-labe pt-1 text-center">Linea:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="linea" name="linea" >
			      		<?php

					      		try {
								      
								      $sql1 = "SELECT * From Linea;";							   
								      $query1 = $connection->query($sql1);
								      foreach($query1->fetchAll() as $row1) {
										  echo "<option value='".$row1["idLinea"]."'>".$row1["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql1 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
			      			
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row" id="divdesde">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">

				    	<label for="dedia" class="col-sm-11 col-form-labe pt-1 text-center">De:</label>
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
			  	</div>
			  	<div class="form-group row" id="divhasta">
        			<div class="col-sm-1"></div>

        			<div class="col-sm-2">
        			<input class="form-check-input col-sm-1 mt-2 " type="checkbox" name="checkhasta" id="checkhasta" value="Yes">						
				    	<label for="adia" class="col-sm-11 col-form-labe pt-1 text-center">A:</label>
			    	</div>
			    	<div class="col-sm-2">
			      		<select type="text" class="form-control" id="adia" placeholder="" name="adia">
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
			      			<option >28</option>
			      			<option id="feb12">29</option>
			      			<option id="feb22">30</option>
			      			<option id="half2">31</option>			      			
			      		</select>			      		
			    	</div>
			    	<div class="col-sm-4">
			      		<select type="text" class="form-control" id="mes2" placeholder="" name="ames" onchange="hidedays(2);">
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
			      		<select type="text" class="form-control" id="aano" value="2018" name="aano" >
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
			  	</div>
			  
			  	


	
				<div class="form-group row">
				  	<div class="col-sm-3"></div>
					<button class="btn btn-secondary col-sm-12 col-md-3 ml-3"> Generar Reporte</button>
				</div>
        	</form>
        </div>
  	</div>
  	
       
<?php
	include "footer-reportes.php";
?>

<script type="text/javascript">
	 window.onload = function(){
         hidedays(1);
         hidedays(2);
         hidefields();
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
    function hidefields(){
    	var tipo =document.getElementById("tipo").value;
    	if (tipo == 1) { //Conteo por linea
    		document.getElementById("divhasta").style.display= "none";
    		document.getElementById("divdesde").style.display= "none";
    		document.getElementById("divlinea").style.display= "none";
    		document.getElementById("divsuc").style.display= "flex";
    	}else if(tipo == 2){ // Venta
    		document.getElementById("divhasta").style.display= "flex";
    		document.getElementById("divdesde").style.display= "flex";
    		document.getElementById("divlinea").style.display= "none";
    		document.getElementById("divsuc").style.display= "flex";
    	}else if(tipo == 3){ //Inventario
    		document.getElementById("divhasta").style.display= "none";
    		document.getElementById("divdesde").style.display= "none";
    		document.getElementById("divlinea").style.display= "flex";
    		document.getElementById("divsuc").style.display= "flex";
    	}
    }
</script>