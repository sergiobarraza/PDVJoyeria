<?php
	include("header.php");
	//include 'conexion.php';

	$status="nada";
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
?>
	
	<!-- Form-->
	<div class="card mb-3" id="nuevaEntrada">
        <div class="card-header"><i class="fa fa-area-chart"></i> Entrada de productos <span style="color:green; display: <?php if ($status== 'successentrada') { echo "inline-block";} else {echo "none";}?>"> - Entrada correcta</span></div>
        <div class="card-body">
        	<form method="Post" action="inventario_entrada.php">
        		<div class="form-group row">
			    	<label for="sku" class="col-sm-2 col-form-label">SKU</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku" name="sku"  onchange="buscarporSKU();" required="true">			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
				<div class="form-group row">
			    	<label for="desc" class="col-sm-2 col-form-label">Descripcion</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="desc" name="desc" readonly="true">			      		
			    	</div>			    
			  	</div>			
			  	<div class="form-group row">
			    	<label for="quant[1]" class="col-sm-2 col-form-label">Cantidad</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="999" id="quant[1]" name="quant[1]">
			    	</div>
			  	</div>
			  	<div class="form-group row">
				  	<div class="col-sm-3"></div>
					<div class="form-check col-sm-5">	
		 		 		<input class="form-check-input" type="checkbox" value="Yes" id="defaultCheck1" name="imprimir">
		  				<label class="form-check-label" for="defaultCheck1">Imprimir etiquetas</label>
					</div>
				</div>
				<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<button class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</button>
				</div>
        	</form>
        </div>
  	</div>
  	<div class="card mb-3" id="nuevoMovimiento">
        <div class="card-header"><i class="fa fa-area-chart"></i> Movimiento entre inventarios <span style="color:green; display: <?php if ($status== 'successmovimiento') { echo "inline-block";} else {echo "none";}?>"> - Entrada correcta</span><span style="color:red; display: <?php if ($status== 'errorSKU') { echo "inline-block";} else {echo "none";}?>"> - Producto no válido</span><span style="color:red; display: <?php if ($status== 'errorAlm') { echo "inline-block";} else {echo "none";}?>"> - No se puede mover entre mismo almacen</span></div>
        <div class="card-body">
        	<form method="Post" action="inventario_movimiento.php">
        		<div class="form-group row">
			    	<label for="from" class="col-sm-2 col-form-label">De:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="from" name="from" required >
			      		<?php 
			      			$sql = "SELECT * form Almacen;";
			      			//$result = mysqli_query($con, $sql);
			      			//$rows = $result->num_rows;
			      			/*
		    	      		for ($i=0 ; $i < $rows ; $i++){
		        	  			$row = $result->fetch_assoc();
		          				echo '<option value='.$row["idAlmacen"].'>'.$row["nombreAlmacen"].'</option>';
				          		}*/
			      		?>
			      			<option value="1">Almacen</option>
			      			<option value="2">Blanc</option>
			      			<option value="3">Juarez</option>
			      			<option value="4">Falcon</option>
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="destino" class="col-sm-2 col-form-label">A:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="destino" name="destino"  required 
			      		>
			      		<?php 
			      			$sql = "SELECT * form Almacen;";			      			
			      			/*
		    	      		for ($i=0 ; $i < $rows ; $i++){
		        	  			$row = $result->fetch_assoc();
		          				echo '<option value='.$row["idAlmacen"].'>'.$row["nombreAlmacen"].'</option>';
				          		}*/
			      		?>
			      			<option value="1">Almacen</option>
			      			<option value="2">Blanc</option>
			      			<option value="3">Juarez</option>
			      			<option value="4">Falcon</option>
			      		</select>			      		
			    	</div>
			  	</div>
        		<div class="form-group row">
			    	<label for="sku2" class="col-sm-2 col-form-label">SKU</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku2" name="sku"  onchange="buscarporSKU();" required>			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="desc2" class="col-sm-2 col-form-label">Descripcion</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="desc2" name="desc2" readonly="true">			      		
			    	</div>			    
			  	</div>	
			  	
			  	<div class="form-group row">
			    	<label for="quant[2]" class="col-sm-2 col-form-label">Cantidad</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="quant[2]" class="form-control input-number" value="1" min="1	" max="999" id="quant[2]" required>
			    	</div>
			  	</div>
				<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<button class="btn btn-primary col-sm-12 col-md-3 ml-3"> Mover</button>
				</div>
        	</form>
        </div>
  	</div>
  	<!--Reportes-->
  	<div class="card mb-3">
        <div class="card-header"><i class="fa fa-area-chart"></i> Reporte</div>
        <div class="card-body">
        	<form method="Post" action="inventario_reporte.php">
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
			      			<option>Entradas</option>
			      			<option selected>Ventas</option>
			      			<option>Apartados</option>
		      				<option>Movimientos</option>
		      				<option>Inventario</option>
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
        			<div class="col-sm-1"></div>
        			<div class="col-sm-2">						
				    	<label for="tipo" class="col-sm-11 col-form-labe pt-1 text-center">Salida:</label>
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