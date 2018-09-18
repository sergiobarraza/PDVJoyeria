<?php
	include("header.php");
	$status="nada";
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
?>
<!--Nuevo Articulo-->
    <div class="card mb-3" id="nuevoArticulo">
        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Articulo <span style="color:green; display: <?php if ($status== 'successarticulo') { echo "inline-block";} else {echo "none";}?>"> - Articulo nuevo agregado</span></div>
        <div class="card-body">
        	<div class="row">
        		<div class="col-sm-8">
		        	<form method="Post" action="articulos_nuevo.php">
		        		<div class="form-group row">
					    	<label for="sku" class="col-sm-2 col-form-label">SKU:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="sku" name="sku"  >			      						      		
					    	</div>
					  	</div>
		        		<div class="form-group row">
					    	<label for="desc" class="col-sm-2 col-form-label">Descripcion:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="desc" name="Descripcion" required >			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Linea:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="direccion" name="linea" required >		
					      			<option>Collar</option>
					      			<option>Anillo</option>
					      			<option>Arete</option>
					      			<option>Pulsera</option>
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Depto:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="depto" name="depto" required >		
					      			<option>Hombre</option>
					      			<option>Mujer</option>
					      			<option>Unisex</option>
					      			<option>Niños</option>
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="price" class="col-sm-2 col-form-label">Price:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="price" min="1" max="99999" step=".01" name="price" required>			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="cantidad" class="col-sm-2 col-form-label">Cantidad:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="cantidad" min="1" max="99999" step=".01" name="cantidad" required value="1">			      						      		
					    	</div>
					  	</div>					  	
			
					  	<div class="form-group row">
						  	<div class="col-sm-2"></div>
							<button class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</button>
						</div>
		        	</form>
		        </div>
		        <div class="col-sm-12 col-md-4">
		        	<img src="img/no-image-placeholder.jpg" style="width: 100%;">
		        </div>
		    </div>
        </div>
  	</div>


  	<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Productos y etiquetas</div>	
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>
		                  	<th>SKU</th>
		                  	<th>Descripcion</th>
		                  	<th>Depto</th>
		                  	<th>Linea</th>
		                  	<th>Precio</th>
		                  	<th>Almacen</th>
		                  	<th>Blanco</th>
		                  	<th>Juarez</th>
		                  	<th>Acuña</th>
		                  	<th>Imprimir</th>		                  	
		                </tr>
              		</thead>
              		<tfoot>
		                <tr>
		                  	<th>SKU</th>
		                  	<th>Descripcion</th>
		                  	<th>Depto</th>
		                  	<th>Linea</th>
		                  	<th>Precio</th>
		                  	<th>Almacen</th>
		                  	<th>Blanco</th>
		                  	<th>Juarez</th>
		                  	<th>Acuña</th>
		                  	<th>Imprimir</th>
		                </tr>
	              	</tfoot>
            	  	<tbody>
		                <tr>
		                  	<td>1</td>
		                  	<td>Anillo grande mujer</td>
		                  	<td>Anillo</td>
		                  	<td>Mujer</td>
		                  	<td>157</td>
		                  	<td>1</td>
		                  	<td>2</td>
		                  	<td>0</td>
		                  	<td>0</td>
		                  	<td><a class="btn btn-primary">Imprimir</a></td>
		                </tr>
		                <tr>
		                  	<td>1</td>
		                  	<td>Anillo grande mujer</td>
		                  	<td>Anillo</td>
		                  	<td>Mujer</td>
		                  	<td>157</td>
		                  	<td>1</td>
		                  	<td>2</td>
		                  	<td>0</td>
		                  	<td>0</td>
		                  	<td><a class="btn btn-primary">Imprimir</a></td>
		                </tr>
		                <tr>
		                  	<td>1</td>
		                  	<td>Anillo grande mujer</td>
		                  	<td>Anillo</td>
		                  	<td>Mujer</td>
		                  	<td>157</td>
		                  	<td>1</td>
		                  	<td>2</td>
		                  	<td>0</td>
		                  	<td>0</td>
		                  	<td><a class="btn btn-primary">Imprimir</a></td>
		                </tr>
		                <tr>
		                  	<td>1</td>
		                  	<td>Anillo grande mujer</td>
		                  	<td>Anillo</td>
		                  	<td>Mujer</td>
		                  	<td>157</td>
		                  	<td>1</td>
		                  	<td>2</td>
		                  	<td>0</td>
		                  	<td>0</td>
		                  	<td><a class="btn btn-primary">Imprimir</a></td>
		                </tr>
		                <tr>
		                  	<td>1</td>
		                  	<td>Anillo grande mujer</td>
		                  	<td>Anillo</td>
		                  	<td>Mujer</td>
		                  	<td>157</td>
		                  	<td>1</td>
		                  	<td>2</td>
		                  	<td>0</td>
		                  	<td>0</td>
		                  	<td><a class="btn btn-primary">Imprimir</a></td>
		                </tr>
		                
                    </tbody>
            	</table>
          	</div>
        </div>
    </div>
    	<div class="row">
    		<div class="col-sm-12 col-md-6">    	
			    <!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nueva Linea <span style="color:green; display: <?php if ($status== 'successlinea') { echo "inline-block";} else {echo "none";}?>"> - Linea nueva agregada</span></div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="articulos_linea.php">
					        		
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
		  	<div class="col-sm-12 col-md-6">
			  	<!--Nuevo Depto-->
			    <div class="card mb-3" id="nuevoDepto">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Depto <span style="color:green; display: <?php if ($status== 'successdepto') { echo "inline-block";} else {echo "none";}?>"> - Departamento nuevo agregado</span></div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="articulos_depto.php">
					        		
					        		<div class="form-group row">
								    	<label for="deptonew" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="deptonew" name="depto" required >			      						      		
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
<?php
	include "footer.php";
?>