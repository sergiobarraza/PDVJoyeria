<?php
    session_start();
    if (isset($_SESSION['username'])) {
      echo $_SESSION['username'];
    }
    require "config/database.php";
    $status="nada";
  if (isset($_GET['status'])) {
    $status = $_GET['status'];
  }
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PDV Login - Joyeria Claro</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Ingresar</div>
      <div class="card-body">
        <form method="Post" action="login_session.php">
          <div class="form-group">
            <label for="exampleInputEmail1">Usuario</label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Usuario" required name="username">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Contraseña" required name="password">
          </div>
          <div class="form-group">
            <label for="sucursal">Sucursal</label>
            <select class="form-control" id="Sucursal" name="almacen">
            <?php

                    try {
                      $connection = new PDO($dsn, $username, $password, $options );
                      $sql = "SELECT * From Almacen;";                 
                      $query = $connection->query($sql);
                      foreach($query->fetchAll() as $row) {
                      echo "<option value='".$row["idAlmacen"]."'>".$row["name"];
                    }
                      

                    } catch(PDOException $error) {
                      echo $sql . "<br>" . $error->getMessage();

                    }
                   

                    ?>  
            </select>
          </div>
          
          <button class="btn btn-primary btn-block" >Ingresar</button>
        </form>
        <div class="text-center">
          <a class="d-block small" href="forgot-password.html">Olvidaste la contraseña?</a>
          <span style="color:red; display: <?php if ($status== 'loginerror') { echo "inline-block";} else {echo "none";}?>">  Email o contraseña no válido</span>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
