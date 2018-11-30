<?php 
	$fecha = date("Y-m-d");
	echo $fecha
	;
	$tipo = $_POST["tipo"];
	$sucursal = $_POST["sucursal"];
	$linea = $_POST["linea"];
	
	$dedia = $_POST["dedia"];
	$demes = $_POST["demes"];
	$deano = $_POST["deano"];

	$adia = $_POST["adia"];
	$ames = $_POST["ames"];
	$aano = $_POST["aano"];

	echo "De: ";
	echo $deano."-".$demes."-".$dedia;
	echo "<br><br>";
	
	if (isset($_POST['sucursalcheck']) && $_POST['sucursalcheck'] == 'Yes') 
	{
	    echo "Filtro Sucursal<br>Value Sucursal: ";
	    echo $sucursal;
	    echo "<br><br>";
	}
	else
	{
	    echo "No filtro sucursal";
	    echo "<br>";
	}
	if (isset($_POST['lineacheck']) && $_POST['lineacheck'] == 'Yes') 
	{
	    echo "Filtro Linea <br>Value Linea: ";
	    echo $linea;
	    echo "<br><br><br>";
	}
	else
	{
	    echo "No filtro linea";
	    echo "<br><br>";
	}
	if (isset($_POST['checkhasta']) && $_POST['checkhasta'] == 'Yes') 
	{
	    echo "Filtro HASTA";
	    
	    $fechahasta= $aano."-".$ames."-".$adia;
	    echo $fechahasta;
	    echo "<br><br>";
	}
	else
	{
	    echo "No filtro hasta<br><br>";
	}
?>
<!DOCTYPE html>
<html>
<head>

	<title></title>
</head>	
<body>
	<script>

    window.onload = function(){
         //window.open("pdf/reporteventas.php", "_blank"); // will open new tab on window.onload
         //location.href= "reportes.php";
    }
	</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  

</body>

</html>
