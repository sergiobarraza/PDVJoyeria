<?php
	
	include 'conexion.php';
  	$prendaprocesoArray=[];

  	if (isset($_GET['folio'])) {
		}
	else{
		;}
	?>
<!DOCTYPE html>
<html>
	<head>
		<title>Joyeria Claro</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="w3.css">
		<link type="text/css" rel="stylesheet" href="css2.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	</head>
	<body class="w3-light-grey">
		<div class="w3-bar w3-black w3-hide-small">
		    <a href="logout.php" class="w3-bar-item w3-button">Cerrar sesión</a>
		    <a href="historial.php" class="w3-bar-item w3-button">Ver historial</a>
		    <a href="../pdv2.php" class="w3-bar-item w3-button">Regresar</a>
		    <a href="#" class="w3-bar-item w3-button w3-right"><i class="fa fa-info-circle"></i></a>
		</div>

		<div class="w3-content">
		    
		    <div class="w3-row w3-padding w3-border" id="panelprincipal">		  		
		   		<!-- Selección de procesos -->
		    	<div class="w3-col l4 s12 " >
		        	<div class="w3-container w3-white w3-margin w3-padding" id="prendamenu" style="min-height: 300px;display: <?php echo $bloquesprincipales;?>">
		        		<div class="w3-center">
		          			<h3>PRENDAS</h3>
		            	</div>
		          		<!-- BOTONES -->
		        		<?php  
		          			$sql3 = "select * from prenda;";
		          			$result3 = mysqli_query($con, $sql3);
			          		$rows3 = $result3->num_rows;

		    	      		for ($i=0 ; $i < $rows3 ; $i++){
		        	  			$row3 = $result3->fetch_assoc();
		          				echo '<div class="w3-col l6 m6 s6"> <div class= "w3-btn button-prenda w3-col s11 prenda-'.$row3["id_prenda"].' " onclick="select_prenda('.$row3["id_prenda"].')">'.$row3["nombre_prenda"].'</div></div>';
				          		}
			       		 ?>
		      		</div>
		    		<div class="w3-container w3-white w3-margin w3-padding" id="procesomenu" style="display: none;min-height: 300px;">
		        
		       		</div>
		    	</div>

		   		<!--Panel de Control-->
		    	<div class="w3-col l4 s12"  >
			    	<div class="row">	
			    		<div  class="w3-white w3-margin" id="divPanel">
			        		<div class="w3-container w3-padding w3-black">
			          			<h4>Panel de control</h4>
			        		</div>
			       			<div style="padding:15px" class="w3-ul w3-hoverable w3-white">
			        		<!-- AGREGAR NUEVO PEDIDO -->
			         			<form class="panelControl" action="pedidoNew.php" method="post" enctype="multipart/form-data">
			          				<table style="width: 100%;">
			          	 				<tr>
			          	    				<td><label class="w3-padding-16 w3-large">Nombre: </label></td>
			          	    				<td><input type="text" name="nombreCliente" id="nombreCliente" style="width: 100%;" required><br></td>
			          	  				</tr>		          
			            				<tr>
					      					<td><label class="w3-padding-16 w3-large">Urgencia:</label></td>
			            					<td>
						            			<select onchange="usuarioselect();" name="urgencia_select" id="urgencia">
											        <option selected value="1">BAJA</option>
											        <option value="3">ALTA</option>
								      			</select>
					      					</td>
			            				</tr>
			            				<tr>
			            					<td >
			            						<label class="w3-padding-16 w3-large">Tiempo:</label>
			            					</td>
											<td >
												<input type="hidden" name="tiempoEstimado" id="tiempo" style="width: 100%;" value="900">
												<input type="text" name="tiempoEstimado2" id="tiempo2" style="width: 100%;" value="00:00:00" readonly="">
											</td>
			            				</tr>
			            				<tr>
			            					<td >
			            						<label class="w3-padding-16 w3-large">Comentario:</label>
			            					</td>
			            					<td >
			            						<input type="text" name="comentario" id="comentarioFolio" style="width: 100%;" onchange="cambio_de_comentario();">
			            					</td>
			            				</tr>
			            				<tr>
			            					<td colspan="">
			            						
			            					</td>
			            					<td>
	           								 	<i class="fa fa-camera" id="PhotoButton" style="font-size: 32px; color:black; margin:5px; "></i>
	           								 	<input type="file" accept="image/*" capture="camera" name="archivo" id="PhotoPicker" style="display: none;">
			            					</td>
											
			            				</tr>
			            				<tr>
			            					<td >
			            						<a id="btn_agregados" class= "button-cancelar" onclick="window.location.replace(location.pathname);">CANCELAR</a>
			            					</td>
											<td  id="botonAceptar">
												<input type="submit" value="ACEPTAR" name="submit" class="button-aceptar">
											</td>
			            				</tr>
						            </table>
			           				<input type="hidden" name="comentarioName" id="comentarioSet" value="">
			            			<input type="hidden" name="tablaName" id="tablaId" value="">
			        			    <input type="hidden" name="prendaSeleccionada2" id="prendaSeleccionada2" value="">
	   		        			    <input type="hidden" name="operador_select" id="operadorInput" value="eduardo">
			       			    </form>
			       			</div>
			      		</div>
			      		<!-- PANEL DE CONTROL DE CAMBIOS -->
			   
				    	<div class="w3-white w3-margin" id="divFolio" style="display: none;">
				        	<div class="w3-container w3-padding w3-black">
				            	<h4>Folio: 
				            		<spam id="folioUpdate"></spam>
				          		</h4>
				        	</div>
					        <div style="padding:15px" class="w3-ul w3-hoverable w3-white">
					        
				        		<!-- DATOS DEL FOLIO SELECCIONADO -->
				          		<form class="panelControl" action="verPedido.php" method="post">
				          			<input type="hidden" name="folioName" id="folioForm" value="">
				          			<table class="panelFolio">
				          	  			<tr>
				          	    			<td>
				          	    				<label class="w3-padding-16 w3-large">Nombre: </label>
				          	    			</td>
				          	    			<td colspan="2">
				          	    				<input type="text" name="nombreClienteFolio" id="nombreClienteFolio"  readOnly value="Rosa Maria">
				          	    			</td>
				          	  			</tr>
				            			<tr>
				            				<td>
				            					<label class="w3-padding-16 w3-large">Cliente:</label>
				            				</td>
				            				<td colspan="2">
				            					<input style="text-transform: uppercase;" name="ClienteId" id="ClienteId" readonly>				 							    
						      				</td>
						      			</tr>
						            	
						            	<tr>
						            		<td>
						            			<label class="w3-padding-16 w3-large">Tiempo Estimado:</label>
						            		</td>
											<td colspan="2">
												<input type="text" name="tiempoEstimadoFolio" id="tiempoFolio" style="width: 100%;" value="" readOnly>
											</td>
						            	</tr>
						            	<tr>
						            		<td>
						            			<label class="w3-padding-16 w3-large">Precio Total:</label>
						            		</td>
											<td colspan="2">
												<input type="text" name="tiempoEstimadoFolio" id="precioTotal" style="width: 100%;" value="" readOnly>
											</td>
						            	</tr>
						            	<tr>
						            		<tr>
						            		<td>
						            			<label class="w3-padding-16 w3-large">Precio Restante:</label>
						            		</td>
											<td colspan="2">
												<input type="text" name="tiempoEstimadoFolio" id="precioRestante" style="width: 100%;" value="" readOnly>
											</td>
						            	</tr>
						            	<tr>
						            		<td >
						            			<label class="w3-padding-16 w3-large">Comentario:</label>
						            		</td>
						            		<td colspan="2">
						            			<input type="text" name="comentarioName" id="comentarioFolio2" readOnly style="width: 100%;">
						            		</td>
						            	</tr>
						            	<tr >
						            		<td >
						            			<a  class= "button-eliminar" onclick="eliminar();" >ELIMINAR</a>
						            		</td>
						            		<td id="botonCambiar">
						            			<!--button  class="button-editar">EDITAR</button-->
						            		</td>
											<td>
												<a id="btn_agregados" class= "button-aceptar2" onclick="window.location.replace(location.pathname);">ACEPTAR</a>
											</td>
											
						            	</tr>
				     		     	</table>
				         		</form>
				        	</div>
				      	</div>
			    
			      	</div>
			      	<div class="row" id="divAgregados">
			      		<div class="w3-white w3-margin">
			        		<div class="w3-container w3-padding w3-black">
			          			<h4>Procesos agregados</h4>
			        		</div>
			        		<div style="padding:15px 10px; font-size: 24px;" class="w3-ul w3-hoverable w3-white">
			        			<div id="procesos_agregados" class="tablaAgregados">
				          			<table id=tablaPrendasProcesos>
				          				<tr>
				          					<th></th>
				          					<th>
				          						<label class="w3-padding-16 w3-large">Prenda:</label>
				          					</th>
				          					<th>
				          						<label class="w3-padding-16 w3-large">Proceso:</label>
				          					</th>
				          				</tr>
				          			</table><br>
			            		</div>
					        </div>
		  		        </div><hr>
			      	</div>
			      	<div class="row" id="divAgregados2" style="display: none">
			      		<!--Agregados2-->				    	
			      		<div class="w3-white w3-margin">
			        		<div class="w3-container w3-padding w3-black">
			          			<h4>Procesos En Folio</h4>
			        		</div>
			        		<div style="padding:15px 10px; font-size: 24px;" class="w3-ul w3-hoverable w3-white">
			        			<div id="procesos_agregados2" class="tablaAgregados">
				          			<table id=tablaPrendasProcesos2>
				          				<tr>
				          					<th></th>
				          					<th>
				          						<label class="w3-padding-16 w3-large">Prenda:</label>
				          					</th>
				          					<th>
				          						<label class="w3-padding-16 w3-large">Proceso:</label>
				          					</th>
				          				</tr>
				          			</table><br>
			            		</div>
					        </div>
		  		        </div>				    	
			      	</div>	
		  		</div>


				
		   		<!--En Fila-->
		    	<div  id="divProcesos" class="w3-col l2" >
		      		<div class="w3-white w3-margin">
		        		<div class="w3-container w3-padding w3-black">
		          			<h4>Procesos en fila</h4>
		        		</div>
		        		<div style="padding:0px ; font-size: 24px;" class="w3-ul w3-hoverable w3-white">
		        			<div  class="tablaAgregados" style="height:500px;overflow-y: scroll;">
			          		
			          			<?php
			          					$sqlFila = "SELECT Fila.idFolio, Fila.urgencia, Trabajo.idCliente, Trabajo.tiempo_estimado 
													from Fila 
													join trabajo on Fila.idFolio = Trabajo.idTrabajo
													where estado = 0 or estado = 1
													group by idFolio 

													order by urgencia desc,fecha asc;";
										$resultFila = mysqli_query($con, $sqlFila);
			          					$rows = $resultFila->num_rows;
			          					for ($i=0 ; $i < $rows ; $i++){
					        	  			$rowFila = $resultFila->fetch_assoc();
					        	  			if ($rowFila["urgencia"]==3)
					          				echo '<div class="button-cancelar w3-center" onclick="Myclick('.$rowFila["idFolio"].')">';
			          						else
			          						echo '<div class="button-aceptar w3-center" onclick="Myclick('.$rowFila["idFolio"].')">';
					          				echo "<span style='font-size: 18px;display: block;'>Folio: ".$rowFila["idFolio"]."</span>
			          						<span style='font-size: 18px;display: block;'>".$rowFila["tiempo_estimado"]." Segs</span>
			          						<span style='font-size: 18px;display: block;'>Cliente: ".$rowFila["idCliente"]."</span>
			          						</div>";
				          				}
			          				?>
		            		</div>
				        </div>
	  		        </div><hr>
		    	</div>

		    	<!--Terminados-->
		    	<div  id="divterminados" class="w3-col l2" >
		      		<div class="w3-white w3-margin">
		        		<div class="w3-container w3-padding w3-black">
		          			<h4>terminados</h4>
		        		</div>
		        		<div style="padding:0; font-size: 24px;" class="w3-ul w3-hoverable w3-white">
		        			<div  class="tablaAgregados" style="height:500px;overflow-y: scroll;">
			          			<?php
			          					$sqlFila = "SELECT Fila.idFolio, Fila.urgencia, Trabajo.idCliente, Trabajo.tiempo_estimado , Fila.estado
													from Fila 
													join trabajo on Fila.idFolio = Trabajo.idTrabajo
													where estado = 2 OR estado = 3
													group by idFolio 
													order by estado desc,fecha desc;";
										$resultFila = mysqli_query($con, $sqlFila);
			          					$rows = $resultFila->num_rows;
			          					for ($i=0 ; $i < $rows ; $i++){
					        	  			$rowFila = $resultFila->fetch_assoc();
					        	  			if ($rowFila["estado"]==2)
					          				echo '<div class="button-aceptar prenda-1 w3-center w3-col s12" onclick="Myclick('.$rowFila["idFolio"].')">';
			          						else
			          						echo '<div class="button-aceptar prenda-2 w3-center" onclick="Myclick('.$rowFila["idFolio"].')">';
					          				echo "<span style='font-size: 18px;display: block;'>Folio: ".$rowFila["idFolio"]."</span>
			          						<span style='font-size: 18px;display: block;'>".$rowFila["tiempo_estimado"]." Segs</span>
			          						<span style='font-size: 18px;display: block;'>Cliente: ".$rowFila["idCliente"]."</span>
			          						</div>";
				          				}
			          				?>
		            		</div>
				        </div>
	  		        </div><hr>
		    	</div>
		    	
		    	
		  

			</div>
			
		</div>
		<footer class="w3-container w3-dark-grey" >
	    	<p>Powered by BARRAZA.MX</p>
		</footer>
	</body>
