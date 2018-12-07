<?php 
$pageSecurity = array("admin");
require "config/security.php";
	$fecha = date("Y-m-d");
	$tipo = $_POST["tipo"];
	//echo $tipo;
	$sucursal = $_POST["sucursal"];
	$linea = $_POST["linea"];
	
	$dedia = $_POST["dedia"];
	$demes = $_POST["demes"];
	$deano = $_POST["deano"];

	$adia = $_POST["adia"];
	$ames = $_POST["ames"];
	$aano = $_POST["aano"];

	if ($tipo == 2) { //Si es reporte de venta
		if (isset($_POST['sucursalcheck']) && $_POST['sucursalcheck'] == 'Yes' && isset($_POST['checkhasta']) && $_POST['checkhasta'] == 'Yes') //Si esta seleccionado el check de sucursal y de hasta
		{
		    $url ="pdf/reportes_ventas_fechas_sucursal.php?sucursal=".$sucursal."&ano=".$deano."&mes=".$demes."&dia=".$dedia."&Hano=".$aano."&Hmes=".$ames."&Hdia=".$adia;
		}
		elseif (isset($_POST['sucursalcheck']) && $_POST['sucursalcheck'] == 'Yes'  ) //Si esta seleccionado el check de sucursal
		{
		    $url ="pdf/reporteventas.php?sucursal=".$sucursal."&ano=".$deano."&mes=".$demes."&dia=".$dedia;
		}
		elseif (isset($_POST['checkhasta']) && $_POST['checkhasta'] == 'Yes')  // Si no esta seleccionado el filtro de sucursal y esta seleccionado el filtro de fecha
		{
		   $url ="pdf/reportes_ventas_fechas_general.php?&ano=".$deano."&mes=".$demes."&dia=".$dedia."&Hano=".$aano."&Hmes=".$ames."&Hdia=".$adia;
		}
		else{
			$url ="pdf/reportes_ventas_general.php?&ano=".$deano."&mes=".$demes."&dia=".$dedia;
		}

    		
    }
    elseif($tipo ==1){
    	if (isset($_POST['sucursalcheck']) && $_POST['sucursalcheck'] == 'Yes') //Si esta seleccionado el check de sucursal
		{
		    $url ="pdf/reportes_conteo.php?sucursal=".$sucursal;
		}
		else // Si no esta selecciona es un reporte de venta general de todas las sucursales
		{
		   $url ="pdf/reportes_conteo_general.php";
		}
    }
    elseif ($tipo==3) {
		if (isset($_POST['sucursalcheck']) && $_POST['sucursalcheck'] == 'Yes' && isset($_POST['lineacheck']) && $_POST['lineacheck'] == 'Yes') //Si esta seleccionado el check de sucursal y el check de linea
		{
		    $url = "pdf/reportes_inventario_linea_sucursal.php?sucursal=".$sucursal."&linea=".$linea;
		}
		elseif(isset($_POST['sucursalcheck']) && $_POST['sucursalcheck'] == 'Yes')// Esta seleccionado el puro filtro de sucursal
		{
		    $url = "pdf/reportes_inventario_sucursal.php?sucursal=".$sucursal;
		}
		elseif(isset($_POST['lineacheck']) && $_POST['lineacheck'] == 'Yes')// Esta seleccionado el puro filtro de sucursal
		{
		    $url = "pdf/reportes_inventario_linea.php?linea=$linea";
		}
		else{
			$url = "pdf/reportes_inventario_general.php";
		}    	
    }

	
	if (isset($_POST['lineacheck']) && $_POST['lineacheck'] == 'Yes') 
	{
	    
	}
	else
	{
	    
	}
	if (isset($_POST['checkhasta']) && $_POST['checkhasta'] == 'Yes') 
	{
	    
	}
	else
	{
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
    	<?php 

    		echo "window.open('".$url."', '_blank'); // will open new tab on window.onload";
    	
    	 ?>
         //window.open("pdf/reporteventas.php", "_blank"); // will open new tab on window.onload
         location.href= "reportes.php";
    }
	</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  

</body>

</html>
