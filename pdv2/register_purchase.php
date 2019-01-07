<?php
  require "../config/common.php";
  require "../config/database.php";

  $connection = new PDO($dsn, $username, $password, $options);
  $data = $_POST['register_purchase'];

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['register_purchase'])){
    function createCobranza($monto){
      global $connection, $data;

      $cobranza = array(
        "monto" => $monto,
        "deudaTotal" => $data['monto_total'],
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

    function createVenta($idFolio, $idInventario, $idCobranza, $idTransaccion, $descuento, $estado) {
      global $connection, $data;

      $venta = array(
        "idFolio" => $idFolio,
        "idInventario" => $idInventario,
        "idTransaccion" => $idTransaccion,
        "idCobranza" => $idCobranza,
        "descuento" => $descuento,
        "estado" => $estado
      );

      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Venta",
        implode(", ", array_keys($venta)),
        ":" . implode(", :", array_keys($venta))
      );

      $statement = $connection->prepare($sql);
      $statement->execute($venta);
      return true;
    }


    function createFolio($idPersona, $estado) {
      global $connection, $data;

      $folio = array(
        "idPersona" => $idPersona,
        "fechaDeCreacion" => $data['fecha'],
        "idEstadoDeFolio" => $estado
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

    function createTrasaction($idAlmacen, $monto, $concepto, $paymentType){
      global $connection, $data;

      $transaccion = array(
        "idAlmacen" => $idAlmacen,
        "monto" => round($monto, 2),
        "concepto" => $concepto,
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

    function createInventario($producto, $idAlmacen, $multiplier = -1){
      global $connection, $data;
        $inventario = array(
          "idAlmacen" => $idAlmacen,
          "idProducto" => intval($producto["id"]),
          "tipo" => $multiplier * $producto["qty"],
          "comentario" => "venta",
          "fecha" => $data['fecha']
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

    try {
      if($data['order_type'] == "defaultCheck1" || $data['order_type'] == "defaultCheck3"){
        //Mostrador
        createFolio($data['idPersona'], 3);
        $folioId = $connection->lastInsertId();
        echo json_encode(['folio' => $folioId]);

        $cashAmountRemaining = 0;
        $cardAmountRemaining = 0;

        if(isset($data['payment_type']['tarjeta'])){
          $cardAmountRemaining = $data['monto_tarjeta'];
        }

        if(isset($data['payment_type']['efectivo'])){
          $cashAmountRemaining = $data['monto_efectivo'];
        }

        foreach($data['productos'] as $producto){
          $amountToPay = $producto['importe'];
          $transactionId = 0;
          $transactionId2 = 0;
          if($cardAmountRemaining > 0 ){
            if($cardAmountRemaining >= $amountToPay) {
              createTrasaction($_SESSION['almacen'], $amountToPay, "Venta", "tarjeta");
              $transactionId = $connection->lastInsertId();
              $cardAmountRemaining = $cardAmountRemaining - $amountToPay;
            } else {
              createTrasaction($_SESSION['almacen'], $cardAmountRemaining, "Venta", "tarjeta");
              $transactionId = $connection->lastInsertId();

              $amountToPay = $amountToPay - $cardAmountRemaining;
              $cardAmountRemaining = 0;

              createTrasaction($_SESSION['almacen'], $amountToPay, "Venta", "efectivo");
              $transactionId2 = $connection->lastInsertId();

              $cashAmountRemaining = $cashAmountRemaining - $amountToPay;
            }
          } elseif($cashAmountRemaining > 0) {
            //pago en efectivo
            createTrasaction($_SESSION['almacen'], $amountToPay, "Venta", "efectivo");
            $transactionId = $connection->lastInsertId();
            $cashAmountRemaining = $cashAmountRemaining - $amountToPay;
          }

          createInventario($producto, $_SESSION['almacen']);
          $inventarioId = $connection->lastInsertId();

          createVenta($folioId, $inventarioId, null, $transactionId, $producto['porc_dcto'], "Venta");

          if($transactionId2 > 0) {
            createVenta($folioId, $inventarioId, null, $transactionId2, $producto['porc_dcto'], "Venta");
          }
        }

      } elseif ($data['order_type'] == "defaultCheck2") {
        //Apartado
        createFolio($data['idPersona'], 1);
        $folioId = $connection->lastInsertId();
        echo json_encode(['folio' => $folioId]);

        $cashAmountRemaining = 0;
        $cardAmountRemaining = 0;

        if(isset($data['payment_type']['tarjeta'])){
          $cardAmountRemaining = $data['monto_tarjeta'];
        }

        if(isset($data['payment_type']['efectivo'])){
          $cashAmountRemaining = $data['monto_efectivo'];
        }

        $prodQty = count($data['productos']);
        $saleTotal = $data['monto_total'];

        foreach($data['productos'] as $producto){
          $prodPrice = $producto['importe'];
          $amountToPay = ($data['abono'] / $saleTotal) * $prodPrice;
          // variables para cobranza
          $transactionId = null;
          $transactionId2 = null;
          $cobranzaId;
          if($cardAmountRemaining > 0 ){
            if($cardAmountRemaining >= $amountToPay) {
              createTrasaction($_SESSION['almacen'], $amountToPay, "Venta", "tarjeta");
              $transactionId = $connection->lastInsertId();

              createCobranza($producto['importe'] - $amountToPay);
              $cobranzaId = $connection->lastInsertId();

              $cardAmountRemaining = $cardAmountRemaining - $amountToPay;
            } else {
              createTrasaction($_SESSION['almacen'], $cardAmountRemaining, "Venta", "tarjeta");
              $transactionId = $connection->lastInsertId();

              createCobranza($amountToPay);
              $cobranzaId = $connection->lastInsertId();

              $amountToPay = $amountToPay - $cardAmountRemaining;
              $cardAmountRemaining = 0;

              if($cashAmountRemaining >= $amountToPay) {
                createTrasaction($_SESSION['almacen'], $amountToPay, "Venta", "efectivo");
                $cashAmountRemaining = $cashAmountRemaining - $amountToPay;
              } else {
                createTrasaction($_SESSION['almacen'], $cashAmountRemaining, "Venta", "efectivo");
                $cashAmountRemaining = 0;
              }
              $transactionId2 = $connection->lastInsertId();
            }
          } elseif($cashAmountRemaining > 0) {
            //pago en efectivo
            if($cashAmountRemaining >= $amountToPay) {
              createTrasaction($_SESSION['almacen'], $amountToPay, "Venta", "efectivo");
              $transactionId = $connection->lastInsertId();

              $cashAmountRemaining = $cashAmountRemaining - $amountToPay;

              createCobranza($producto['importe'] - $amountToPay);
              $cobranzaId = $connection->lastInsertId();

            } else {
              createTrasaction($_SESSION['almacen'], $cashAmountRemaining, "Venta", "efectivo");
              $transactionId = $connection->lastInsertId();

              $amountToPay = $amountToPay - $cashAmountRemaining;

              $cashAmountRemaining = 0;

              createCobranza($amountToPay);
              $cobranzaId = $connection->lastInsertId();

              $amountToPay = $amountToPay - $cashAmountRemaining;
              $cashAmountRemaining = 0;
            }
          }
          createInventario($producto, $_SESSION['almacen']);
          createInventario($producto, 200, +1);
          $inventarioId = $connection->lastInsertId();

          createVenta($folioId, $inventarioId, $cobranzaId, $transactionId, $producto['porc_dcto'], "Venta");
          $idVenta = $connection->lastInsertId();

          if($transactionId2 > 0) {
            createVenta($folioId, $inventarioId, $cobranzaId, $transactionId2, $producto['porc_dcto'], "Venta");
          }
        }
      }
    } catch(PDOException $error) {
      echo "<br>" . $error->getMessage();
    }
  }
?>

