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
      <a href="../logout.php" class="w3-bar-item w3-button">Cerrar sesión</a>
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
                            $Tiempo = $rowFila["tiempo_estimado"];
                            $Horas = intval($Tiempo / 3600);
                            $Minutos = intval(($Tiempo % 3600)/60);
                            $Segundos = $Tiempo % 60;
                              echo "<span style='font-size: 20px;line-height:18px;display: block;'>Folio: ".$rowFila["idFolio"]."</span>
                              <span style='font-size: 18px;line-height:20px;display: block;'>Cliente: ".$rowFila["idCliente"]."</span>
                              <span style='font-size: 18px;line-height:20px;display: block;'>".$Horas."H ".$Minutos."M ".$Segundos."S</span>
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
          <div  id="divOperador" class="w3-col l2 s6" style="display: none;">
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
                                  $sql3= "SELECT fila.idFolio, trabajo.idCliente, prenda.nombre_prenda, proceso.nombre_proceso, Trabajo.comentario, asignado.idAsignado 
                                    From asignado 
                                    JOIN Fila ON Fila.idFila = asignado.idfila 
                                    JOIN prenda_proceso ON prenda_proceso.id = Fila.prenda_proceso
                                    JOIN prenda ON prenda_proceso.prenda = prenda.id_prenda
                                    JOIN PROCESO ON prenda_proceso.proceso = proceso.id_proceso
                                    JOIN TRABAJO ON Fila.idFolio = Trabajo.idTrabajo
                                    where asignado.operador = '$usuario' ORDER BY asignado.fechaInicio ASC;";
                                   //ECHO $sql3; 
                                  $result3 = mysqli_query($con, $sql3);
                                  $Asignadoscount = $result3->num_rows;
                                  $row3 = $result3->fetch_assoc();
                                                                
                                ?>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <form method='post' action="operador_terminar.php">
                              <?php
                                  if($Asignadoscount > 0){
                                    echo "<tr style='border-bottom:solid 1px; font-size:20px; background-color: #c9c9c9';height:10px;'><td sytle= 'background-color: #c9c9c9'>Folio:</td><td><input type='text' style='background-color: #c9c9c9'; name='folio2' id='folio2' readOnly value='";
                                    echo $row3["idFolio"];
                                    echo "'></td></tr><input type='number' style='display:none;' name='idasignado' value='".$row3["idAsignado"]."' readonly>"; 
                                    echo "<tr style='border-bottom:solid 3px; font-size:20px; background-color: #c9c9c9';><td>";
                                    echo "Cliente:</td><td>";
                                    echo $row3["idCliente"];
                                    echo "</td></tr>" ;
                                    echo "<tr style='text-align:center; background-color:#6bbbe0; border-bottom:solid 1px; font-size:22px;'><td colspan='2'>";
                                    echo $row3["nombre_prenda"]."</td></tr>";
                                    echo "<tr><td style='font-size:20px; text-align:left;' colspan='2'>• ".$row3["nombre_proceso"]."</td></tr>";
                                  
                                    echo "<tr style='border-top:solid 1px black; background-color: #c9c9c9';'><td colspan='2' style='text-align:left; font-size:20px;'> Comentarios: ".$row3["comentario"]." </td></tr>";
                                  
                                    echo "<tr style='border-top:solid 1px black; height:40px; '><td colspan='2'><input  style='margin:5px auto; font-size:20px;width: 60%; text-align:center;' class='button-aceptar' value='TERMINAR' type='submit' onclick='terminarproc(".$row3['idFolio'].")';></td></tr>";
                                  }
                              ?>  
                              
                            </form>  

                            <?php
                              
                              if($Asignadoscount > 1){
                                $Proxprocesos = $Asignadoscount -1;
                                 echo "<tr><td colspan='2' style='background-color: white; color:white;  font-size: 20px; border-right:solid 5px white; border-left:solid 6px white; border-top:solid 6px black; height:20px;'></td></tr>";
                                  echo "<tr><td colspan='2' style='background-color: #050e51; color:white;  font-size: 20px;'>Próximos procesos(".$Proxprocesos.")</td></tr>";

                                  for ($j=1; $j < $Asignadoscount; $j++) { 
                                    $row3 = $result3->fetch_assoc();
                                    echo "<tr style='background-color: #c9c9c9; border-top:solid 1px;'>
                                    <td style='text-align:center; font-size:18px;' colspan='2'>Folio: ".$row3['idFolio']."</td>
                                    </tr>";

                                  echo "<tr style='background-color: #c9c9c9; border-top:solid 1px;'>
                                    <td style='text-align:center; font-size:18px;' colspan='2'>Cliente: ".$row3["idCliente"]."</td>
                                    </tr>";
                                  echo "<tr style='text-align:center; background-color:#6bbbe0; border-bottom:solid 1px; font-size:18px;'><td colspan='2'>";
                                  echo $row3["nombre_prenda"]."</td></tr>";
                                  echo "<tr><td style='font-size:18px; text-align:left;' colspan='2'>• ".$row3["nombre_proceso"]."</td></tr>";
                                }
                              }

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
 

