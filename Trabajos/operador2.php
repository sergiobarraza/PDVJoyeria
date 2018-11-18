<?php
  //require('seguridad.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Joyeria Claro</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <meta http-equiv="refresh" content="10;url=operador2.php">-->
    <link rel="stylesheet" href="w3.css">
    <link type="text/css" rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <style>
    #folio2{
      padding: 1px;           
      border: 1px solid activeborder; 
    }
    #folio2{
        width: 100%;   
        text-align:center;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    #folio2{
      border: none;
    }
    </style>
  </head>
  <body class="w3-light-grey">
    <div class="w3-bar w3-black w3-hide-small">
      <a href="logout.php" class="w3-bar-item w3-button">Cerrar sesión</a>
      <a href="#" class="w3-bar-item w3-button w3-right"><i class="fa fa-info-circle"></i></a>
    </div>

    <div class="w3-content">
      <header class="w3-container w3-center w3-white">
        <h1 class="w3-xxxlarge"><b>JOYERIA CLARO'S</b></h1>
      </header>
      <div class="w3-row w3-padding w3-border">
        <!-- PROCESOS EN CURSO -->
        <div class="w3-col l12 s12">
          <div class="w3-container w3-white w3-margin w3-padding-large">
            <div class="w3-center">
              <!-- TABLAS -->
              <div class="colas">
                <?php
                  include 'conexion.php';
