<?php
$pageSecurity = array("admin");
  	require "config/security.php";
	include("header.php");
	require "config/database.php";
?>
<script src="/js/datetime.js" type="text/javascript"></script>
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
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" value="" id="defaultCheck1">
				    	<label for="linea" class="col-sm-11 col-form-labe pt-1 text-center">De:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<input data-provide="datepicker" class="datepicker">			      		
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
	include "footer.php";
?>