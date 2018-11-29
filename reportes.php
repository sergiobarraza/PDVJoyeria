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
			      		<select type="text" class="form-control" id="tipo" placeholder="" >
			      			<option>Entradas</option>
			      			<option selected>Ventas</option>
			      			<option>Apartados</option>
		      				<option>Movimientos</option>
		      				<option>Inventario</option>
			      		</select>			      		
			    	</div>
			  	</div>
        		<div class="row">
        			<div class="col-sm-1"></div>
        			<span class="col-sm-10 mb-4">Filtros:</span>
        		</div>
        		<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" value="" id="defaultCheck1">
				    	<label for="from" class="col-sm-11 col-form-labe pt-1 text-center">Sucursal:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="from" name="from" >
			      		<?php
			      			try{
			      				$connection = new PDO($dsn, $username, $password, $options );
			      				$sql = "SELECT idAlmacen, name from Almacen;";
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
			  	<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" value="" id="defaultCheck1">
				    	<label for="linea" class="col-sm-11 col-form-labe pt-1 text-center">Linea:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="linea" placeholder="" >
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
			  	<div class="form-group row">
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
			      			<option>29</option>
			      			<option>30</option>
			      			<option>31</option>			      			
			      		</select>			      		
			    	</div>
			    	<div class="col-sm-4">
			      		<select type="text" class="form-control" id="demes" placeholder="" name="demes">
			      			<option value="1" >Enero</option>
			      			<option value="2" >Febrero</option>
			      			<option value="3" >Marzo</option>
			      			<option value="4" >Abril</option>
			      			<option value="5" >Mayo</option>
			      			<option value="6" >Junio</option>
			      			<option value="7" >Julio</option>
			      			<option value="8" >Agosto</option>
			      			<option value="9" >Septiembre</option>
			      			<option value="10" >Octubre</option>
			      			<option value="11" >Noviembre</option>
			      			<option value="12" >Dic</option>			      					      			
			      		</select>			      		
			    	</div>
			    	<div class="col-sm-3">
			      		<select type="text" class="form-control" id="deano" placeholder="" name="deano">
			    	<?php 
			    		$year=date('Y');
			    		//echo $year;
			    		for ($i=2017; $i <= $year ; $i++) { 
			    			echo "<option>".$i."</option>";
			    		}
			    	 ?>
			    		</select>
			    	</div>
			  	</div>
			  	<div class="form-group row">
        			<div class="col-sm-1"></div>

        			<div class="col-sm-2">
        			<input class="form-check-input col-sm-1 mt-2 " type="checkbox" value="" id="defaultCheck1">						
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
			      			<option>28</option>
			      			<option>29</option>
			      			<option>30</option>
			      			<option>31</option>			      			
			      		</select>			      		
			    	</div>
			    	<div class="col-sm-4">
			      		<select type="text" class="form-control" id="ames" placeholder="" name="ames">
			      			<option value="1" >Enero</option>
			      			<option value="2" >Febrero</option>
			      			<option value="3" >Marzo</option>
			      			<option value="4" >Abril</option>
			      			<option value="5" >Mayo</option>
			      			<option value="6" >Junio</option>
			      			<option value="7" >Julio</option>
			      			<option value="8" >Agosto</option>
			      			<option value="9" >Septiembre</option>
			      			<option value="10" >Octubre</option>
			      			<option value="11" >Noviembre</option>
			      			<option value="12" >Dic</option>			      					      			
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