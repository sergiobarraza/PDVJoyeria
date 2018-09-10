<?php
	include("header.php");
?>
<!--Nuevo Articulo-->
    <div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Articulo</div>
        <div class="card-body">
        	<div class="row">
        		<div class="col-sm-8">
		        	<form>
		        		<div class="form-group row">
					    	<label for="alm4" class="col-sm-2 col-form-label">SKU:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="alm4" placeholder=""  >			      						      		
					    	</div>
					  	</div>
		        		<div class="form-group row">
					    	<label for="desc" class="col-sm-2 col-form-label">Descripcion:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="desc" placeholder=""  >			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Linea:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="direccion" placeholder=""  >		
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
					      		<select type="text" class="form-control" id="direccion" placeholder=""  >		
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
					      		<input type="text" class="form-control input-number" id="price" min="1" max="99999" step=".01" >			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="peso" class="col-sm-2 col-form-label">Peso (gr):</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="peso" min="1" max="99999"  >			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
						  	<div class="col-sm-2"></div>
							<a class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</a>
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
		                  	<th>ID</th>
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
		                  	<th>ID</th>
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
    		<div class="col-sm-6">    	
			    <!--Nuevo Linea-->
			    <div class="card mb-3">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nueva Linea</div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form>
					        		
					        		<div class="form-group row">
								    	<label for="desc" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="desc" placeholder=""  >			      						      		
								    	</div>
								  	</div>
								  	
								  	<div class="form-group row">
									  	<div class="col-sm-3"></div>
										<a class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</a>
									</div>
					        	</form>
					        </div>		        		       
					    </div>
			        </div>
			  	</div>
		  	</div>
		  	<div class="col-sm-12 col-md-6">
			  	<!--Nuevo Depto-->
			    <div class="card mb-3">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Depto</div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form>
					        		
					        		<div class="form-group row">
								    	<label for="desc" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="desc" placeholder=""  >			      						      		
								    	</div>
								  	</div>
								  	
								  	<div class="form-group row">
									  	<div class="col-sm-3"></div>
										<a class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</a>
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