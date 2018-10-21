<?php
	$pageSecurity = array("admin");
  require "config/security.php";
	include("header.php");
	require "config/database.php";
    //require "config/common.php";
	$sku=0;	
	$status = "Nada";
	if (isset($_GET['sku'])) {
		$sku = $_GET['sku'];
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
        <div class="card-header"><i class="fa fa-area-chart"></i> Editar Articulo <span style="color:green; display: <?php if ($status== 'successarticulo') { echo "inline-block";} else {echo "none";}?>"> - Articulo nuevo agregado</span></div>
        <div class="card-body">
        	<div class="row">
        		<div class="col-sm-12 col-md-6">
		        	<form method="Post" action="articulos_editar_go.php">
		        		<div class="form-group row">
					    	<label for="sku" class="col-sm-2 col-form-label">SKU:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="sku" name="sku" required readonly value = "<?php echo $sku;?>">			  
					    	</div>
					  	</div>
		        		<div class="form-group row">
					    	<label for="desc" class="col-sm-2 col-form-label">Desc:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="desc" name="Descripcion" required value = "<?php echo $row['nombre'];?>">			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Linea:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="direccion" name="linea" required >	
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
					    	<label for="price" class="col-sm-2 col-form-label">Price:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="price" min="1" max="99999" step=".01" name="price" required value="<?php echo $row["precio"];?>">			      						      		
					    	</div>
					  	</div>				  	
			
					  	<div class="form-group row">
						  	<div class="col-sm-2"></div>
							<button class="btn btn-success col-sm-12 col-md-4 ml-3"> Aceptar</button>
						</div>
		        	</form>
		        </div>
		        <div class="col-sm-12 col-md-6">
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
					    	<label for="cantidad" class="col-sm-2 col-form-label">Cant:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="cantidad" min="1" max="99999" step=".01" name="cantidad" required value="1">			      						      		
					    	</div>
					  	</div>
					  	
		        </div>
		    </div>
        </div>
  	</div>
  		
<?php
	include "footer.php";
?>