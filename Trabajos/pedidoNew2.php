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
	$precio = $_POST["precioTotal"];
	$anticipo = $_POST["preciopago"];
	$cliente =1;
	$prenda_proceso= explode(",",$pp);
	$mod = count($prenda_proceso);
	$mod= $mod/3;
	$tipodepago = $_POST["tipopago"];
	echo $tipodepago;
	
?>