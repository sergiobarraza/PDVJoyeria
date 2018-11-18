<?php
  //require('seguridad.php');
  include 'conexion.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Joyeria Claro</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <meta http-equiv="refresh" content="10;url=operador2.php">-->
    <link rel="stylesheet" href="w3.css">
    <link type="text/css" rel="stylesheet" href="css2.css">
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
      
      <div class="w3-row w3-padding w3-border">
        <!--Filas -->
        <!--En Fila-->
          <div  id="divFilas" class="w3-col l2" >
              <div class="w3-white w3-margin">
                <div class="w3-container w3-padding w3-black">
                    <h4>Procesos en fila</h4>
                </div>
                  <div style="padding:0px ; font-size: 24px;" class="w3-ul w3-hoverable w3-white">
                    <div  class="tablaAgregados" style="height:500px;overflow-y: scroll;">
                      
                        <?php
                            $sqlFila = "SELECT Fila.idFila, Fila.idFolio, Fila.urgencia, Trabajo.idCliente, prenda.nombre_prenda,proceso.nombre_proceso, prenda_proceso.tiempo_estimado  
                            from Fila 
                            join trabajo on Fila.idFolio = Trabajo.idTrabajo
                            join prenda_proceso on Fila.prenda_proceso = prenda_proceso.id
                            join prenda on prenda_proceso.prenda = prenda.id_prenda
                            join proceso on prenda_proceso.proceso = proceso.id_proceso
                            where estado = 0                     
                            order by urgencia desc,fecha asc;";

                            $resultFila = mysqli_query($con, $sqlFila);
                            $rows = $resultFila->num_rows;
                            for ($i=0 ; $i < $rows ; $i++){
                              $rowFila = $resultFila->fetch_assoc();
                              if ($rowFila["urgencia"]==3)
                              echo '<div class="button-cancelar w3-center" onclick="Myclick('.$rowFila["idFila"].')">';
                              else
                              echo '<div class="button-aceptar w3-center" onclick="Myclick('.$rowFila["idFila"].')">';
                              echo "<span style='font-size: 20px;line-height:18px;display: block;'>Folio: ".$rowFila["idFolio"]."</span>
                              <span style='font-size: 18px;line-height:20px;display: block;'>Cliente: ".$rowFila["idCliente"]."</span>
                              <span style='font-size: 18px;line-height:20px;display: block;'>".$rowFila["tiempo_estimado"]." Segs</span>
                              <span style='font-size: 18px;line-height:20px;display: block;'>".$rowFila["nombre_prenda"]."</span>
                              <span style='font-size: 18px;line-height:20px;display: block;'>".$rowFila["nombre_proceso"]."</span>
                              </div>";
                            }
                          ?>
                      </div>
                  </div>
                </div>                            
          </div>
          <form method="Post" action="operador_assign.php" style="display: none;">
                  <input type="text" id="Filaselected" name="Filaselected">
                  <input type="text" id="Userselected" name="Userselected">
                  <input type="submit" id="AssignButton">
                </form>
           <!--En Fila-->
          <div  id="divOperador" class="w3-col l2" style="display: none;">
              <div class="w3-white w3-margin">
                <div class="w3-container w3-padding w3-black">
                    <h4>¿A qué operador?</h4>
                </div>
                  <div style="padding:0px ; font-size: 24px;" class="w3-ul w3-hoverable w3-white">
                    <div  class="tablaAgregados" style="height:500px;overflow-y: scroll;">
                      
                        <?php
                            $sqlOperador = "SELECT usuario, nombre from usuario where tipo = 'operador' and not usuario =  'hechuras'";
                            $resultOperador = mysqli_query($con, $sqlOperador);
                            $rows = $resultOperador->num_rows;

                            for ($i=1 ; $i <= $rows ; $i++){
                              $rowOperador = $resultOperador->fetch_assoc();
                              
                              echo '<div class=" w3-col s12 button-prenda prenda-'.$i.' w3-center" onclick="OperAssign('."'".$rowOperador["usuario"]."'".');">';
                              
                              echo "<span style='font-size: 18px;display: block;'> ".$rowOperador["nombre"]."</span>
                                    
                                  </div>";
                            }
                          ?>
                      </div>
                  </div>
                </div>
          </div>


        <!-- PROCESOS EN CURSO -->
        <div class="w3-col l10 s12">
          <div class="w3-container w3-white w3-margin w3-padding-large">
            <div class="w3-center">
              <!-- TABLAS -->
              <div class="colas">
                <?php
                  
                  $sql = "SELECT nombre, usuario FROM usuario WHERE tipo='operador' AND NOT usuario='hechuras';";

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
                                  $sql3= "SELECT fila.idFolio, trabajo.idCliente, prenda.nombre_prenda, proceso.nombre_proceso, Trabajo.comentarios 
                                    From asignado 
                                    JOIN Fila ON Fila.idFila = asignado.idfila 
                                    JOIN prenda_proceso ON prenda_proceso.id = Fila.prenda_proceso
                                    JOIN prenda ON prenda_proceso.prenda = prenda.id_prenda
                                    JOIN PROCESO ON prenda_proceso.proceso = proceso.id_proceso
                                    JOIN TRABAJO ON Fila.idFolio = Trabajo.idTrabajo
                                    where asignado.operador =  '$usuario' ORDER BY asignado.fechaInicio ASC limit 1;";
                                    echo $sql3;
                                  //echo $sql3;
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
  function Myclick(folio){
  //alert(folio);
  document.getElementById("divFilas").style.display = "none";
  document.getElementById("divOperador").style.display = "block";
  document.getElementById("Filaselected").value = folio;    
}

function OperAssign(usuario){
  //alert(usuario);
  document.getElementById("Userselected").value = usuario; 
  $('#AssignButton').trigger('click'); 
}

</script>
 

