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
  //echo $sql3."<br>";
  $sql4 = "UPDATE Fila SET estado = 2 where idFila = $fila;";
  //echo $sql4."<br>";
  $result4 = mysqli_query($con, $sql4);
  header("Refresh:0; url=operador.php");

 ?>
