<?php
	$pageSecurity = array("admin");
  	require "config/security.php";
	include("header.php");
	require "config/database.php";
    //require "config/common.php";
	$status="nada";
	$codigo = "";
	$cantidad = 0;
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
	if (isset($_GET['articulo'])) {
		$codigo = $_GET['articulo'];
	}
	if (isset($_GET['cantidad'])) {
		$cantidad = $_GET['cantidad'];
	}
	if ($status == 'successarticulo') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Nuevo Producto Creado!</strong> Código de producto = '.$codigo.' / Cantidad = '.$cantidad.' articulos 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}
?>

<!--Nuevo Articulo-->
    <div class="card mb-3" id="nuevoArticulo">
    		
        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Articulo</div>
        <div class="card-body">
        	<div class="row">
        		<div class="col-sm-12">
		        	<form method="Post" action="articulos_nuevo.php">
		        		
		        		<div class="form-group row">
					    	<label for="desc" class="col-sm-2 col-form-label">Descripcion:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="desc" name="Descripcion" required >			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="linea" class="col-sm-2 col-form-label">Linea:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="linea" name="linea" required >	
					      		<?php

					      		try {
								      $connection = new PDO($dsn, $username, $password, $options );
								      $sql = "SELECT * From Linea;";							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idLinea"]."'>".$row["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
					      		
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Departamento:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="depto" name="depto" required >	
					      		<?php

					      		try {
								      $sql = "SELECT * From Departamento;";							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idDepartamento"]."'>".$row["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>		
					      			
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="subdepto" class="col-sm-2 col-form-label">Subdepartamento:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="subdepto" name="subdepto" required >	
					      		<?php

					      		try {
								      $sql = "SELECT * From Subdepartamento;";							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idSubdepartamento"]."'>".$row["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

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
								      $sql = "SELECT * From Proveedor;";							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idProveedor"]."'>".$row["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>		
					      			
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Tipoprod" class="col-sm-2 col-form-label">Tipo:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="Tipoprod" name="Tipoprod" required >	
					      		<?php

					      		try {
								      $sql = "SELECT * From Tipoprod;";							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idTipoprod"]."'>".$row["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>		
					      			
					      		</select>	      						      
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="price" class="col-sm-2 col-form-label">Precio:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="price" min="1" max="99999" step=".01" name="price" required>			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Min" class="col-sm-2 col-form-label">Precio Min:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="Min" min="1" max="99999" step=".01" name="Min" required>			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="Costo" class="col-sm-2 col-form-label">Costo:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="Costo" min="1" max="99999" step=".01" name="Costo" required>			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="cantidad" class="col-sm-2 col-form-label">Cantidad:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="cantidad" min="1" max="99999" step=".01" name="cantidad" required value="1" data-oldValue="0">			      						      		
					    	</div>
					  	</div>					  	
						<div class="form-group row">
			    	<label for="almacen" class="col-sm-2 col-form-label">Almacen:</label>
			    	<div class="col-sm-10">
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
					  	<div class="form-group row">
						  	<div class="col-sm-2"></div>
							<button class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</button>
						</div>
		        	</form>
		        </div>

		        <!--div class="col-sm-12 col-md-4">
		        	
		        </div-->
		    </div>
        </div>
  	</div>
<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Productos y etiquetas</div>	
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>	
							<th>Código</th>
							<th>name</th>
							<th>Linea</th>
							<th>Departamento</th>
							<th>Precio</th>	
							<th>Editar</th>
							<th>Imprimir</th>
						</tr>
					</thead>
					<tbody>
	<?php
	$sql1 = "SELECT Producto.idProducto, Producto.codigo, Producto.nombre as pname, Producto.precio, Linea.nombre as lname, Departamento.nombre as dname from Producto join Linea on Producto.idLinea = Linea.idLinea join Departamento on Producto.idDepartamento = Departamento.idDepartamento;";
	try {

		$query1 = $connection->query($sql1);
		foreach($query1->fetchAll() as $row1) {
			echo "<tr>";
				echo "<td>".$row1["codigo"]."</td>";
				echo "<td>".$row1["pname"]."</td>";
				echo "<td>".$row1["lname"]."</td>";
				echo "<td>".$row1["dname"]."</td>";
				echo "<td>".$row1["precio"]."</td>";
				
			echo "<td><a class='btn btn-primary' href='articulos_editar.php?sku=".$row1["idProducto"]."'>Editar</a></td>";
			echo "<td><a class='btn btn-secondary'>Imprimir</a></td>";
			echo "</tr>";
			  	  
				}
	} catch (PDOException $error1) {
		echo $sqlInventario . "<br>" . $error1->getMessage();
	}
	
?>
					</tbody>		
				</table>
			</div>
		</div>
	</div>

  	<?php 
if ($status == 'successlinea') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Nueva Linea Creada!</strong> Linea: '.$codigo.' 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}elseif ($status == 'successdepto') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Nuevo Departamento Creado!</strong> Departamento: '.$codigo.'
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}elseif ($status == 'successsubdepto') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Nuevo Subepartamento Creado!</strong> Subdepartamento: '.$codigo.'
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}elseif ($status == 'errorlinea') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error!</strong> 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}elseif ($status == 'errordepto') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error!</strong> 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}elseif ($status == 'errorsubdepto') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error!</strong> 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}
  	 ?>
  	 <!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nueva Linea </div>
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
    	<div class="row">
    		
		  	<div class="col-sm-12 col-md-6">
			  	<!--Nuevo Depto-->
			    <div class="card mb-3" id="nuevoDepto">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Depto </div>
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
		  	<div class="col-sm-12 col-md-6">    	
			    <!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Subdepartamento </div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="articulos_subdepartamento.php">
					        		
					        		<div class="form-group row">
								    	<label for="nombresub" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="nombresub" name="nombresub"  required>			      						      		
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
<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Provedores</div>	
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>	
							<th>#</th>
							<th>Nombre</th>

						</tr>
					</thead>
					<tbody>
						<?php
						$sql3 = "SELECT * from Proveedor ;";
						try {

							$query3 = $connection->query($sql3);
							foreach($query3->fetchAll() as $row3) {
								echo "<tr>";
									echo "<td>".$row3["idProveedor"]."</td>";
									echo "<td>".$row3["nombre"]."</td>";
								echo "</tr>";
								  	  
									}
						} catch (PDOException $error3) {
							echo $sql3 . "<br>" . $error3->getMessage();
						}
						
					?>
					</tbody>		
				</table>
			</div>
		</div>
	</div>
  		<?php 
  		if ($status == 'successproveedor') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id= "nuevoproveedor">
					<strong>¡Nuevo Proveedor Creado!</strong> Proveedor: '.$codigo.' 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
		}elseif ($status == 'successtipo') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id= "nuevotipo">
							<strong>¡Nuevo Departamento Creado!</strong> Departamento: '.$codigo.'
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
					</div>';
		}elseif ($status == 'errortipo') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error!</strong> 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
		}elseif ($status == 'errorproveedor') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error!</strong> 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
}
 ?>
  		<div class="row">
    		
		  	<div class="col-sm-12 col-md-6">
			  	<!--Nuevo Depto-->
			    <div class="card mb-3" id="nuevoDepto">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Proveedor </div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="articulos_proveedor.php">
					        		
					        		<div class="form-group row">
								    	<label for="proveedor" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="proveedor" name="proveedor" required >			      						      		
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
			    <!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Tipo de Prodcuto </div>
			        <div class="card-body">
			        	<div class="row">
			        		<div class="col-sm-12">
					        	<form method="Post" action="articulos_tipo.php">
					        		
					        		<div class="form-group row">
								    	<label for="tipo" class="col-sm-3 col-form-label">Nombre:</label>
								    	<div class="col-sm-9">
								      		<input type="text" class="form-control" id="tipo" name="tipo"  required>			      						      		
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