//                  $sql = "SELECT * FROM usuario WHERE tipo='operador';";
                  $sql = "SELECT * FROM usuario WHERE tipo='operador' AND NOT usuario='hechuras';";

                  $result = mysqli_query($con, $sql);
                  $rows = $result->num_rows;
                  for ($i=0 ; $i < $rows ; $i++){
                    $row = $result->fetch_assoc();
                    $nombre= $row["nombre"];
                    $usuario= $row["usuario"];
                    ?>
                      <div class="colaOperador">
                        <table style="min-height: 250px; table-layout: fixed;">
                          <thead>
                            <tr>
                              <th colspan="2">
                                <?php 
                                  echo $nombre;
                                  $sql3 = "SELECT folio FROM cola WHERE operador= '$usuario' ORDER BY urgencia DESC, folio ASC limit 1";
                                  $result3 = mysqli_query($con, $sql3);
                                  $row3 = $result3->fetch_assoc();
                                  $folioo= $row3['folio']; 
                                  $sql2="SELECT DISTINCT pedido.folio, pedido.nombre_cliente, pedido.operador, prenda.nombre_prenda, proceso.nombre_proceso, pedido.tiempoEstimado, pedido.urgencia, pedido.comentario FROM pedido JOIN prenda ON pedido.prenda = prenda.id_prenda JOIN prenda_proceso ON pedido.prenda = prenda_proceso.prenda JOIN proceso ON pedido.proceso = proceso.id_proceso where folio=$folioo ORDER BY prenda.id_prenda;";
                                  $result2 = mysqli_query($con, $sql2);
                                  if(!$result2){
                                    $rows2=0;
                                    $penultimo=0;
                                  }else{
                                    $rows2=$result2->num_rows;
                                    $penultimo=$rows2-1;
                                  }
                                ?>
                              </th>
                            </tr>
                          </thead>
                          <tbody>


                            <form method='post' action="terminar.php">
                              <?php
                                if ($rows2 != 0){
                                  $prendaActual = "";
                                  for($j=0 ; $j<$rows2 ; $j++){
                                    $row2 = $result2->fetch_assoc();
                                    if ($usuario == $row2["operador"]){
                                      $prendaAnterior= $prendaActual;
                                      $prendaActual = $row2["nombre_prenda"];

                                      if ($j==0) {
                                        echo "<tr style='border-bottom:solid 1px; font-size:20px; background-color: #c9c9c9';'><td sytle= 'background-color;': #c9c9c9'>Folio:</td><td><input type='text' style='background-color: #c9c9c9'; name='folio2' id='folio2' readOnly value='";
                                        echo $row2["folio"];
                                        echo "'></td></tr>"; 

                                        echo "<tr style='border-bottom:solid 3px; font-size:20px; background-color: #c9c9c9';><td>";
                                        echo "Cliente:</td><td>";
                                        echo $row2["nombre_cliente"];
                                        echo "</td></tr>" ;
                            
                                      }
                                      if ($prendaActual != $prendaAnterior){
                                        echo "<tr style='text-align:center; background-color:#6bbbe0; border-bottom:solid 1px; font-size:22px;'><td colspan='2'>";
                                        echo $row2["nombre_prenda"]."</td></tr>";
                                      } 

                                      echo "<tr><td style='font-size:20px; text-align:left;' colspan='2'>• ".$row2["nombre_proceso"]."</td></tr>";
                                      
                                      if ($j==$penultimo){
                                        echo "<tr style='border-top:solid 1px black; background-color: #c9c9c9';'><td colspan='2' style='text-align:left; font-size:20px;'> Comentarios: ".$row2["comentario"]." </td></tr>";
                                      
                                        echo "<tr style='border-top:solid 1px black; height:40px; '><td colspan='2'><input  style='margin:5px auto; font-size:20px;width: 60%; text-align:center;' class='button-aceptar' value='TERMINAR' type='submit' onclick='terminarproc(".$row2['folio'].")';></td></tr>";
                                      }
                                    }
                                  }
                                }
                              ?>  
                              
                            </form>  

                            <?php
                              $sqlP="SELECT DISTINCT folio, nombre_cliente FROM pedido WHERE operador= '$usuario' AND folio != $folioo ORDER BY urgencia DESC,folio ASC ;";
                              $resultP = mysqli_query($con, $sqlP);
                              if ($resultP) $rowsP=$resultP->num_rows; 
                              //echo "rowsP: ".$rowsP;
                              if ($resultP){
                            ?>
                            <tr>
                              <td colspan='2' style="background-color: white; color:white;  font-size: 20px; border-right:solid 5px white; border-left:solid 6px white; border-top:solid 6px black;"> <?php if ($resultP)echo "(".$rowsP.")";?></td>
                            </tr>

                            <tr>
                              <td colspan='2' style="background-color: #050e51; color:white;  font-size: 20px;">Próximos procesos <?php echo "(".$rowsP.")"?></td>
                            </tr>
                            <?php
                              
                                for($x=0 ; $x<$rowsP ; $x++){
                                  $rowP = $resultP->fetch_assoc();
                                  $folioP = $rowP["folio"];
                                  echo "<tr style='background-color: #c9c9c9; border-top:solid 1px;'>
                                    <td style='text-align:center; font-size:18px;' colspan='2'>Folio: ".$folioP."</td>
                                    </tr>";

                                    echo "<tr style='background-color: #c9c9c9; border-top:solid 1px;'>
                                    <td style='text-align:center; font-size:18px;' colspan='2'>Cliente: ".$rowP["nombre_cliente"]."</td>
                                    </tr>";


                                  $sqlY="SELECT DISTINCT prenda.nombre_prenda, proceso.nombre_proceso,  pedido.comentario FROM pedido JOIN prenda ON pedido.prenda = prenda.id_prenda JOIN prenda_proceso ON pedido.prenda = prenda_proceso.prenda JOIN proceso ON pedido.proceso = proceso.id_proceso WHERE operador= '$usuario' AND folio = $folioP ORDER BY urgencia DESC,folio ASC ;";
                                  $resultY = mysqli_query($con, $sqlY);
                                  $rowsY=$resultY->num_rows;
                                  $prendaActualY = "";
                                  for ($y=0 ; $y<$rowsY ; $y++){
                                      $rowY = $resultY->fetch_assoc();
                                      $prendaAnteriorY= $prendaActualY;
                                      $prendaActualY = $rowY["nombre_prenda"];

                                      if ($prendaActual != $prendaAnterior){
                                        echo "<tr style='text-align:center; background-color:#6bbbe0; border-bottom:solid 1px; font-size:18px;'><td colspan='2'>";
                                        echo $rowY["nombre_prenda"]."</td></tr>";
                                      } 

                                      echo "<tr><td style='font-size:18px; text-align:left;' colspan='2'>• ".$rowY["nombre_proceso"]."</td></tr>";

                                  }
                                }
                              }
                            ?>
                            
                           
                          </tbody>
                        </table>
                      </div>
                    <?php
                  }
                ?>

                <!--Hechuras-->
                <div class="colaOperador">

                <?php
                  include 'conexion.php';
