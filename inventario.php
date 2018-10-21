<?php
	$pageSecurity = array("admin");
  require "config/security.php";
	include("header.php");
	//include 'conexion.php';
		require "config/database.php";
    //require "config/common.php";
	$status="nada";
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
?>
	
	<!-- Form-->
	<div class="card mb-3" id="nuevaEntrada">
        <div class="card-header"><i class="fa fa-area-chart"></i> Entrada de productos <span style="color:green; display: <?php if ($status== 'successentrada') { echo "inline-block";} else {echo "none";}?>"> - Entrada correcta</span><span style="color:red; display: <?php if ($status== 'errorentrada') { echo "inline-block";} else {echo "none";}?>"> - No existe producto</span></div>
        <div class="card-body">
        	<form method="Post" action="inventario_entrada.php">
        		<div class="form-group row">
			    	<label for="sku" class="col-sm-2 col-form-label">Código</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku" name="sku"  required="true">			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
				<div class="form-group row">
			    	<label for="almacen" class="col-sm-2 col-form-label">Almacen:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="almacen" name="almacen" required >
			      		<?php

					      		try {
								      $connection = new PDO($dsn, $username, $password, $options );
								      $sql = "SELECT * From Almacen;";							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idAlmacen"]."'>".$row["name"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
			      			
			      		</select>			      		
			    	</div>
			  	</div>			  	<div class="form-group row">
			    	<label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="cantidad" class="form-control input-number" value="1" min="1" max="999" id="cantidad">
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
        <div class="card-header"><i class="fa fa-area-chart"></i> Movimiento entre inventarios <span style="color:green; display: <?php if ($status== 'successmovimiento') { echo "inline-block";} else {echo "none";}?>"> - Movimiento correcto</span><span style="color:red; display: <?php if ($status== 'errorSKU') { echo "inline-block";} else {echo "none";}?>"> - Producto no válido</span><span style="color:red; display: <?php if ($status== 'errorAlm') { echo "inline-block";} else {echo "none";}?>"> - No se puede mover entre mismo almacen</span></div>
        <div class="card-body">
        	<form method="Post" action="inventario_movimiento.php">
        		<div class="form-group row">
			    	<label for="from" class="col-sm-2 col-form-label">De:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="from" name="from" required >
			      		<?php

					      		try {
								    							   
								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idAlmacen"]."'>".$row["name"]."</option>";
										}
								      

								    } catch(PDOException $error) {
								      echo $sql . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
			      			
			      		</select>			      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="destino" class="col-sm-2 col-form-label">A:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="destino" name="destino"  required 
			      		>
			      		<?php

								      $query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idAlmacen"]."'>".$row["name"]."</option>";
										}
								      
								   

					      		?>	
			      			
			      		</select>			      		
			    	</div>
			  	</div>
        		<div class="form-group row">
			    	<label for="sku2" class="col-sm-2 col-form-label">Código</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku2" name="sku"  onchange="buscarporSKU();" required>			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
			  	<!--div class="form-group row">
			    	<label for="desc2" class="col-sm-2 col-form-label">Descripcion</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="desc2" name="desc2" readonly="true">			      		
			    	</div>			    
			  	</div-->	
			  	
			  	<div class="form-group row">
			    	<label for="cantidad1" class="col-sm-2 col-form-label">Cantidad</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="cantidad1" class="form-control input-number" value="1" min="1	" max="999" id="cantidad1" required>
			    	</div>
			  	</div>
				<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<button class="btn btn-primary col-sm-12 col-md-3 ml-3"> Mover</button>
				</div>
        	</form>
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
	

