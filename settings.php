<?php
	include("header.php");
	$status="nada";
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
?>
<!-- Form-->
	<div class="card mb-3" id="settings">
        <div class="card-header"><i class="fa fa-area-chart"></i> Configuración de Almacen <span style="color:green; display: <?php if ($status== 'successentrada') { echo "inline-block";} else {echo "none";}?>"> - Entrada correcta</span><span style="color:red; display: <?php if ($status== 'errorentrada') { echo "inline-block";} else {echo "none";}?>"> - No existe producto</span></div>
        <div class="card-body">
        	<form method="Post" action="settings_update.php">
        		<div class="form-group row">
			    	<label for="idAlmacen" class="col-sm-2 col-form-label">idAlmacen</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="idAlmacen" name="idAlmacen"  required="true" readonly>			      		
			    	</div>
			  	</div>
				<div class="form-group row">
			    	<label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="Nombre" name="Nombre" >			      		
			    	</div>			    
			  	</div>			
			  	<div class="form-group row">
			    	<label for="Direccion" class="col-sm-2 col-form-label">Direccion</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="Direccion" class="form-control"  id="Direccion">
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="RFC" class="col-sm-2 col-form-label">RFC</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="RFC" class="form-control"   id="RFC">
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="Tel" class="col-sm-2 col-form-label">Tel</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="Tel" class="form-control"   id="Tel">
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="IVA" class="col-sm-2 col-form-label">IVA</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="IVA" class="form-control"   id="IVA">
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="percent" class="col-sm-2 col-form-label">Precio (%)</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="percent" class="form-control"  value="100" id="percent">
			    	</div>
			  	</div>
			  	
				<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<button class="btn btn-primary col-sm-12 col-md-3 ml-3"> Actualizar</button>
				</div>
        	</form>
        </div>
  	</div>
<?php  
	include "footer.php";
?>