<?php
	$pageSecurity = array("admin");
  	require "config/security.php";
  	require "config/database.php";
	include("header.php");
	$status="nada";
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
	if (isset($_GET['idAlmacen'])) {
		$idAlmacen = $_GET['idAlmacen'];
	}else{
		$idAlmacen = $_SESSION['almacen'];
	}
?>
<!-- Form-->
	<div class="card mb-3" id="settings">
        <div class="card-header"><i class="fa fa-area-chart"></i> Configuración de Ticket de Almacen <span style="color:green; display: <?php if ($status== 'successentrada') { echo "inline-block";} else {echo "none";}?>"> - Entrada correcta</span><span style="color:red; display: <?php if ($status== 'errorentrada') { echo "inline-block";} else {echo "none";}?>"> - No existe producto</span></div>
        <div class="card-body">
        	<form method="Post" action="settings_update.php">
        		<div class="form-group row">
			    	<label for="idAlmacen" class="col-sm-2 col-form-label">idAlmacen</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="idAlmacen" name="idAlmacen"  required="true" readonly value="<?php echo $idAlmacen;?>">			      		
			    	</div>
			  	</div>
			  	<?php 
			  		try {
					      $connection = new PDO($dsn, $username, $password, $options );
					      $sql = "SELECT * from Almacen where idAlmacen = $idAlmacen;";
			  		      $query = $connection->query($sql);
			  		      $row = $query->fetch(PDO::FETCH_ASSOC);
  		     			  

							
					    } catch(PDOException $error) {
					      echo $sql . "<br>" . $error->getMessage();
							header("Location: settings.php?status=error");
			  		     		exit;
				    }
			  	?>
				<div class="form-group row">
			    	<label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo $row["name"];?>" >			      		
			    	</div>			    
			  	</div>			
			  	<div class="form-group row">
			    	<label for="Direccion" class="col-sm-2 col-form-label">Direccion</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="Direccion" class="form-control" id="Direccion" value="<?php echo $row["address"];?>" required>
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="cp" class="col-sm-2 col-form-label">Codigo Postal</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="cp" class="form-control" id="cp" value="<?php echo $row["codigoPostal"];?>" required>
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="razon" class="col-sm-2 col-form-label">Razon Social</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="razon" class="form-control" id="razon" value="<?php echo $row["nombrefiscal"];?>" required>
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="RFC" class="col-sm-2 col-form-label">RFC</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="RFC" class="form-control" id="RFC" value="<?php echo $row["rfc"];?>" required>
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="Tel" class="col-sm-2 col-form-label">Tel</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="Tel" class="form-control" id="Tel" value="<?php echo $row["tel"];?>" required>
			    	</div>
			  	</div>
			  	
			  	<div class="form-group row">
			    	<label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="imagen" class="form-control"  id="imagen" value="<?php echo $row["imagen"];?>" required>
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