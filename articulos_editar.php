<?php
	$pageSecurity = array("admin");
  require "config/security.php";
	include("header.php");
	require "config/database.php";
    //require "config/common.php";
	$sku=0;	
	$status = "Nada";
	$cantidad = 0;
	if (isset($_GET['sku'])) {
		$sku = $_GET['sku'];
	}else{
		header("Refresh:0; url=articulos.php?status=errorarticulo");
      exit;
	}
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
	if (isset($_GET['articulo'])) {
		$codigo = $_GET['articulo'];
	}
	if (isset($_GET['cantidad'])) {
		$cantidad = $_GET['cantidad'];
	}if ($status == 'successarticulo') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Producto correctamente editado!</strong> Código de producto = '.$codigo;
		if($cantidad > 0)
			echo ' / Cantidad = '.$cantidad.' articulos' ;
		echo ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}


	try {
      $connection = new PDO($dsn, $username, $password, $options );
      $sql = "SELECT * From Producto where idProducto = $sku;";	
      $query = $connection->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
      

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();

    }
								   

					      		?>
<!--Nuevo Articulo-->
    <div class="card mb-3" id="nuevoArticulo">
        <div class="card-header"><i class="fa fa-area-chart"></i> Editar Articulo </div>
        <div class="card-body">
        	<form method="Post" action="articulos_editar_go.php">
	        	<div class="row">
	        		<div class="col-sm-12 col-md-8">
			        	
		        		<div class="form-group row">
					    	<label for="sku" class="col-sm-2 col-form-label">Codigo:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="sku" name="sku" required readonly value = "<?php echo $row['codigo'];?>">
					      		<input type="hidden" name="idProd" value="<?php echo $sku;?>">			  
					    	</div>
					  	</div>
		        		<div class="form-group row">
					    	<label for="desc" class="col-sm-2 col-form-label">Descripcion:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="desc" name="desc" required value = "<?php echo $row['nombre'];?>">			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="linea" class="col-sm-2 col-form-label">Linea:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="linea" name="linea" required >	
					      		<?php

					      		try {
								      $sql1 = "SELECT * From Linea;";							   
								      $query1 = $connection->query($sql1);
								      foreach($query1->fetchAll() as $row1) {
										  echo "<option value='".$row1["idLinea"]."' ";
										  if ($row1["idLinea"] == $row["idLinea"])
										  	{echo "selected";}
										  echo " >".$row1["nombre"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql1 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
					      		
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Depto:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="depto" name="depto" required >	
					      		<?php

					      		try {
								      $sql2 = "SELECT * From Departamento;";							   
								      $query2 = $connection->query($sql2);
								      foreach($query2->fetchAll() as $row2) {
										  echo "<option value='".$row2["idDepartamento"]."' ";
										  if ($row2["idDepartamento"] == $row["idDepartamento"])
										  	{echo "selected";}
										  echo " >".$row2["nombre"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>		
					      			
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Subdepartamento" class="col-sm-2 col-form-label">Subdepto:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="Subdepartamento" name="Subdepartamento" required >	
					      		<?php

					      		try {
								      $sql1 = "SELECT * From Subdepartamento;";							   
								      $query1 = $connection->query($sql1);
								      foreach($query1->fetchAll() as $row1) {
										  echo "<option value='".$row1["idSubdepartamento"]."' ";
										  if ($row1["idSubdepartamento"] == $row["idSubdepartamento"])
										  	{echo "selected";}
										  echo " >".$row1["nombre"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql1 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
					      		
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Proveedor" class="col-sm-2 col-form-label">Proveedor:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="Proveedor" name="Proveedor" required >	
					      		<?php

					      		try {
								      $sql1 = "SELECT * From Proveedor;";							   
								      $query1 = $connection->query($sql1);
								      foreach($query1->fetchAll() as $row1) {
										  echo "<option value='".$row1["idProveedor"]."' ";
										  if ($row1["idProveedor"] == $row["idProveedor"])
										  	{echo "selected ";}
										  echo " >".$row1["nombre"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql1 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
					      		
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Tipo" class="col-sm-2 col-form-label">Tipo:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="Tipo" name="Tipo" required >	
					      		<?php

					      		try {
								      $sql1 = "SELECT * From Tipoprod;";							   
								      $query1 = $connection->query($sql1);
								      foreach($query1->fetchAll() as $row1) {
										  echo "<option value='".$row1["idTipoprod"]."' ";
										  if ($row1["idTipoprod"] == $row["idTipoprod"])
										  	{echo "selected ";}
										  echo " >".$row1["nombre"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql1 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
					      		
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="price" class="col-sm-2 col-form-label">Precio:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="price" min="1" max="99999" step=".01" name="price" required value="<?php echo $row["precio"];?>">			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Min" class="col-sm-2 col-form-label">Precio Min:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="Min" min="1" max="99999" step=".01" name="Min" required value="<?php echo $row["preciomin"];?>">			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="costo" class="col-sm-2 col-form-label">Costo:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="costo" min="1" max="99999" step=".01" name="costo" required value="<?php echo $row["costo"];?>">			      						      		
					    	</div>
					  	</div>						  	
			
					  	<div class="form-group row">
						  	<div class="col-sm-2"></div>
							<button class="btn btn-success col-sm-12 col-md-5 ml-3"> Aceptar</button>
							<a class="btn btn-primary col-sm-12 col-md-4 ml-3 ml-4" onclick="location.reload();"> Default</a>
						</div>
			        	
			        </div>
			        <div class="col-sm-12 col-md-4">
			        <div class="form-group row">
					  	<div class="col-sm-2"></div>
						<div class="form-check col-sm-4">	
			 		 		<input class="form-check-input" type="checkbox" value="Yes" id="agregar" name="agregar">
			  				<label class="form-check-label" for="agregar">Agregar Producto</label>
						</div>
						<div class="col-sm-2"></div>
						<div class="form-check col-sm-4">	
			 		 		<input class="form-check-input" type="checkbox" value="Yes" id="imprimir" name="imprimir">
			  				<label class="form-check-label" for="imprimir">Imprimir etiquetas</label>
						</div>
					</div>
					
		        		<div class="form-group row">
					    	<label for="cantidad" class="col-sm-4 col-form-label">Cantidad:</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control input-number" id="cantidad" min="1" max="99999" step=".01" name="cantidad" required value="1">			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
			    			<label for="almacen" class="col-sm-4 col-form-label">Almacen:</label>
			    			<div class="col-sm-8">
			      				<select type="text" class="form-control" id="almacen" name="almacen" required >
						      		<?php

								      		try {
											      $sql2 = "SELECT * From Almacen where name <> 'apartado';";							   
											      $query2 = $connection->query($sql2);
											      foreach($query2->fetchAll() as $row2) {
													  echo "<option value='".$row2["idAlmacen"]."'>".$row2["name"]."</option>";
													}
											      

											    } catch(PDOException $error) {
											      echo $sql . "<br>" . $error->getMessage();

											    }
											   

						      		?>	
			      			
			      				</select>			      		
			    			</div>
			  			</div>
						  	
			        </div>
			    </div>
			</form>
        </div>
  	</div>
  		
<?php
	include "footer.php";
?>