</html>

<script type="text/javascript">
/* Inicialización de Variables 
*	
*/
	var tablaPrendaProcesos = [];
	var tiempos = [];


/*Función Usuario Select 
*  Dependiendo del usuario seleccionado calcula el tiempo que tiene un operador sumando los procesos actualmente agregados
*  Manda a llamar a la función calculartiempo() la cuál dependiendo del nivel de urgencia agrega el tiempo necesario.
*/
	function usuarioselect(){
		var operadorActual = usuarioseleccionado[0];
		var urlString = "llenarTiempo.php";
		$.get(urlString, {operador: operadorActual}, (response) => {
				calculartiempo(JSON.parse(response));
			});
	}
/* Función Calcular Tiempo
*   La función calcular tiempo asigna el tiempo en el campo HTML para ser visualizado en el panel de control. Dependiendo de 
*	la urgencia, asigna el tiempo de los procesos actuales o suma los folios e cola. Borra los valores anteriores y coloca el valor 
*	recien calculado.
*	tiempocolaG = tiempo en cola del operador. Cuando la urgencia es alta, tiempocolaG = 0.
*	tiempos = tiempo de los procesos actuales.
*/
	function calculartiempo(response){

		var u = document.getElementById("urgencia");
		var urgencia = u.options[u.selectedIndex].value;
		if (urgencia == 1){
			var tiempocola = response[0]['tiempoTotal'];
			} else{
			var tiempocola = 0;
		}
		if(tiempocola == undefined){
			var	tiempocola=0;
		}
		tiempocolaG.splice(0,1);
		tiempocolaG.push(tiempocola);
		llenartiempo2(tiempocolaG,tiempos);
	}

