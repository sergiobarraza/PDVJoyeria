<?php
	include 'conexion.php';
	
	$pago = $_POST["apagar"];
	$folio = $_POST["folioName"];
	$tipopago = $_POST["tipopago"];
	$restante = $_POST["precioRestante"];
	//echo $pago ." ". $folio. " ".$tipopago;
	$fecha = date("Y-m-d H:i:s");
	$sqlTransaccion = "INSERT INTO Transaccion ( monto, concepto, tipodePago, fecha, idAlmacen) values ($pago,'Trabajo','$tipopago', '$fecha', 1 );"; 
	//echo $sqlTransaccion;
	$resultTransaccion = mysqli_query($con, $sqlTransaccion);
	$sqlTransaccion1 = "SELECT idTransaccion  from Transaccion  order by idTransaccion desc limit 1;";
	$resultTransaccion1 = mysqli_query($con, $sqlTransaccion1);
	$rowTransaccion = $resultTransaccion1 ->fetch_assoc();
	$idTransaccion = $rowTransaccion["idTransaccion"];

	$sqlTT = "INSERT INTO transaccion_trabajo (idTrabajo, idTransaccion) values($folio, $idTransaccion);";
	//echo "<br>".$sqlTT;
	$resultTT = mysqli_query($con, $sqlTT);

	//Para ver si ya esta pagado el pedido
	$estadoSQL = "SELECT estado from Fila where idFolio = $folio order by estado asc limit 1";
	$estadoResult = mysqli_query($con, $estadoSQL);
	$rowResult = $estadoResult ->fetch_assoc();
	if ($rowResult["estado"] < 2) {
		echo "Aun no lo cambies";
		header("Refresh:0; url=index.php");
		exit;
	}else{
		$sql4 = "SELECT  SUM(Transaccion.monto), Trabajo.precio FROM transaccion_trabajo join Transaccion on transaccion_trabajo.idTransaccion =Transaccion.idTransaccion join Trabajo on transaccion_trabajo.idTrabajo = Trabajo.idTrabajo where transaccion_trabajo.idTrabajo = $folio";
			$Result4 = mysqli_query($con, $sql4);
			$row4 = $Result4 -> fetch_assoc();
			$TotalabonadoBD = $row4["SUM(Transaccion.monto)"];
			$TotalTrabajo = $row4["precio"];
		if ($TotalTrabajo > $TotalabonadoBD){
			echo "Aun no cambies";
			header("Refresh:0; url=index.php");
			exit;
		}else{
			$SQLupdate = "UPDATE Fila set estado = 3 where idFolio = $folio;";
			$ResultUPDATE = mysqli_query($con, $SQLupdate);
			echo $SQLupdate;
			header("Refresh:0; url=index.php");
			exit;
		}
		
	}

	header("Refresh:0; url=index.php");
?>