<?php
  require "../config/common.php";
  require "../config/database.php";

  $pageSecurity = array("venta", "admin", "supervisor");

  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  function createTransaction($idAlmacen, $monto, $concepto, $tipoDePago){
    global $connection, $data;

    $transaccion = array(
      "idAlmacen" => $idAlmacen,
      "monto" => intval($monto),
      "concepto" => $concepto,
      "tipoDePago" => $tipoDePago,
      "fecha" => date("Y-m-d")
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Transaccion",
      implode(", ", array_keys($transaccion)),
      ":" . implode(", :", array_keys($transaccion))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($transaccion);

    return $connection->lastInsertId();
  }

  if(isset($_POST['deposit'])){
    try{
      $data = $_POST['deposit'];
      $res = [];
      $res['idTransaccion'] = createTransaction($_SESSION['almacen'], $data['monto'], $data['concepto'], "efectivo");
      $res['message'] = "La cantidad de $".$data['monto']." ha sido depositada exitosamente.";
      echo json_encode($res);
    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }

  if(isset($_POST['withdraw'])){
    try{
      $data = $_POST['withdraw'];
      $res['idTransaccion'] = createTransaction($_SESSION['almacen'], -$data['monto'], $data['concepto'], "efectivo");
      $res['message'] = "La cantidad de $".$data['monto']." ha sido retirada exitosamente.";
      echo json_encode($res);

    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }
?>