/* Función llenartiempo2()
*	calcula el tiempo en horas, minutos y segundos. Lo inserta dentro del elemento tiempo2.
*/
	function llenartiempo2(cola,proc){
		var tiempoSuma=0;
		var fin=cola.length;
		var fin2=proc.length;
		for (var i = 0; i < fin; i++) {
			tiempoSuma= Math.floor( tiempoSuma + cola[i])	;	
		}
		for (var i = 0; i < fin2; i++) {
			tiempoSuma= Math.floor(tiempoSuma + proc[i])	;	
		}

		var horas = Math.floor( tiempoSuma / 3600 );  
		var minutos = Math.floor( (tiempoSuma % 3600) / 60 );
		var segundos = tiempoSuma % 60;

		horas = horas < 10 ? '0' + horas : horas;
		minutos = minutos < 10 ? '0' + minutos : minutos;
		segundos = segundos < 10 ? '0' + segundos : segundos;
		var result = horas + ":" + minutos + ":" + segundos;
		document.getElementById("tiempo2").value = result;

	}
/*Función Myclick()
*	Es mandada a llamar al presionar sobre el folio en la sección de colas. Abre el panel de edición de un cierto folio. Manda a   	*	llamar llenarDatos.php y posteriormente llenarDatos()
*/

	function Myclick(folio){
		//alert(folio);
		var urlString = "llenarDatosTrabajo.php";
		if (folio){
			$.get(urlString, {folio: folio}, (response) => {
				llenarDatosTrabajo(JSON.parse(response));
			});
		}
		urlString = "llenarTabla.php";
		if (folio){
			$.get(urlString, {folio: folio}, (response) => {
				llenarTablaFolio(JSON.parse(response));
			});

		}

		document.getElementById("divAgregados").style.display = "none";
		document.getElementById("divAgregados2").style.display = "block";
		document.getElementById("divPanel").style.display = "none";
		document.getElementById("divFolio").style.display = "block";
		//document.getElementById("divFoto").style.display = "block";


		
	}
	/*Función llenarDatosTrabajo()
	*	Es llamada por la función Myclick y sirve para convertir el tiempo de segundos a HH:MM:SS y lo coloca en los espacios del       
	*	formulario predeterminado
	*/
	function llenarDatosTrabajo(response){	
		document.getElementById("nombreClienteFolio").value = "El nombre del cliente";
		//document.getElementById("nombreClienteFolio").value = response[0]['nombre_cliente'];
		document.getElementById("ClienteId").value = response[0]['idCliente'];
		document.getElementById("folioUpdate").innerHTML = response[0]['idTrabajo'];
		document.getElementById("precioTotal").value = response[0]['precio'];
		document.getElementById("comentarioFolio2").value=response[0]['comentario'];

		var suma = parseInt(response[0]['tiempo_estimado']);
		var horas = Math.floor( suma / 3600 );  
		var minutos = Math.floor( (suma % 3600) / 60 );
		var segundos = suma % 60;

		minutos = minutos < 10 ? '0' + minutos : minutos;
		segundos = segundos < 10 ? '0' + segundos : segundos;
		var result = horas + ":" + minutos + ":" + segundos;
		
		document.getElementById("tiempoFolio").value = result;
		document.getElementById("folioForm").value=response[0]['idTrabajo'];
		document.getElementById("comentarioFolio2").value=response[0]['comentario'];
	}

