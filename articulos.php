<?php
	include("header.php");
	require "config/database.php";
    //require "config/common.php";
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
					    	<label for="desc" class="col-sm-2 col-form-label">Descripcion:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="desc" name="Descripcion" required >			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="depto" class="col-sm-2 col-form-label">Linea:</label>
					    	<div class="col-sm-10">
					      		<select type="text" class="form-control" id="direccion" name="linea" required >	
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
					    	<label for="depto" class="col-sm-2 col-form-label">Depto:</label>
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
					    	<label for="price" class="col-sm-2 col-form-label">Price:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="price" min="1" max="99999" step=".01" name="price" required>			      						      		
					    	</div>
					  	</div>
					  	<div class="form-group row">
					    	<label for="cantidad" class="col-sm-2 col-form-label">Cantidad:</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control input-number" id="cantidad" min="1" max="99999" step=".01" name="cantidad" required value="1" data-oldValue="0">			      						      		
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

  	
    	<div class="row">
    		<div class="col-sm-12 col-md-6">    	
			    <!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nueva Linea <span style="color:green; display: <?php if ($status== 'successlinea') { echo "inline-block";} else {echo "none";}?>"> - Linea nueva agregada</span><span style="color:red; display: <?php if ($status== 'errorlinea') { echo "inline-block";} else {echo "none";}?>"> - Error al agregar</span></div>
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
			        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Depto <span style="color:green; display: <?php if ($status== 'successdepto') { echo "inline-block";} else {echo "none";}?>"> - Departamento nuevo agregado</span><span style="color:red; display: <?php if ($status== 'errosdepto') { echo "inline-block";} else {echo "none";}?>"> - Error al agregar</span></div>
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