//                  $sql = "SELECT * FROM usuario WHERE tipo='operador';";
                  $sql = "SELECT * FROM usuario WHERE tipo='operador' AND usuario='hechuras';";

                  $result = mysqli_query($con, $sql);
                  $rows = $result->num_rows;
                  for ($i=0 ; $i < $rows ; $i++){
                    $row = $result->fetch_assoc();
                    $nombre= $row["nombre"];
                    $usuario= $row["usuario"];
                    ?>
                    <table style="min-height: 250px; table-layout: fixed;">
                                      <thead>
                                        <tr>
                                          <th colspan="2">
                      
                                <?php 
                                  echo $nombre;
                                  $sql3 = "SELECT folio FROM cola WHERE operador= '$usuario' ORDER BY urgencia DESC, folio ASC ";
                                  $result3 = mysqli_query($con, $sql3);
                                  $rows3=$result3->num_rows;


                                  for($k=0 ; $k<$rows3 ; $k++){

                                  $row3 = $result3->fetch_assoc();
                                  $folioo= $row3['folio'];
                                   
                                  if ($k>0) {

                                  echo '
                                    <table style="min-height: 250px; table-layout: fixed;">
                                      <thead>
                                        <tr>
                                          <th colspan="2">';

                                          echo $nombre;
                                  }
                                  $sql2="SELECT DISTINCT pedido.folio, pedido.nombre_cliente, pedido.operador, prenda.nombre_prenda, proceso.nombre_proceso, pedido.tiempoEstimado, pedido.urgencia, pedido.comentario FROM pedido JOIN prenda ON pedido.prenda = prenda.id_prenda JOIN prenda_proceso ON pedido.prenda = prenda_proceso.prenda JOIN proceso ON pedido.proceso = proceso.id_proceso where folio=$folioo ORDER BY prenda.id_prenda;";
                                  $result2 = mysqli_query($con, $sql2);
                                  if(!$result2){
                                    $rows2=0;
                                    $penultimo=0;
                                  }else{
                                    $rows2=$result2->num_rows;
                                    $penultimo=$rows2-1;
                                  }
                                ?>
                              </th>
                            </tr>
                          </thead>
                          <tbody>


                            <form method='post' action="terminar.php">
                              <?php
                                if ($rows2 != 0){
                                  $prendaActual = "";
                                  for($j=0 ; $j<$rows2 ; $j++){
                                    $row2 = $result2->fetch_assoc();
                                    if ($usuario == $row2["operador"]){
                                      $prendaAnterior= $prendaActual;
                                      $prendaActual = $row2["nombre_prenda"];

                                      if ($j==0) {
                                        echo "<tr style='border-bottom:solid 1px; font-size:20px; background-color: #c9c9c9';'><td sytle= 'background-color;': #c9c9c9'>Folio:</td><td><input type='text' style='background-color: #c9c9c9'; name='folio2' id='folio2' readOnly value='";
                                        echo $row2["folio"];
                                        echo "'></td></tr>"; 

                                        echo "<tr style='border-bottom:solid 1px; font-size:20px; background-color: #c9c9c9';><td>";
                                        echo "Cliente:</td><td>";
                                        echo $row2["nombre_cliente"];
                                        echo "</td></tr>" ;   

                                        echo "<tr style='border-bottom:solid 3px; font-size:20px; background-color: #c9c9c9';><td>";
                                        echo "Operador:</td><td>";
                                        $user=substr (  $row2["comentario"] , 0 ,8 );
                                        echo $user;
                                        echo "</td></tr>" ;  

                                      }
                                      if ($prendaActual != $prendaAnterior){
                                        echo "<tr style='text-align:center; background-color:#6bbbe0; border-bottom:solid 1px; font-size:22px;'><td colspan='2'>";
                                        echo $row2["nombre_prenda"]."</td></tr>";
                                      } 

                                      echo "<tr><td style='font-size:20px; text-align:left;' colspan='2'>• ".$row2["nombre_proceso"]."</td></tr>";
                                      
                                      if ($j==$penultimo){
                                        $lenghtstring =strlen($row2["comentario"])-10; 
                                        $comment=substr (  $row2["comentario"] , 10 ,$lenghtstring );
                                        echo "<tr style='border-top:solid 1px black; background-color: #c9c9c9';'><td colspan='2' style='text-align:left; font-size:20px;'> Comentarios: ".$comment." </td></tr>";
                                      
                                        echo "<tr style='border-top:solid 1px black; height:40px;'><td colspan='2'><input  style='margin:5px auto; font-size:20px; width:60%;' class='button-aceptar' type='submit' value='TERMINAR' onclick='terminarproc(".$row2['folio'].")';></td></tr>";
                                      }
                                    }
                                  }
                                }
                              ?>  
                            </form>  

                            <?php
                          } //cierre del for
                            ?>
                            
                           
                          </tbody>
                        </table>
                      </div>
                    <?php
                  }
                ?>

              </div>
            </div>
          </div>
        </div>
              

      </div>
    </div>
    <footer class="w3-container w3-dark-grey" >
      <p>Powered by BARRAZA.MX</p>
    </footer>


  </body>
</html>


<script type="text/javascript">


</script>
 

