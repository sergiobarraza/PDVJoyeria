<?php
  require "../config/common.php";
  require "../config/database.php";

  $pageSecurity = array("venta", "admin", "supervisor");
  require "../config/security.php";

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
      createTransaction($_SESSION['almacen'], $data['monto'], $data['concepto'], "Efectivo");
      echo "La cantidad de $".$data['monto']." ha sido depositada exitosamente.";
    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }

  if(isset($_POST['withdraw'])){
    try{
      $data = $_POST['withdraw'];
      createTransaction($_SESSION['almacen'], -$data['monto'], $data['concepto'], "Efectivo");
      echo "La cantidad de $".$data['monto']." ha sido retirada exitosamente.";
    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }
?>