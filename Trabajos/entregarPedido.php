<?php
	include 'conexion.php';
	
	
	$folio = $_POST["folioName"];
	$fecha = date("Y-m-d H:i:s");
	$sql = "SELECT Fila.idFila, terminado.idTerminado, terminado.operador, terminado.fechaFin, terminado.fechaInicio, Fila.estado, terminado.idTerminado 
			from Fila 
			join terminado on Fila.idFila = terminado.idFila
			where Fila.idFolio = $folio;";
			echo $sql;
	$result = mysqli_query($con,$sql);
	$rows = $result->num_rows;
	for ($i=0 ; $i < $rows ; $i++){
		$row = $result->fetch_assoc();
		if ($row["estado"] != 3) 
		{
			echo "error";
			//header("Refresh:0; url=index.php?error=0");
			exit;
		}else
		{
			$SQLupdate = "UPDATE Fila set estado = 4 where idFolio = $folio;";
			echo $SQLupdate ."<br>";
			$ResultUPDATE = mysqli_query($con, $SQLupdate);
			$idFila = $row["idFila"];
			$operador = $row["operador"];
			$fechaFin = $row["fechaFin"];
			$fechaInicio = $row["fechaInicio"];
			$idTerminado = $row["idTerminado"];
			$SQLinsert = "INSERT INTO entregado (idFila, Operador, fechaEntrega, fechaInicio, fechaFin) values ($idFila, '$operador', '$fecha' ,'$fechaInicio','$fechaFin');";
			$Resultinsert = mysqli_query($con, $SQLinsert);
			$SQLdelete = "DELETE from terminado where idTerminado = $idTerminado;";
			$Resultdelete = mysqli_query($con, $SQLdelete);
			
		}
		
	}
	header("Refresh:0; url=index.php");
?>