/** Funcion llenarTablaFolio()
*		Es llamado por la funcion Myclick y sirve para llenar la tabla de prendas y procesos
*/
	function llenarTablaFolio(response){
		var tabla = document.getElementById("tablaPrendasProcesos2");
	  	//var bloqueimagen = document.getElementById("imagenblock");

		//console.log(document.getElementById("imagenblock").childNodes[1]);
		while(tabla.childNodes.length > 2 ){
			console.log(tabla.childNodes.length);
			tabla.removeChild(tabla.childNodes[2]);
		}
/*
		if (document.getElementById("imagenblock").childNodes[1] != undefined) {
			bloqueimagen.removeChild(bloqueimagen.childNodes[1]);
		}*/
		var tr =[];
		var td = [];
		var td1 = [];
		var td2 = [];
		var prenda = [];
		var proceso = [];
		var icono = [];

		for (var i = 0; i < response.length; i++) {
			tr[i] = document.createElement("tr");
			td[i] = document.createElement("td");
			td1[i] = document.createElement("td");
			td2[i] = document.createElement("td");
			prenda[i] = document.createTextNode(response[i]['nombre_prenda']);
			proceso[i] = document.createTextNode(response[i]['nombre_proceso']);
			icono[i] = document.createElement("i");
			icono[i].className = "fa fa-window-close fa-lg";
			icono[i].style = "cursor: pointer; line-height: 30px;"
			icono[i].id = "iid"+tablaPrendaProcesos.length;
			icono[i].onclick=function(){ quitar2(this.id);};

		td[i].appendChild(icono[i]);
		td1[i].appendChild(prenda[i]);
		td2[i].appendChild(proceso[i]);
		tr[i].appendChild(td[i]);
		tr[i].appendChild(td1[i]);
		tr[i].appendChild(td2[i]);
		tabla.appendChild(tr[i]);
		}

		  	if (response[0]['imagen']!="") {
		  		var imagen = document.createElement("img");
		  		imagen.src= response[0]['imagen'];
		  		bloqueimagen.appendChild(imagen);
		  	}else{
		  		console.log("No hay imagen");
		 	}



		/*tr.id = "trid" +tablaPrendaProcesos.length;
		tabla.appendChild(tr);*/
	}

