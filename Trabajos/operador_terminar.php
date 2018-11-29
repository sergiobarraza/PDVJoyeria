<?php
  include 'conexion.php';
	$folio = $_POST["folio2"];
  
  $idasignado=$_POST["idasignado"];
  
  $actual = date("Y-m-d H:i:s") ;
  $sql="SELECT * FROM asignado where idAsignado=$idasignado;";
  $result = mysqli_query($con, $sql);
  $row3 = $result->fetch_assoc();
  $fila = $row3["idFila"];
  $operador = $row3["Operador"];
  $inicio = $row3["fechaInicio"];
  $sql2= "INSERT INTO terminado (idFila, operador, fechafin, fechaInicio) values ($fila, '$operador', '$actual','$inicio');";
  //echo $sql2."<br>";
  $result2 = mysqli_query($con, $sql2);
	$sql3 = "DELETE FROM asignado where idasignado =$idasignado;";
  $result3 = mysqli_query($con, $sql3);

  //CALCULA CUANTO LLEVA ABONADO PARA VER EL ESTADO A PONER
  $sql4 = "SELECT  SUM(Transaccion.monto), Trabajo.precio FROM transaccion_trabajo join Transaccion on transaccion_trabajo.idTransaccion =Transaccion.idTransaccion join Trabajo on transaccion_trabajo.idTrabajo = Trabajo.idTrabajo where transaccion_trabajo.idTrabajo = $folio";
      $Result4 = mysqli_query($con, $sql4);
      $row4 = $Result4 -> fetch_assoc();
      $TotalabonadoBD = $row4["SUM(Transaccion.monto)"];
      $TotalTrabajo = $row4["precio"];
    if ($TotalTrabajo > $TotalabonadoBD){
      echo "Pasa a estado 2 = terminado color morado";
      $sql5 = "UPDATE Fila SET estado = 2 where idFolio = $folio;";
      //echo $sql4."<br>";
      $result5 = mysqli_query($con, $sql5);
    }else{
      $SQLupdate = "UPDATE Fila set estado = 3 where idFolio = $folio;";
      $ResultUPDATE = mysqli_query($con, $SQLupdate);
      //echo $SQLupdate;
    }
  header("Refresh:0; url=operador.php");

 ?>
