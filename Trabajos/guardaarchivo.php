<?php
	//include 'conexion.php';

/*    $pp = $_POST["archivo"];


if ($_FILES['archivo']["error"] > 0)
  {
  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
  }
else {

    //echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
    //echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
    //echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
    //echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
    $UbiTemp = $_FILES['archivo']['tmp_name'];
    echo $UbiTemp;
	$UbiNueva = "img/" . $_FILES['archivo']['name'];
    move_uploaded_file($UbiTemp,$UbiNueva);
    echo "<img src = img/".$_FILES['archivo']['name'].">";

}

  /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
//<em id="__mceDel"> </em>
//echo "Guarda Archivo.php";

$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["archivo"]["name"]);
echo $target_file . "<br>";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
echo $imageFileType;
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
// Check if $uploadOk is set to 0 by an error
if ($uploadOk != 1) {
    echo "Sorry, your file was not uploaded.";
    echo $uploadOk;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_dir."7.".$imageFileType)) {
        echo "The file ". basename( $_FILES["archivo"]["name"]). " has been uploaded.";
   		echo "<img src = img/".$_FILES['archivo']['name'].">";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>