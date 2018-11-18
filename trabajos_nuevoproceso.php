<?php
if (isset($_GET['prenda'])) {
		$idprenda = $_GET['prenda'];
	}
include('header.php');
include('Trabajos/conexion.php');
?>
<!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Agregar Nuevo Proceso 
			        </div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="trabajos_nuevoproceso_create.php">
					        		
					        		<div class="form-group row" style="display: none">
								    	
								      		<input type="text" class="form-control" id="prenda" name="prenda"  required value="<?php echo $idprenda;?>">			      						      		
								    	
								  	</div>
								  	<div class="form-group row">
								    	<label for="name" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="name" name="name"  required>			      						      		
								    	</div>
								  	</div>
								  	<div class="form-group row">
								    	<label for="tiempo" class="col-sm-3 col-form-label input-number2" type="text">Tiempo:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="tiempo" name="tiempo"  required>			      						      		
								    	</div>
								  	</div>
								  	<div class="form-group row">
								    	<label for="costo" class="col-sm-3 col-form-label">Costo:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="costo" name="costo"  required>			      						      		
								    	</div>
								  	</div>
								  	
								  	<div class="form-group row">
									  	<div class="col-sm-3"></div>
										<button class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</button>
									</div>
					        	</form>
					        </div>		        		       
					    </div>
			        </div>
			  	</div>
<?php
	include ('footer.php');
?>
