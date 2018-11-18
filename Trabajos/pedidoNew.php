<?php
	include 'conexion.php';
	
  	//Codigo para la imagen
	/*$target_dir = "img/";
	$target_file = $target_dir . basename($_FILES["archivo"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	echo $target_file;
	echo "Tipo de archivo = ".$imageFileType. "<br>";
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["archivo"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}

	// Check file size
	if ($_FILES["archivo"]["size"] > 5000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 3;

	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 4;
	}
	$fileName = $target_dir . $folio . "." . $imageFileType;

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk != 1) {
	    echo "Sorry, your file was not uploaded.";
	    echo $uploadOk;
	    $fileName = "";

	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $fileName)) {
	        echo "The file $fileName has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	        $fileName = "";
	    }
	}*/
	

	
	$nombreCliente = $_POST["nombreCliente"];
//	$folio = $_POST["folio"];
	$pp = $_POST["tablaName"];
	$operador = $_POST["operador_select"];
	$urgencia = $_POST["urgencia_select"];
	$tiempo_estimado = $_POST["tiempoEstimado"];
	$comentario = $_POST["comentario"];
	$fecha = date("Y-m-d H:i:s");
	$precio = 0;
	$cliente =1;
	$prenda_proceso= explode(",",$pp);
	$mod = count($prenda_proceso);
	$mod= $mod/3;
	
	if ($mod<1) 
	{
		header("Refresh:0; url=index.php?error=NoProcess");
		exit;
	}	
	else
	{

		//El FOLIO
		$sqlTrabajo = "INSERT into Trabajo (tiempo_estimado, precio, idCliente, comentario) VALUES ($tiempo_estimado, $precio, $cliente, '$comentario');";
		
		$resultTrabajo = mysqli_query($con, $sqlTrabajo);	
		$sqlFolio = "SELECT idTrabajo from Trabajo order by cast(idTrabajo as unsigned)desc limit 1;";
		$resultFolio = mysqli_query($con, $sqlFolio);
		$FolioTrabajo = $resultFolio->fetch_assoc();
		$FolioTrabajoNuevo = $FolioTrabajo["idTrabajo"];

		//La FILA
		$x = 1;
		$y = 2;

		for ($i=0 ; $i < $mod ; $i++){
			$prenda = $prenda_proceso[$x];
			$proceso = $prenda_proceso[$y];	
			$sqlPrendaProceso = "SELECT id from Prenda_proceso where prenda= $prenda and proceso = $proceso limit 1";
			$resultPrendaProceso = mysqli_query($con, $sqlPrendaProceso);
			$rowPrendaProceso = $resultPrendaProceso -> fetch_assoc();
			$prenda_procesoVar = $rowPrendaProceso["id"];
			
			$sqlFila = "INSERT into Fila (idFolio, prenda_proceso, urgencia, fecha, estado) values ($FolioTrabajoNuevo, $prenda_procesoVar, $urgencia, '$fecha', 0);";
			echo $sqlFila;
			$resultFila = mysqli_query($con, $sqlFila);

			//$sql = "INSERT INTO pedido (folio, nombre_cliente, operador, prenda, proceso, comentario, tiempoEstimado, urgencia, fecha, imagen) VALUES ($folio, '$nombreCliente', '$operador', $prenda, $proceso, '$comentario', $tiempo_estimado, $urgencia, '$fecha','$fileName');";
			
			//$result = mysqli_query($con, $sql);
			$x = $x+3;
			$y = $y+3;
		}
	}	
	header("Refresh:0; url=index.php?folio=$FolioTrabajoNuevo");
?>