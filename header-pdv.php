 <?php 
  if ($_SESSION['tipo'] == "admin"  ) {
        $showfullmenu = "block";
        $showhalhmenu = "block";
        
      }elseif ($_SESSION['tipo'] == "supervisor") {
        $showfullmenu = "none";
        $showhalhmenu = "block";
      }else{
        $showfullmenu = "none";
        $showhalhmenu = "none";
      }
  ?>
 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <meta name="description" content="">
  <meta name="author" content="">
  <title>pdv - Joyería Claro</title>
  <!-- Bootstrap core CSS-->
  <link href="/PDVJoyeria/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="/PDVJoyeria/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="/PDVJoyeria/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="/PDVJoyeria/css/pdv.css" rel="stylesheet">
  <!--link href="css/sb-admin.css" rel="stylesheet"-->

</head>
  <body class="bg-light">
    <nav class="navbar navbar-inverse navbar-dark bg-black p-0">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Joyería Claro</a>
        </div>
      </div>
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/PDVJoyeria/index.php" style="display: <?php echo $showfullmenu; ?>">Admin Panel</a>
        <a href="/PDVJoyeria/pdv2.php" style="display: block">Punto de Venta</a>
        <a href="/PDVJoyeria/foliosventa.php" style="display: block">Folios Venta</a> 
        <a href="/PDVJoyeria/views/apartados/index.php" style="display: block">Abonos</a>
        <a href="/PDVJoyeria/Trabajos" style="display: block">Trabajos</a>
        <a href="/PDVJoyeria/views/devoluciones/index.php" style="display: block">Devoluciones</a>
        <a href="/PDVJoyeria/cortedecaja.php" style="display: <?php echo $showhalhmenu; ?>">Corte de caja</a>  
        <a href="/PDVJoyeria/views/entradaSalidaDinero/index.php" style="display: <?php echo $showhalhmenu; ?>">Entrada y Salida de dinero</a>
        <a href="/PDVJoyeria/prestamo.php" style="display:block;">Prestamos de productos</a>
        <a href="/PDVJoyeria/logout.php" >Salir</a>
      </div>
      <span class="collapsed-menu" onclick="openNav()">&#9776;</span>
    </nav>

<div class="content-wrapper">
    <div class="container-fluid">
      

