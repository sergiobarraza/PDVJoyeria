<?php
if (isset($_GET['prenda'])) {
		$idprenda = $_GET['prenda'];
	}
	$pageSecurity = array("admin");
require "config/security.php";
include('header.php');
include('Trabajos/conexion.php');
try {
	$sql0= "SELECT nombre_prenda from prenda where id_prenda = $idprenda;";
	$result0 = mysqli_query($con, $sql0);
	$row0 = $result0->fetch_assoc();
	$prenda=$row0["nombre_prenda"];
	$sql = "SELECT prenda_proceso.proceso, prenda_proceso.id, prenda.nombre_prenda, proceso.nombre_proceso, prenda_proceso.tiempo_estimado, prenda_proceso.costo
 	from prenda_proceso
	join prenda on prenda_proceso.prenda = prenda.id_prenda
	join proceso on prenda_proceso.proceso = proceso.id_proceso
	where prenda_proceso.prenda = $idprenda;
	";
	$result = mysqli_query($con, $sql);
	$rows = $result->num_rows;
	
	
		
} catch (Exception $error) {
	echo $error;;
}
?>

<!--Nuevo Linea-->
			    <div class="card mb-3" id="nuevaLinea">
			        <div class="card-header">
			        	<i class="fa fa-area-chart"></i> Procesos de <?php echo $prenda?> <a href = "trabajos_nuevoproceso.php?prenda=<?php echo $idprenda;?>" class="btn btn-primary float-right">Nuevo Proceso</a>
			        </div>
			        <div class="card-body">
			        	<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
		              		<thead>
				                <tr>
				                	<td>Prenda</td>
				                	<td>Proceso</td>
				                	<td>Horas</td>
				                	<td>Minutos</td>
				                	<td>Segundos</td>
				                	<td>Costo</td>
				                	<td>Actualizar</td>
				            </thead>
				            <tbody>
					            	
					            	
					            	<?php
					            		for ($i=0 ; $i < $rows ; $i++){
											$row = $result->fetch_assoc();
											$Tiempo = $row["tiempo_estimado"];
											$Horas = intval($Tiempo / 3600);
											$Minutos = intval(($Tiempo % 3600)/60);
											$Segundos = $Tiempo % 60;
											echo "<tr><form action='trabajos_prendaproceso_update.php' method='Post'>";
											echo "<td style='padding: 0;'><input type='text' name='id' value='".$prenda." ' style = 'border:0; background: transparent; margin: 0; width: 100%; height: 48px; display: block; text-align: center;' readonly></td>";
											echo "<td style='padding: 0;'><input type='text' name='idproceso' style='display:none;' value='".$row['id']."'><input type='text' name='idprenda' style='display:none;' value='".$idprenda."'><input type='text' name='nombre' value='".$row["nombre_proceso"]."' style = 'border:0; background: transparent; margin: 0; width: 100%; height: 48px; display: block; text-align: center;' readonly></td>";
											echo "<td style='padding: 0;'><input type='text' name='tiempoH' value=' ".$Horas."' style = 'border:0; background: transparent; margin: 0; width: 100%; height: 48px; display: block; text-align: center;' required class='input-number2'></td>";
											echo "<td style='padding: 0;'><input type='text' name='tiempoM' value=' ".$Minutos."' style = 'border:0; background: transparent; margin: 0; width: 100%; height: 48px; display: block; text-align: center;' required class='input-number2'></td>";
											echo "<td style='padding: 0;'><input type='text' name='tiempoS' value=' ".$Segundos."' style = 'border:0; background: transparent; margin: 0; width: 100%; height: 48px; display: block; text-align: center;' required class='input-number2'></td>";
											echo "<td style='padding: 0;'><input type='text' name='costo' value='".$row["costo"]."' style = 'border:0; background: transparent; margin: 0; width: 100%; height: 48px; display: block; text-align: center;' required class='input-number2'></td>";
											echo "<td style='padding: 0;'><button type='success' class='btn btn-success mt-1'>Actualizar</button>";
											echo "</form></tr>";
										}
					            	?>
				            </tbody>		
			        	</table>
			        </div>
			  	</div>
		  	</div>
<?php
	include ('footer.php');
?>
