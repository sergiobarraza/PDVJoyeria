<?php
	$pageSecurity = array("admin");
  	require "config/security.php";
	include("header.php");
	include('Trabajos/conexion.php');

	$status="nada";
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
?>


  	
    	<div class="row">
    		<div class="col-sm-12 col-md-12">    	
			    <!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nueva Prenda <span style="color:green; display: <?php if ($status== 'successlinea') { echo "inline-block";} else {echo "none";}?>"> - Linea nueva agregada</span><span style="color:red; display: <?php if ($status== 'errorlinea') { echo "inline-block";} else {echo "none";}?>"> - Error al agregar</span>
			        </div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="trabajos_prenda.php">
					        		
					        		<div class="form-group row">
								    	<label for="lineanew" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="lineanew" name="linea"  required>			      						      		
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
		  	</div>
		  </div>
		  	
  		<div class="row">
	  		<div class="col-sm-12">	
	  			<div class="card mb-3" id="nuevoDepto">
				        <div class="card-header"><i class="fa fa-area-chart"></i> Editar procesos para cada prenda</div>
				        <div class="card-body">
				        	<div class="row">
				        		<div class="col-sm-12">
						        	<form method="Post" action="trabajos_proceso.php">
						        		
						        		<div class="form-group row">
									    	<label for="prendaselect" class="col-sm-3 col-form-label">Prenda:</label>
									    	<div class="col-sm-9">
									      		<select type="text" class="form-control" id="prendaselect" name="depto" required >
									      			<?php
									      				$sql = "SELECT * from prenda;";
									      				$result = mysqli_query($con, $sql);
									      				$rows = $result->num_rows;
									      				for ($i=0 ; $i < $rows ; $i++){
															$row = $result->fetch_assoc();
															echo "<option value='".$row["id_prenda"]."'>".$row["nombre_prenda"]."</option>";
														}
									      			?>
									      			
									      		</select>			      						      		
									    	</div>
									  	</div>
									  	
									  	<div class="form-group row">
										  	<div class="col-sm-3"></div>
											<a class="btn btn-primary col-sm-12 col-md-3 ml-3" onclick="trabajo();"> Seleccionar</a>
										</div>
						        	</form>
						        </div>		        		       
						    </div>
				        </div>
				  	</div>
				</div> 	
		  	</div>
  		</div>	
  		<script type="text/javascript">
  			function trabajo(){
  				var Prenda =  document.getElementById("prendaselect").value;
  				location.href="trabajos_prendaproceso.php?prenda="+Prenda;
  			}
  		</script>
<?php
	include "footer.php";
?>