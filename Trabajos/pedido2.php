<?php
	include 'conexion.php';
	//Genera el folio 
	$sqlFolio = "SELECT DISTINCT folio FROM pedido ORDER BY folio DESC LIMIT 1;";
  	$resultFolio = mysqli_query($con, $sqlFolio);
  	$rowFolio1 = $resultFolio->fetch_assoc();

  	$sqlFolio = "SELECT DISTINCT folio FROM historial ORDER BY folio DESC LIMIT 1;";
  	$resultFolio = mysqli_query($con, $sqlFolio);
  	$rowFolio2 = $resultFolio->fetch_assoc();

  	if ($rowFolio1 < $rowFolio2)
  		$folio = $rowFolio2["folio"] + 1;
  	else
  		$folio = $rowFolio1["folio"] + 1;	

  	//Codigo para la imagen
	$target_dir = "img/";
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
	}
	

	
	$nombreCliente = $_POST["nombreCliente"];
//	$folio = $_POST["folio"];
	$pp = $_POST["tablaName"];
	$operador = $_POST["operador_select"];
	$urgencia = $_POST["urgencia_select"];
	$tiempo_estimado = $_POST["tiempoEstimado"];
	$comentario = $_POST["comentarioName"];
	$fecha = date("Y-m-d H:i:s");
	//echo "fecha: ".$fecha;
	$prenda_proceso= explode(",",$pp);

	$mod = count($prenda_proceso);
	$mod= $mod/3;
	
	  if ($mod<1) {
		//header("Refresh:0; url=index.php?error=$folio");
	}	
	else{
		$x = 1;
	$y = 2;


	
	for ($i=0 ; $i < $mod ; $i++){
		$prenda = $prenda_proceso[$x];
		$proceso = $prenda_proceso[$y];

		$sql = "INSERT INTO pedido (folio, nombre_cliente, operador, prenda, proceso, comentario, tiempoEstimado, urgencia, fecha, imagen) VALUES ($folio, '$nombreCliente', '$operador', $prenda, $proceso, '$comentario', $tiempo_estimado, $urgencia, '$fecha','$fileName');";
		echo $sql;
		$result = mysqli_query($con, $sql);
		$x = $x+3;
		$y = $y+3;
	}

	$sql2 = "INSERT INTO cola VALUES ($folio, '$operador', $tiempo_estimado, $urgencia);";
	$result = mysqli_query($con, $sql2);
	
	header("Refresh:0; url=index.php?folio=$folio");
	}
?>