<?php
	include("header-pdv.php");
	?>

	    <div class="row " id="panelprincipal">		  		
	   		<!-- Selección de procesos -->
	    	<div class="col-sm-12 col-md-9 bg-white pt-3" >
	        	<div class="a" id="prendamenu">
	        		<div class="text-center">
	          			<table class="table" cellspacing="0">
						  	<thead>
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
							    <tr id="item[1]">
							      	<th scope="row">1</th>
							      	<td>20495</td>
							      	<td>Aretes 911 mujer</td>
							      	<td class="p-2">
							      		<input type="text" name="discRaw[1]" class="form-control mx-auto input-number2 " value="0" min="0" max="99" style="width: 55px;" id="discRaw[1]" data-row="1">
							      	</td>
							      	<td class="p-2">
										<div class="input-group">
								          	<span class="input-group-btn">
						        		      	<button type="button" class="btn btn-default btn-number" data-type="minus" data-field="quant[1]">
						        		      		<i class="fa fa-minus"></i>
									            </button>
									        </span>
									        <input type="text" name="quant[1]" class="form-control input-number" value="1" min="0" max="999" style="width: 4px;" onchange="changequantity(1);" id="quant[1]">
									        <span class="input-group-btn">
									            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
						        		      		<i class="fa fa-plus"></i>									            	
									            </button>
									        </span>
								      	</div>						
      								</td>	      	
      								<td id="raw[1]">70.00</td>
							      	<td id="disc[1]">70.00</td>
							      	<td id="total[1]">70.00</td>
							    </tr>
							    
					  		</tbody>
						</table>
	            	</div>
	            </div>
	        </div>
	        <div class="col-sm-12 col-md-3 bg-white pt-3">
				<form>
					<div class="row mb-2">
						<div class="col-sm-1"></div>
						<div class="form-check col-sm-5">
			 		 		<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
			  				<label class="form-check-label" for="defaultCheck1">
								Apartado
							</label>
						</div>
						<div class="form-check col-sm-5">
			 		 		<input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
			  				<label class="form-check-label" for="defaultCheck2">
								Factura
							</label>
						</div>
					</div>
				  	<div class="form-group row">
				    	<label for="clientNumber" class="col-sm-3 col-form-label">#</label>
				    	<div class="col-sm-9">
				      		<input type="text"  class="form-control" id="clientNumber" value="1" readonly>
				    	</div>
				  	</div>
				  	<div class="form-group row">
				    	<label for="Name" class="col-sm-3 col-form-label">Nombre</label>
				    	<div class="col-sm-9">
				      		<input type="text" class="form-control" id="Name" placeholder="Mostrador" readonly>
				    	</div>
				  	</div>
				  	<div class="form-group row">
				    	<label for="RFC" class="col-sm-3 col-form-label">RFC</label>
				    	<div class="col-sm-9">
				      		<input type="text" class="form-control" id="RFC" placeholder="" readonly>
				    	</div>
				  	</div>
				</form>
	        </div>	
	    </div>
	    <div class="row bg-white">
	    	<div class="col-sm-12 col-md-9 pl-4">
	    		<div class="form-group row">
			    	<label for="inputPassword" class="col-sm-2 col-md-1 col-form-label ">#</label>
			    	<div class="col-sm-10 col-md-5">
			      		<input type="text" class="form-control" id="productid" placeholder="" autofocus="autofocus">
			    	</div>
			    	<i class="fa fa-search pt-2"></i>
			    	<button class="btn btn-default ml-4 mb-2 " id="filtrobuttonlinea" style="display: none;" onclick="byelinea();"> <span id="filtrolinea"></span> <i class="fa fa-times pt-2"></i></button>
 			    	<button class="btn btn-default ml-4 mb-2" id="filtrobuttondepto" style="display: none;" onclick="byedepto();"><span id="filtrodepto"> </span> <i class="fa fa-times pt-2"></i></button>

			    	<input type="text" name="linea" class="form-control" id="lineaInput" readonly value="" style="display: none;">
					<input type="text" name="depto" class="form-control" id="deptoInput" readonly value="" style="display: none;">

			  	</div>
			  	<div class="row" id="blocklinea">
			  		<div class="col-sm-6 col-lg-2 col-md-4 mb-3 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Anillos" data-id="1">Anillo
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Aretes" data-id="2">Aretes
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Rosarios" data-id="3">Rosarios
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Dijes" data-id="4">Dijes
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Cadenas" data-id="5">Cadenas
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Esclava" data-id="6">Esclava
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Collar" data-id="7">Collar
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-linea col-sm-12 prenda-1 align-middle pt-2" data-linea = "Todos" data-id="8">Todos
			  			</div>
			  		</div>
			  	</div>
			  	<div class="row" id="blockdepto" style="display: none;">
			  		<div class="col-sm-6 col-lg-2 col-md-4 mb-3 p-1"> 
			  			<div class= "btn button-prenda button-depto col-sm-12 prenda-2 align-middle pt-2" data-linea = "Hombre" data-id="1">Hombre
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-depto col-sm-12 prenda-2 align-middle pt-2" data-linea = "Mujer" data-id="2">Mujer
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-depto col-sm-12 prenda-2 align-middle pt-2" data-linea = "Unisex" data-id="3">Unisex
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-depto col-sm-12 prenda-2 align-middle pt-2" data-linea = "Ninos" data-id="4">Ninos
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-depto col-sm-12 prenda-2 align-middle pt-2" data-linea = "Bebes" data-id="5">Bebes
			  			</div>
			  		</div>
			  		<div class="col-sm-6 col-lg-2 col-md-4 p-1"> 
			  			<div class= "btn button-prenda button-depto col-sm-12 prenda-2 align-middle pt-2" data-linea = "Todos" data-id="8">Todos
			  			</div>
			  		</div>
			  	</div>
			  	<div class="row" id="blockprod" style="display: none;">
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
					    <tr>
					      	<th scope="row">2</th>
					      	<td>Collar de perro</td>
					      	<td>1</td>
					      	<td>80.00</td>
					    </tr>
					    <tr>
					      	<th scope="row">3</th>
					      	<td>Collar de tacos</td>
					      	<td>3</td>
					      	<td>90.00</td>
					    </tr>
					    <tr>
					      	<th scope="row">4</th>
					      	<td>Collar de mujer</td>
					      	<td>4</td>
					      	<td>100.00</td>
					    </tr>
			  		</tbody>
				</table>
			  	</div>
	    	</div>
	    	<div class="col-sm-12 col-md-3">
	    		<table class="table">
				  	<thead>
					    <tr>
					      	<th scope="col">#</th>
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
					    <tr>
					      	<th scope="row">4</th>
					      	<td>12678</td>
					      	<td>the Bird</td>
					    </tr>
			  		</tbody>
				</table>
	    	</div>
	    </div>
	    
	<?php
	include "footer-pdv.php";
?>