/*	function agregados(){
		document.getElementById("divAgregados").style.display = "block";
		document.getElementById("divPanel").style.display = "none";
	}

	function aceptar(){
		document.getElementById("divAgregados").style.display = "none";
		document.getElementById("divPanel").style.display = "block";
		document.getElementById("tablaId").value = tablaPrendaProcesos;
	}

	function prenda() {
		document.getElementById('procesos').options.length = 0;
		var p = document.getElementById("prenda_select");
		var prendaSeleccionada = p.options[p.selectedIndex].value;
		var urlString = "procesos.php";
		var response = [];
		
		if (prendaSeleccionada){
			
			$.get(urlString, {prenda: prendaSeleccionada}, (response) => {
				procesos(JSON.parse(response));
			});
		}
	}

	function procesos(response){
		
		var resp = response;
		var procesos = document.getElementById("procesos");
		for (var i=0 ; i< resp.length ;i++){
			var option = document.createElement("option");
			option.value = resp[i]['proceso'];
			option.innerHTML = resp[i]['nombre_proceso'];
			procesos.appendChild(option);
		}
	}
*/

/* Función agregarPrendaProceso(id_proc)
*	Esta función es mandada llamar con el id de la prenda_proceso del boton al que se oprimio desde el catálogo de procesos, que se 
* 	abre al oprimir sobre una prenda. Utilizando el id de la prenda y del proceso, manda a llamar la función llenarTabla()
*/
	function agregarPrendaProceso(id_proc){

		var proceso = id_proc;
		prenda = document.getElementById("prendaSeleccionada2").value;
		var prendaProcesos = [];
		var idtabla = Math.floor(tablaPrendaProcesos.length+1);
		prendaProcesos.push(idtabla,prenda,proceso);		
		tablaPrendaProcesos.push(prendaProcesos);
		var x = tablaPrendaProcesos[0];
		console.log(tablaPrendaProcesos);
		var urlString = 'prendaProceso.php';

		$.get(urlString, {prenda:prenda , proceso: proceso }, (response) =>{
			llenarTabla(JSON.parse(response));
		});

		document.getElementById("tablaId").value = tablaPrendaProcesos;
		usuarioselect();	
	}

