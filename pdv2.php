<?php
  if(isset($_POST['submit'])) {
    require "config/database.php";
    require "config/common.php";

    try {
      $connection = new PDO($dsn, $username, $password, $options );

      $new_user = array(
        "nombre" => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "tel" => $_POST['tel'],
        "tipo" => "cliente",
        "rfc" => $_POST['rfc']
      );

      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Persona",
        implode(", ", array_keys($new_user)),
        ":" . implode(", :", array_keys($new_user))
      );

      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>

<?php include("header-pdv.php"); ?>

  <div class="row " id="panelprincipal">
	   	<!-- Articulos -->
	    <div class="col-sm-12 col-md-9 bg-white pt-3" >
	    	<div class="row mb-2" >
        <div class="col-sm-12" id="prendamenu">
        	<div class="text-center" style="height: 240px; overflow-y: scroll; max-height: 240px;">
	          <table class="table" cellspacing="0" >
              <thead >
                <tr>
                  <th scope="col">#</th>
                    <th scope="col">Articulo</th>
							      <th scope="col">Descripción</th>
							      <th scope="col">Dcto</th>
							      <th scope="col">Cantidad</th>
							      <th scope="col">Precio Unit</th>
                      <th scope="col">$/dcto</th>
                      <th scope="col">Importe</th>
                  </tr>
							</thead>
							  <tbody id="salestable">
						  	</tbody>
						</table>
		            </div><!--text center-->
		          </div><!--#PrendaMenu -->
	          </div><!--row -->
	          <div class="row">
	            <div class="col-sm-12">
		            <div class="form-group row">
                <label for="productid" class="col-sm-1 col-md-1 col-form-label text-right">#</label>
                <div class="col-sm-10 col-md-3">
				    		<div class="row">
				      			<input type="text" class="form-control col-sm-10" id="productid"  autofocus="autofocus" onkeydown="searchfield(event);">
				      			<div class="col-sm-1 col-md-1">
						    		<i class="fa fa-search pt-2"></i>
						    	</div>
				      		</div>
				    	</div>
				    	<div class="col-sm-12 col-md-8">

					    	<table class="table">
					    		<tr>
						    		<td class="pt-2">Subtotal</td><td><input type="text" name="dcto" value="30.00"  readonly class="form-control pt-1 pb-1 pl-2" style="width: 60px;"></td>
						    		<td class="pt-2">Dct</td><td><input type="text" name="dcto" value="30.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;"></td>
						    		<td class="pt-2">IVA</td><td><input type="text" name="dcto" value="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;"></td>
						    		<td class="pt-2">Total</td><td><input type="text" name="dcto" value="30.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;"></td>
						    		<td><button class="btn btn-success">Checkout</button></td>
					    		</tr>
					    	</table>
					    </div>
				  	</div>
			  		<div class="scroll" style="overflow-y: scroll; max-height: 220px; height: auto;">
			            <table class="table">
							  <thead>
								  <tr>
								      <th scope="col">#</th>
								      <th scope="col">Descripción</th>
								      <th scope="col">Cantidad</th>
								      <th scope="col">Precio</th>
								  </tr>
							</thead>
							  <tbody>
								  <tr class="prodrow" data-id="123" data-desc="Collar de animal" data-price="70">
								      <th scope="row">123</th>
								      <td>Collar de animal</td>
								      <td>2</td>
								      <td>70.00</td>
								  </tr>
								  <tr class="prodrow" data-id="2" data-desc="Collar de perro" data-price="80">
								      <th scope="row">2</th>
								      <td>Collar de perro</td>
								      <td>1</td>
								      <td>80.00</td>
								  </tr>
								  <tr class="prodrow" data-id="3" data-desc="Collar de tacos" data-price="90">
								      <th scope="row">3</th>
								      <td>Collar de tacos</td>
								      <td>3</td>
								      <td>90.00</td>
								  </tr>
								  <tr class="prodrow" data-id="4" data-desc="Collar de mujer" data-price="100">
								      <th scope="row">4</th>
								      <td>Collar de mujer</td>
								      <td>4</td>
								      <td>100.00</td>
								  </tr>
						  	</tbody>
						</table>
					</div><!--scroll-->
  <?php
    require "config/database.php";
  ?>
					</div><!--col-->
	            </div><!--row -->
	        </div><!--col -->
	        <div class="col-sm-12 col-md-3 bg-white pt-3">	        	
				<div class="row mb-3" style="height: 300px; overflow-y: scroll; max-height: 240px;">
					<div class="col-sm-12 col-md-12" >
			    		<table class="table">
						  	<thead>
							    <tr>
							      	<th scope="col"><a href="../SistemaJoyeria" style="color:black;"> <i class="fa fa-plus-square" ></i></a></th>
							      	<th scope="col">Folio</th>
							      	<th scope="col">Nombre</th>
							    </tr>
							</thead>
						  	<tbody>
							    <tr>
							      	<th scope="row">1</th>
							      	<td>12345</td>
							      	<td>Otto</td>
							    </tr>
							    <tr>
							      	<th scope="row">2</th>
							      	<td>123678</td>
							      	<td>Thornton</td>
							    </tr>
							    <tr>
							      	<th scope="row">3</th>
							      	<td>12908</td>
							      	<td>the Bird</td>
							    </tr>
							    <tr >
							      	<th scope="row" >4</th>
							      	<td >12678</td>
							      	<td>the Bird</td>
							    </tr>
							    <tr>
							      	<th scope="row">5</th>
							      	<td>12678</td>
							      	<td>the Bird</td>
							    </tr>
					  		</tbody>
						</table>
	    			</div><!-- col-->
				</div><!-- row-->
				<div class="row">
	        		<div class="col-sm-12">
						<form method="post">
							<div class="row mb-2">
								<div class="col-sm-1"></div>
								<div class="form-check col-sm-5">
					 		 		<input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onchange="apartadoclick();">
					  				<label class="form-check-label" for="defaultCheck1" >
										Apartado
									</label>
								</div>
								<div class="form-check col-sm-5">
					 		 		<input class="form-check-input" type="checkbox" value="" id="defaultCheck2" onchange="apartadoclick();">
					  				<label class="form-check-label" for="defaultCheck2">
										Factura
									</label>
								</div>
							</div>
						  	<div class="form-group row">
						    	<label for="clientNumber" class="col-sm-3 col-form-label">#</label>
						    	<div class="col-sm-9 row">
						      		<input type="text"  class="form-control col-sm-10" id="clientNumber" value="1" readonly onchange="buscarcliente();">
						      		<div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
						    	</div>
						  	</div>
						  	<div class="form-group row">
						    	<label for="Name" class="col-sm-3 col-form-label">Nombre</label>
						    	<div class="col-sm-9 row">
						      		<input type="text" class="form-control col-sm-10" id="nombre" name="nombre" placeholder="Mostrador">
						      		<div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
						    	</div>
						  	</div>
						  	<div class="form-group row">
						    	<label for="LastName" class="col-sm-3 col-form-label">Apellido</label>
						    	<div class="col-sm-9 row">
						      		<input type="text" class="form-control col-sm-10" id="apellido" name="apellido" placeholder="Mostrador">
						      		<div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
						    	</div>
						  	</div>
						  	<div class="form-group row">
						    	<label for="RFC" class="col-sm-3 col-form-label">RFC</label>
						    	<div class="col-sm-9 row">
						      		<input type="text" class="form-control col-sm-10" id="rfc" name="rfc" placeholder="" >
						    	</div>
						  	</div>
						  	<div class="form-group row">
						    	<label for="Tel" class="col-sm-3 col-form-label">Tel</label>
						    	<div class="col-sm-9 row">
						      		<input type="text" class="form-control col-sm-10" id="tel" name="tel" placeholder="" >
						      		<div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
						    	</div>
						  	</div>
                <div class="form-group row">
                <div class="col-sm-3">
                </div>
					    	<div class="col-sm-6">
                  <input type="submit" name="submit" class="btn-warning" value="Agregar Nuevo" id="btnagregar">
				         <!--  <button type="button" class="btn-warning" id="btnagregar" onclick="agregarcliente();">Agregar Nuevo</button> -->
				          <button type="button" class="btn-success" id="btnagregar" onclick="aceptarcliente();" style="display: none;">Aceptar</button>
						      </div>
						  	</div>
						</form>
					</div><!-- col-->
				</div><!-- row-->
      </div><!--col -->
   </div><!--row -->
	<?php
	include "footer-pdv.php";
?>
