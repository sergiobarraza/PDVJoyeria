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
		    <a href="#" class="w3-bar-item w3-button w3-right"><i class="fa fa-info-circle"></i></a>
		</div>

		<div class="w3-content">
		    <header class="w3-container w3-center w3-white">
		   		<h1 class="w3-xxxlarge"><b>JOYERIA CLARO'S</b></h1>
		    </header>
		</div>
        <form action="pedido2.php" method="post" enctype="multipart/form-data">
            <input type="file" accept="image/*" capture="camera" name="archivo" id="PhotoPicker" style="display: none;">
            <i class="fa fa-camera" id="PhotoButton" style="font-size: 32px; color:black; margin: 20px; "></i><br>

    		<input type="submit" value="Upload Image" name="submit">



        </form>

	</body>
	<script type="text/javascript">
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

		  });

	</script>
</html>