/* Función llenarTabla()
*	Se encarga de llenar la tabla de procesos agregados con la nueva prenda-proceso seleccionado. Esta función es llamada desde     *	agregarPrendaProceso 
*/
	function llenarTabla(response){
		var tabla = document.getElementById("tablaPrendasProcesos");
		var tr = document.createElement("tr");
		var td = document.createElement("td");
		var td1 = document.createElement("td");
		var td2 = document.createElement("td");

		var prenda = document.createTextNode(response[0]['nombre_prenda']);
		var proceso = document.createTextNode(response[0]['nombre_proceso']);
		  
		var icono = document.createElement("i");
		icono.className = "fa fa-window-close fa-lg";
		icono.style = "cursor: pointer; line-height: 30px;"
		icono.id = "iid"+tablaPrendaProcesos.length;
		icono.onclick=function(){ quitar2(this.id);};


		td.appendChild(icono);
		td1.appendChild(prenda);
		td2.appendChild(proceso);

		tr.appendChild(td);
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.id = "trid" +tablaPrendaProcesos.length;
		tabla.appendChild(tr);

		var tiempo = parseInt(response[0]['tiempo_estimado']);
		tiempos.push(tiempo);

		var suma = parseInt(0);
		

		for (var i = 0; i < tiempos.length ; i++){
			suma = suma + tiempos[i];
			var horas = Math.floor( suma / 3600 );  
			var minutos = Math.floor( (suma % 3600) / 60 );
			var segundos = suma % 60;
 
			minutos = minutos < 10 ? '0' + minutos : minutos;
			segundos = segundos < 10 ? '0' + segundos : segundos;
			var result = horas + ":" + minutos + ":" + segundos;  
		}
		console.log(suma);
		document.getElementById("tiempo").value = suma;
		document.getElementById("tiempo2").value = result;
		

	}

	
