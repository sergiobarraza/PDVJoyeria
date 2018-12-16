<?php
	$pageSecurity = array("admin");
  require "config/security.php";
	include("header.php");
	//include 'conexion.php';
		require "config/database.php";
    //require "config/common.php";
	$status="nada";
	$codigo = "";
	$cantidad = 0;
	$entrada= 0;
	$salida=0;
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
	if (isset($_GET['articulo'])) {
		$codigo = $_GET['articulo'];
	}
	if (isset($_GET['cantidad'])) {
		$cantidad = $_GET['cantidad'];
	}
	if (isset($_GET['entrada'])) {
		$entrada = $_GET['entrada'];

	}
	if (isset($_GET['salida'])) {
		$salida = $_GET['salida'];
	}
	if ($status == 'successentrada') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Nuevo Prodocuto Ingresado!</strong> Código de producto = '.$codigo.' / Cantidad = '.$cantidad.' articulos 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}elseif($status == 'errorentrada') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error! Codigo no existente - </strong> Código de producto = '.$codigo.' 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}
?>
	
	<!-- Form-->
	<div class="card mb-3" id="nuevaEntrada">
        <div class="card-header"><i class="fa fa-area-chart"></i> Entrada de productos <a class="btn btn-primary float-right p-1" onclick="ticketentradas();">Ticket Entradas</a></div>
        <div class="card-body">
        	<form method="Post" action="inventario_entrada.php">
        		
				<div class="form-group row">
			    	<label for="almacenEntrada" class="col-sm-2 col-form-label">Almacen:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="almacenEntrada" name="almacenEntrada" required >
			      		<?php

					      		try {
								      $connection = new PDO($dsn, $username, $password, $options );
								      $sql = "SELECT * From Almacen where name <> 'apartado';";							   
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
			    	<label for="sku" class="col-sm-2 col-form-label">Código</label>
			    	<div class="col-sm-9">
			      		<input type="text" class="form-control" id="sku" name="sku"  required="true">			      		
			    	</div>
			    	<div class="col-sm-1"><i class="fa fa-search pt-2"></i></div>
			  	</div>
			  	<div class="form-group row">
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
  	<?php 
  	if ($status == 'successmovimiento') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Traspaso Correcto!</strong> Código de producto = '.$codigo.' / Cantidad = '.$cantidad.' articulos';
			if($entrada > 0 and $salida >0){
				$sqlout= "SELECT name from Almacen where idAlmacen = $salida;";
				$queryout = $connection->query($sqlout);
				$rowout = $queryout->fetch(PDO::FETCH_ASSOC);
		     	echo '/ De '. $rowout["name"];

				$sqlin= "SELECT name from Almacen where idAlmacen = $entrada;";
				$queryin = $connection->query($sqlin);
				$rowin = $queryin->fetch(PDO::FETCH_ASSOC);
		     	echo ' Hacia '. $rowin["name"];

		     	
			}		 
		echo 		'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}elseif($status == 'errorAlm') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error! No se puede mover entre mismos almacenes  </strong>  
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}elseif($status == 'errorSKU') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error! Producto no valido  </strong>  
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}elseif($status == 'errorcantidad') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error! No hay suficientes productos para realizar este movimiento  </strong>  
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}
	 ?>
  	<div class="card mb-3" id="nuevoMovimiento">
        <div class="card-header"><i class="fa fa-area-chart"></i> Movimiento entre inventarios</div>
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
  	<?php 
  		if ($status == 'successesalida') {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>¡Salida de Producto Correcta!</strong> Código de producto = '.$codigo.' / Cantidad = '.$cantidad.' articulos 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}elseif($status == 'errorsalidasku') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error! Codigo no existente - </strong> Código de producto = '.$codigo.' 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}elseif($status == 'errorsalidacantidad') {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>¡Error! El producto no tiene suficientes unidades - </strong> Código de producto = '.$codigo.' 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			</div>';
	}
  	 ?>
  	<div class="card mb-3" id="nuevaSalida">
        <div class="card-header"><i class="fa fa-area-chart"></i> Salida inventarios</div>
        <div class="card-body">
        	<form method="Post" action="inventario_salida.php">
        		<div class="form-group row">
			    	<label for="from" class="col-sm-2 col-form-label">De:</label>
			    	<div class="col-sm-10">
			      		<select type="text" class="form-control" id="sucursal" name="sucursal" required >
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
			    	<label for="sku3" class="col-sm-2 col-form-label">Código</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="sku3" name="sku"  onchange="buscarporSKU();" required>			      		
			    	</div>
			    	
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
					<button class="btn btn-primary col-sm-12 col-md-3 ml-3"> Salida</button>
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
		     
			  $sql = "SELECT idAlmacen, name from Almacen where name <> 'apartado';";
			  $sqlInventario = "SELECT Inventario.idProducto, Producto.codigo, Producto.nombre ";
			  $query = $connection->query($sql);
			  $almacenes = [];
			  $i = 0;
			  foreach($query->fetchAll() as $row) {
			  	  $almacenes[$i] = $row["name"];
			  	  $i++;
				  echo "<th>".$row["name"]."</th>";
				  $sqlInventario = $sqlInventario . ", SUM(if(Inventario.idAlmacen= ".$row["idAlmacen"].", Inventario.tipo, 0) ) as '".$row["name"]."'";
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
	$sqlInventario = $sqlInventario . " from Inventario join Producto on Inventario.idProducto = Producto.idProducto GROUP BY Inventario.idProducto;";
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
								      
								      $sql3 = "SELECT * From Almacen where name <> 'apartado';";							   
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
			    	<label for="razon" class="col-sm-2 col-form-label">Razon Social:</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="razon" name="razon" required>			      						      		
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
<script type="text/javascript">
	function ticketentradas(){
		var almacen = document.getElementById("almacenEntrada").value;

		window.open("imprimirticket_entrada.php?folio="+almacen, "_blank");
	}
</script>