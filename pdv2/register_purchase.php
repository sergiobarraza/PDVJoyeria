<?php
  require "../config/common.php";
  require "../config/database.php";

  $connection = new PDO($dsn, $username, $password, $options);
  $data = $_POST['register_purchase'];

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['register_purchase'])){
    function createFolio($idAlmacen, $idPersona, $estado) {
      global $connection, $data;

      $folio = array(
        "idAlmacen" => $idAlmacen,
        "idPersona" => $idPersona,
        "estado" => $estado
      );

      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Folio",
        implode(", ", array_keys($folio)),
        ":" . implode(", :", array_keys($folio))
      );

      $statement = $connection->prepare($sql);
      $statement->execute($folio);
      return true;
    }

    function createTrasaction($concepto, $folioId){
      global $connection, $data;
      $paymentType = implode(", ", array_keys($data["payment_type"]));

      $transaccion = array(
        "monto" => $data['monto'],
        "concepto" => $concepto,
        "idFolio" => $folioId,
        "fecha" => $data['fecha'],
        "tipoDePago" => $paymentType
      );

      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Transaccion",
        implode(", ", array_keys($transaccion)),
        ":" . implode(", :", array_keys($transaccion))
      );

      $statement = $connection->prepare($sql);
      $statement->execute($transaccion);
      return true;
    }

    function createInventario($folioId){
      global $connection, $data;
      foreach($data['productos'] as $producto){
        $inventario = array(
          "idProducto" => intval($producto["id"]),
          "tipo" => - $producto["qty"],
          "fecha" => $data['fecha'],
          "idFolio" => $folioId
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Inventario",
          implode(", ", array_keys($inventario)),
          ":" . implode(", :", array_keys($inventario))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($inventario);
      }
    }

    try {
      if($data['order_type'] == "defaultCheck1" || $data['order_type'] == "defaultCheck3"){
        //Mostrador
        createFolio(1, $data['idPersona'], "Compra a Mostrador");
        $folioId = $connection->lastInsertId();

        createInventario($folioId);
        createTrasaction("Venta", $folioId);
      }elseif ($data['order_type'] == "defaultCheck2") {
        //Apartado
        createFolio(1, $data['idPersona'], "Apartado");
        $folioId = $connection->lastInsertId();
        createInventario($folioId);
        createTrasaction("Abono", $folioId);

        $cobranza = array(
          "monto" => $data['abono'],
          "idFolio" => $folioId,
          "fecha" => $data['fecha']
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Cobranza",
          implode(", ", array_keys($cobranza)),
          ":" . implode(", :", array_keys($cobranza))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($cobranza);
      }

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>