/*
	function abilitarQuitar(){
		document.getElementById("btn_quitar").style.opacity= 1;
		document.getElementById("btn_quitar").style.cursor= "pointer";
	}
*/

	function quitar(){
		var tabla = document.getElementById("tablaPrendasProcesos");
		var tablaLength = $("#tablaPrendasProcesos").find("tr:not(:first)").length;
		console.log("table length:");
		console.log(tablaLength);
		for (var i=0 ; i< tablaLength ; i++){
			
			var checkboxSelected = document.getElementById("c"+(i+1)).checked;
			
			if (checkboxSelected){	
				console.log(tablaPrendaProcesos);	
			}
		}
		usuarioselect();	
		
	}
/*Función eliminar()
*	Es mandada a llamar al presionar el boton de elimnar en el panel de edición de un documento. Manda a llamar a la función eliminar Pedido y sirve para eliminar el folio seleccionado
*/
  function eliminar(){
  	var urlString = "eliminarPedido.php";
  	var folio = document.getElementById("folioForm").value;
  	$.get(urlString, {folio: folio}, (response) => {
	window.location.replace(location.pathname);
		});
	}

/*INDEX 2 FUnctions*/
/*Función select_prenda(id_prenda)
*	Es mandada a llamar cuando se orpime el boton de alguna de las prendas. Manda a llamar a la función procesos2.php y            	*	llenar_proceso()
*/
	function select_prenda(id_prenda){
		var urlString = "procesos2.php";
		var prendaSeleccionada = id_prenda;
		var response = [];
	
		if (prendaSeleccionada){
			
			$.get(urlString, {prenda: prendaSeleccionada}, (response) => {
				llenar_proceso(JSON.parse(response),prendaSeleccionada);
			});
		}
	}

/* Función llenar_proceso(response, prendaSeleccionada)
*	Es llamada por select_prenda y muestra los procesos correspondientes a la prenda seleccionada
*
*/
	function llenar_proceso(response,prendaSeleccionada){
		var resp = response;
		console.log(resp[1]);
		var bloqueproceso = document.getElementById("procesomenu");
		bloqueproceso.removeChild(bloqueproceso.firstChild);
		var prenda = document.getElementById("prendaSeleccionada2");
		prenda.value = prendaSeleccionada;
		var centrar = document.createElement("div");
		centrar.className = "w3-center";
		var icono = document.createElement("i");
		icono.className= "fa fa-chevron-circle-left";
		icono.style="cursor: pointer;";
		icono.onclick=function(){ regresar();};
		var headproc = document.createElement("h3");
		var tit = "   Proceso";
		var titulo = document.createTextNode(tit);
		headproc.appendChild(icono);
		headproc.appendChild(titulo);
		centrar.appendChild(headproc);
		var botonArray=[];
		for (var i=0 ; i< resp.length ;i++){
			var botonbloque = document.createElement("div");
			botonbloque.className = "w3-col l6 m6 s6";
			var boton = document.createElement("div");
			var claseboton = "w3-col s11 w3-btn button-proceso prenda-" + prendaSeleccionada;
			boton.className= claseboton;
			var id_proc =resp[i]['proceso'];
			boton.onclick=function(){ agregarPrendaProceso(this.id);};
			boton.id=id_proc;
			boton.innerHTML = resp[i]['nombre_proceso'];
			botonbloque.appendChild(boton);
			centrar.appendChild(botonbloque);	
			}

		bloqueproceso.appendChild(centrar);
		document.getElementById("prendamenu").style.display = "none";
		document.getElementById("procesomenu").style.display = "block";
		

	}