<?php
    try {
		      $connection = new PDO($dsn, $username, $password, $options );
			  $sql = "SELECT idAlmacen, name from Almacen;";
			  $sqlInventario = "SELECT Inventario.idProducto, Producto.codigo, Producto.nombre ";
			  $query = $connection->query($sql);
			  $almacenes = [];
			  $i = 0;
			  foreach($query->fetchAll() as $row) {
			  	  $almacenes[$i] = $row["name"];
			  	  $i++;
				  echo "<th>".$row["name"]."</th>";
				  $sqlInventario = $sqlInventario . ", SUM(if(Folio.idAlmacen= ".$row["idAlmacen"].", Inventario.tipo, 0) ) as '".$row["name"]."'";
				}

	} catch (PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	
	}
	?>						<th>Editar</th>
							<th>Imprimir</th>
						</tr>
					</thead>
					<tbody>
	<?php
	$sqlInventario = $sqlInventario . " from Inventario join Folio on Inventario.idFolio = Folio.idFolio join Producto on Inventario.idProducto = Producto.idProducto GROUP BY Inventario.idProducto;";
	try {

		$query1 = $connection->query($sqlInventario);
		foreach($query1->fetchAll() as $row1) {
			echo "<tr>";
				echo "<td>".$row1["codigo"]."</td>";
				echo "<td>".$row1["nombre"]."</td>";
				for ($j=0; $j <count($almacenes) ; $j++) { 
					echo "<td>".$row1[$almacenes[$j]]."</td>";
				}
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
				    	<label for="from" class="col-sm-11 col-form-labe pt-1 text-center">Sucursal:</label>
			    	</div>
			    	<div class="col-sm-9">
			      		<select type="text" class="form-control" id="from" name="from" >
			      		<?php
 										$query = $connection->query($sql);
								      foreach($query->fetchAll() as $row) {
										  echo "<option value='".$row["idAlmacen"]."'>".$row["name"];
										}
								   

					      		?>	
			      			
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
			      		<?php

					      		try {
								      
								      $sql1 = "SELECT * From Linea;";							   
								      $query1 = $connection->query($sql1);
								      foreach($query1->fetchAll() as $row1) {
										  echo "<option value='".$row1["idLinea"]."'>".$row1["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql1 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
			      			
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
			      		<?php

					      		try {
								      $sql2 = "SELECT * From Departamento;";							   
								      $query2 = $connection->query($sql2);
								      foreach($query2->fetchAll() as $row2) {
										  echo "<option value='".$row2["idDepartamento"]."'>".$row2["nombre"];
										}
								      

								    } catch(PDOException $error) {
								      echo $sql2 . "<br>" . $error->getMessage();

								    }
								   

					      		?>	
			      			
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
		                  	<th>Actualizar</th>
		                </tr>
              		</thead>
              		<tfoot>
		                <tr>
		                  	<th>ID</th>
		                  	<th>Nombre</th>
		                  	<th>Direccion</th>
		                  	<th>RFC</th>
		                  	<th>Tel</th>
		                  	<th>Actualizar</th>
		                </tr>
	              	</tfoot>
            	  	<tbody>
            	  	<?php

					      		try {
								      
								      $sql3 = "SELECT * From Almacen;";							   
								      $query3 = $connection->query($sql3);
								      foreach($query3->fetchAll() as $row3) {
								      	echo "<tr>";
										  echo "<td>".$row3["idAlmacen"]."</td>";
										  echo "<td>".$row3["name"]."</td>";
										  echo "<td>".$row3["address"]."</td>";
										  echo "<td>".$row3["rfc"]."</td>";
										  echo "<td>".$row3["tel"]."</td>";
										  echo "<td><a class='btn btn-primary' href='settings.php?idAlmacen=";
										  echo $row3["idAlmacen"];
										  echo "'>Actualizar</a></td>";
										echo "</tr>";
										}
								      

								    } catch(PDOException $error3) {
								      echo $sql3 . "<br>" . $error3->getMessage();

								    }
								   

					      		?>	
		                
                    </tbody>
            	</table>
          	</div>
        </div>
    </div>	

    <!--Nuevo Alamacen-->
    <div class="card mb-3" id="NuevoAlmacen">
        <div class="card-header"><i class="fa fa-area-chart"></i> Nuevo Almacen <span style="color:green; display: <?php if ($status== 'successalmacen') { echo "inline-block";} else {echo "none";}?>"> - Almacen nuevo agregado</span></div>
        <div class="card-body">
        	<form method="Post" action="inventario_almacen.php">
        		<div class="form-group row">
			    	<label for="alm4" class="col-sm-2 col-form-label">Nombre:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="alm4" name="alm4"  required>			      						      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="direccion" name="direccion" required >			      						      
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="rfc" class="col-sm-2 col-form-label">RFC:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="rfc" name="rfc" required>			      						      		
			    	</div>
			  	</div>
			  	<div class="form-group row">
			    	<label for="tel" class="col-sm-2 col-form-label">Tel:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control input-number" id="tel" name="tel" min="100000000"  max="9999999999" required >			      						      		
			    	</div>
			  	</div>
			  	
			  	<div class="form-group row">
				  	<div class="col-sm-2"></div>
					<button class="btn btn-success col-sm-12 col-md-3 ml-3"> Agregar</button>
				</div>
        	</form>
        </div>
  	</div>
<?php
	include "footer.php";
?>