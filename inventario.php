<?php
	include("header.php");
?>
	
	<!-- Form-->
	<div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Entrada de productos</div>
        <div class="card-body">
        	<form>
        		<div class="form-group row">
			    	<label for="sku" class="col-sm-2 col-form-label">SKU</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku" placeholder=""  onchange="buscarporSKU();">			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="Name" class="col-sm-2 col-form-label">Descripción</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="Name" placeholder="" >
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="quant[1]" class="col-sm-2 col-form-label">Cantidad</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="999" id="quant[1]">
			    	</div>
			  	</div>
			  	<div class="form-group row">
				  	<div class="col-sm-3"></div>
					<div class="form-check col-sm-5">	
		 		 		<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
		  				<label class="form-check-label" for="defaultCheck1">Imprimir etiquetas</label>
					</div>
				</div>
				<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<a class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</a>
				</div>
        	</form>
        </div>
  	</div>
  	<div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Movimiento entre inventarios</div>
        <div class="card-body">
        	<form>
        		<div class="form-group row">
			    	<label for="alm1" class="col-sm-2 col-form-label">De:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="alm1" placeholder=""  >
			      			<option>Almacen</option>
			      			<option>Blanc</option>
			      			<option>Juarez</option>
			      			<option>Falcon</option>
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="alm2" class="col-sm-2 col-form-label">A:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="alm2" placeholder=""  >
			      			<option>Almacen</option>
			      			<option>Blanc</option>
			      			<option>Juarez</option>
			      			<option>Falcon</option>
			      		</select>			      		
			    	</div>
			  	</div>
        		<div class="form-group row">
			    	<label for="sku2" class="col-sm-2 col-form-label">SKU</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku2" placeholder=""  onchange="buscarporSKU();">			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="Name2" class="col-sm-2 col-form-label">Descripcion</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="Name2" placeholder="" >
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="quant[2]" class="col-sm-2 col-form-label">Cantidad</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="quant[1]" class="form-control input-number" value="1" min="1	" max="999" id="quant[2]">
			    	</div>
			  	</div>
				<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<a class="btn btn-primary col-sm-12 col-md-3 ml-3"> Mover</a>
				</div>
        	</form>
        </div>
  	</div>
  	<!--Reportes-->
  	<div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Reporte</div>
        <div class="card-body">
        	<form>
        		<div class="row">
        			<span class="col-sm-12">Filtros:</span>
        		</div>
        		<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" value="" id="defaultCheck1">
				    	<label for="alm3" class="col-sm-11 col-form-labe pt-1 text-center">Sucursal:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="alm3" placeholder="" >
			      			<option>Almacen</option>
			      			<option>Blanc</option>
			      			<option>Juarez</option>
			      			<option>Falcon</option>
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
			      			<option>Anillo</option>
			      			<option>Collar</option>
			      			<option>Pulsera</option>
			      			<option>Arracada</option>
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">
						<input class="form-check-input col-sm-1 mt-2 " type="checkbox" value="" id="defaultCheck1">
				    	<label for="depto" class="col-sm-11 col-form-labe pt-1 text-center">Depto:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="depto" placeholder="" >
			      			<option>Mujer</option>
			      			<option>Hombre</option>
			      			<option>Unisex</option>
			      			<option>Niño</option>
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">						
				    	<label for="tipo" class="col-sm-11 col-form-labe pt-1 text-center">Tipo:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="tipo" placeholder="" >
			      			<option>Ticket</option>
			      			<option>PDF</option>
			      			<option>Excel</option>
			      		</select>			      		
			    	</div>
			  	</div>
				<div class="form-group row">
				  	<div class="col-sm-3"></div>
					<a class="btn btn-secondary col-sm-12 col-md-3 ml-3"> Generar Reporte</a>
				</div>
        	</form>
        </div>
  	</div>
  	<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Almacenes</div>
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>
		                  	<th>ID</th>
		                  	<th>Nombre</th>
		                  	<th>Direccion</th>
		                  	<th>RFC</th>
		                  	<th>Tel</th>
		                  	<th>Tipo</th>
		                  	<th>Actualizar</th>
		                  	<th>Eliminar</th>
		                </tr>
              		</thead>
              		<tfoot>
		                <tr>
		                  	<th>ID</th>
		                  	<th>Nombre</th>
		                  	<th>Direccion</th>
		                  	<th>RFC</th>
		                  	<th>Tel</th>
		                  	<th>Tipo</th>
		                  	<th>Actualizar</th>
		                  	<th>Eliminar</th>
		                </tr>
	              	</tfoot>
            	  	<tbody>
		                <tr>
		                  	<td>1</td>
		                  	<td>Blanco</td>
		                  	<td>Calle Blanco 197 col Centro 27000</td>
		                  	<td>ASDF080908</td>
		                  	<td>8711667788</td>
		                  	<td>
		                  		<select name="tipodeinv" id="tipodeinv" class="form-control">
		                  			<option>Almacen</option>
		                  			<option>Venta</option>
		                  		</select>
		                  	</td>
		                  <td><a class="btn btn-primary">Actualizar</a></td>
		                  <td><a class="btn btn-danger">Eliminar</a></td>
		                </tr>
		                <tr>
		                  	<td>2</td>
		                  	<td>Juarez</td>
		                  	<td>Calle Blanco 197 col Centro 27000</td>
		                  	<td>ASDF080908</td>
		                  	<td>8711667788</td>
		                  	<td>
		                  		<select name="tipodeinv" id="tipodeinv" class="form-control">
		                  			<option>Almacen</option>
		                  			<option>Venta</option>
		                  		</select>
		                  	</td>
		                  <td><a class="btn btn-primary">Actualizar</a></td>
		                  <td><a class="btn btn-danger">Eliminar</a></td>
		                </tr>
		                <tr>
		                  	<td>3</td>
		                  	<td>Acu;a</td>
		                  	<td>Calle Blanco 197 col Centro 27000</td>
		                  	<td>ASDF080908</td>
		                  	<td>8711667788</td>
		                  	<td>
		                  		<select name="tipodeinv" id="tipodeinv" class="form-control">
		                  			<option>Almacen</option>
		                  			<option>Venta</option>
		                  		</select>
		                  	</td>
		                  <td><a class="btn btn-primary">Actualizar</a></td>
		                  <td><a class="btn btn-danger">Eliminar</a></td>
		                </tr>
                    </tbody>
            	</table>
          	</div>
        </div>
    </div>	

    <!--Nuevo Alamacen-->
    <div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Almacen</div>
        <div class="card-body">
        	<form>
        		<div class="form-group row">
			    	<label for="alm4" class="col-sm-2 col-form-label">Nombre:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="alm4" placeholder=""  >			      						      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="direccion" placeholder=""  >			      						      
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="rfc" class="col-sm-2 col-form-label">RFC:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="rfc" placeholder=""  >			      						      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="tel" class="col-sm-2 col-form-label">Tel:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="tel" placeholder=""  >			      						      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="alm4" class="col-sm-2 col-form-label">Tipo:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="alm4" placeholder=""  >	
			      			<option>Venta</option>
			      			<option>Almacen</option>
		      			</select>			      						      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<a class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</a>
				</div>
        	</form>
        </div>
  	</div>
<?php
	include "footer.php";
?>