/* Función regresar()
*	Vuelve a la selcción de prendas.
*/
	function regresar(){

		document.getElementById("prendamenu").style.display = "block";
		document.getElementById("procesomenu").style.display = "none";	
	}


/* Función user_select
*	La función es llamada al presionar el nombre de los operadores y permite seleccionar al operador que realizará la acción,       *	resaltando su nombre y agregando sus tiempos a la cola
*/
	function user_select(userid,usernamecola) {
		if (usernamecola=="hechuras") {
			document.getElementById("divOphechuras").style.display = "block";

		}else{
			document.getElementById("divOphechuras").style.display = "none";

		}
		var colapasada = document.getElementById(usuarioseleccionado[0]);
		colapasada.style.background = "#050e51";
		usuarioseleccionado.splice(0,1);
		usuarioseleccionado.push(userid);
		var headcola = document.getElementById(userid);
		headcola.style.background = "red";
		var operInput = document.getElementById("operadorInput");
		operInput.value=usernamecola;
		usuarioselect();
		cambio_de_comentario();
	}

/*Función quitar2()
*	Quita una prenda_proceso agregada, al darle click sobre la "x" de esta 
*/
	function quitar2(id_pp){
		var id_prendaproc = "";
		for (var i = 3; i < id_pp.length; i++) {
		var id_prendaproc = id_prendaproc + id_pp[i];
		}	

		var tabla = document.getElementById("tablaPrendasProcesos");
		var tablaLength = $("#tablaPrendasProcesos").find("tr:not(:first)").length;
		var idpp="trid";
		idpp=idpp+id_prendaproc;
		var row = document.getElementById(idpp);
		row.parentNode.removeChild(row);


		for (var i=0 ; i< tablaPrendaProcesos.length ; i++){
			if (tablaPrendaProcesos[i][0] == id_prendaproc) {
				tablaPrendaProcesos.splice(i,1);
				tiempos.splice(i,1);
			}
		}
		
		console.log(tablaPrendaProcesos);
		document.getElementById("tablaId").value = tablaPrendaProcesos;
		usuarioselect();	
		
	}

/*
*
*/
function cambio_de_comentario(){
	var comment = document.getElementById("comentarioFolio").value;
	if (usuarioseleccionado[0]=="Hechuras") {

		var comentariofinal = hechuraseleccionada[0];
		
		while(comentariofinal.length<8){
			comentariofinal = comentariofinal + " ";
		}

		comentariofinal = comentariofinal + " - " + comment;
		var comentarioVar = document.getElementById("comentarioSet");
		comentarioVar.value= comentariofinal;
	}else{
		var comentarioVar = document.getElementById("comentarioSet");
		comentarioVar.value=comment;
	}

}

/*
*
*/
function usuariohechura(usuariohech){
	//Anterior - Azul
	var hechuraanterior = "boton-"+ hechuraseleccionada[0];
	var hechanterior = document.getElementById(hechuraanterior);
	hechanterior.style.background = "#3875d8";
	hechuraseleccionada.splice(0,1);
	hechuraseleccionada.push(usuariohech);
	//actual 
	var nombreboton= "boton-" + usuariohech;
	var usuarioboton = document.getElementById(nombreboton);
	usuarioboton.style.background = "red";
	cambio_de_comentario();
}

//Icono de foto
		$('#PhotoButton').click(function() {
     		$('#PhotoPicker').trigger('click');
     		return false;
   		});
		$('#PhotoPicker').on('change', function(e) {
		    e.preventDefault();
		    if(this.files.length === 0) return;
		    var imageFile = this.files[0];
		    console.log(imageFile);
		    document.getElementById("PhotoButton").style.color = "green";
		    alert("fileuploaded");
		  });
</script>

