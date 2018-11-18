<?php
  require('seguridad.php');
?>
<!DOCTYPE html>
<html>
<title>Joyeria Claro</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="css.css">
<body class="w3-light-grey">
  <div class="w3-bar w3-black w3-hide-small">
    <a href="logout.php" class="w3-bar-item w3-button">Cerrar sesión</a>
    <a href="index.php" class="w3-bar-item w3-button">Panel de control</a>
    <a onclick="borrarHistorial()" class="w3-bar-item w3-button w3-right"><i class="fa fa-trash"></i></a>
  </div>

  <div class="w3-content">
    <header class="w3-container w3-center w3-white">
      <h1 class="w3-xxxlarge"><b>JOYERIA CLARO'S</b></h1>
    </header>
    <div class="w3-row w3-padding w3-border">
      <div class="w3-col l12 s12">
        <div class="w3-container w3-white w3-margin w3-padding-large">
          <div class="w3-center">
            <h3>Historial de procesos</h3>
              <div class="historial">
                <table>
                  <thead>
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Prendas</th>
                      <th>Proceso</th>
                      <th>Operador</th>
                      <th>Tiempo Esp</th>
                      <th>Tiempo total</th>
                      <th>Nombre Cliente</th>
                      <th>Imagen<th>
                    </tr>
                  </thead>
                  <tbody>
                     
                      <?php
                        include 'conexion.php';
                        $sql = "SELECT h.folio, fecha, pa.nombre_prenda, po.nombre_proceso, operador, tiempo_esperado, tiempo_total, nombre_cliente, imagen FROM historial h JOIN prenda pa ON h.prenda = pa.id_prenda JOIN proceso po ON h.proceso = po.id_proceso ORDER BY h.folio ASC;";
                        $result = mysqli_query($con, $sql);
                        $rows = $result->num_rows;
                        for ($i=0 ; $i < $rows ; $i++){
                          $row = $result->fetch_assoc();
                          echo "<tr>";
                          echo "<td>".$row["folio"]."</td>";
                          echo "<td>".$row["fecha"]."</td>";
                          echo "<td>".$row["nombre_prenda"]."</td>";
                          echo "<td>".$row["nombre_proceso"]."</td>";
                          echo "<td>".$row["operador"]."</td>";
                          echo "<td>".$row["tiempo_esperado"]."</td>";
                          echo "<td>".$row["tiempo_total"]." Seg</td>";
                          echo "<td>".$row["nombre_cliente"]."</td>";
                          if ($row["imagen"]!="") {
                            echo '<td><a href="'.$row["imagen"].'">IMG</a></td>';

                          }else{
                            echo '<td></td>';
                          }
                          echo "</tr>";

                        }
                      ?>
                  
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  // Toggle between hiding and showing blog replies/comments
  document.getElementById("myBtn").click();
  function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
      } else { 
          x.className = x.className.replace(" w3-show", "");
      }
  }

  function likeFunction(x) {
      x.style.fontWeight = "bold";
      x.innerHTML = "✓ Liked";
  }

  function borrarHistorial(){
      var r = confirm("¿Está seguro que desea borrar TODO el contenido del historial?");
      if (r == true) {
        window.location.href = "borrarHistorial.php";
      }
  }
  </script>

</body>
</html>

