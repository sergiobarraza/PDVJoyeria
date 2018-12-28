<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['deposit'])) {
    try {
      function createVenta($idFolio, $idInventario, $idCobranza, $estado, $idTransaccion){
        global $connection, $data;

        $venta = array(
          "idFolio" => $idFolio,
          "idTransaccion" => $idTransaccion,
          "idInventario" => $idInventario,
          "idCobranza" => $idCobranza,
          "descuento" => 0,
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
        return $connection->lastInsertId();
      }

      function createCobranza($amount){
        global $connection, $data;

        $cobranza = array(
          "monto" => -$amount,
          "fecha" => date("Y-m-d")
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Cobranza",
          implode(", ", array_keys($cobranza)),
          ":" . implode(", :", array_keys($cobranza))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($cobranza);

        return $connection->lastInsertId();
      }

      function createInventario($idProducto, $multiplier = 0){
        global $connection, $data;
        $inventario = array(
          "idAlmacen" => $_SESSION['almacen'],
          "idProducto" => intval($idProducto),
          "tipo" => $multiplier,
          "comentario" => "abono",
          "fecha" => date("Y-m-d")
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Inventario",
          implode(", ", array_keys($inventario)),
          ":" . implode(", :", array_keys($inventario))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($inventario);

        return $connection->lastInsertId();

      }

      function createTransaction($idAlmacen, $monto, $concepto, $tipoDePago){
        global $connection, $data;

        $transaccion = array(
          "monto" => $monto,
          "idAlmacen" => $idAlmacen,
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

      $data = $_POST['deposit'];

      if($data['cash'] > 0) {
        $cash_amount = $data['deposit_amount'] - $data['card'];
        $idTransaccionCash = createTransaction($_SESSION['almacen'], $cash_amount, "abono", "cash");
        $idInventario = createInventario($data['selected_product_id']);
        $idCobranza = createCobranza($cash_amount);
        createVenta($data['folio']['idFolio'], $idInventario, $idCobranza, "abono", $idTransaccionCash);
      }

      if($data['card'] > 0) {
        $card_amount = $data['deposit_amount'] - $data['cash'];
        $idTransaccionCard = createTransaction($_SESSION['almacen'], $card_amount, "abono", "card");
        $idInventario = createInventario($data['selected_product_id']);
        $idCobranza = createCobranza($card_amount);
        createVenta($data['folio']['idFolio'], $idInventario, $idCobranza, "abono", $idTransaccionCard);
      }

      echo "OK";

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }

  if(isset($_POST['cancel_folio'])) {
    try {
      $data = $_POST['cancel_folio'];
      $sql = "UPDATE Folio SET idEstadoDeFolio = 2 WHERE idFolio =".$data['idFolio'].";";
      $statement = $connection->prepare($sql);
      $folios = $statement->execute();
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }

  }

  if(isset($_POST['folio_products_list'])) {
    try {
      $data = [];
      $sql = "SELECT * FROM Producto";
      $statement = $connection->prepare($sql);
      $folios = $statement->execute();

      if($statement->rowCount() > 0) {
        $index = 0;
        while($row = $statement->fetch()){
          $data['products'][$index] = [
            'idProducto' => $row['idProducto'],
            'descuento' => $row['descuento'],
            'idDepartamento' => $row['idDepartamento'],
            'idLinea' => $row['idLinea'],
            'nombre' => $row['nombre'],
            'codigo' => $row['codigo'],
            'precio' => $row['precio']
          ];
          $index++;
        }
      }
      $sql = "SELECT * FROM Linea";
      $statement = $connection->prepare($sql);
      $statement->execute();

      if($statement->rowCount() > 0) {
        $index = 0;
        while($row = $statement->fetch()){
          $data['lines'][$index] = [
            'idLinea' => $row['idLinea'],
            'nombre' => $row['nombre'],
          ];
          $index++;
        }
      }

      echo json_encode($data);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }

  if(isset($_POST['folio_index'])) {
    try {
      $sql = "SELECT * FROM Folio where idEstadoDeFolio = ".$_POST['folio_index']['idEstadoDeFolio'].";";

      $statement = $connection->prepare($sql);
      $folios = $statement->execute();
      $data = [];
      if($statement->rowCount() > 0) {
        $index = 0;
        while($row = $statement->fetch()){
          $data[$index] = [
            'idFolio' => $row['idFolio'],
            'idPersona' => $row['idPersona'],
            'idEstadoDeFolio' => $row['idEstadoDeFolio'],
            'devuelto' => $row['devuelto'],
          ];
          $index++;
        }

        foreach($data as $key => $row) {
          $sql = "SELECT * FROM Persona WHERE idPersona = ".$row['idPersona'];

          $statement = $connection->prepare($sql);
          $persona = $statement->execute();
          $data[$key]['persona'] = $statement->fetch();

          $sql = "SELECT * FROM Venta WHERE idFolio = ?";

          $statement = $connection->prepare($sql);
          $statement->execute(array($row['idFolio']));
          $venta_index = 0;
          $venta_rows = $statement->fetchAll();
          foreach($venta_rows as $venta_row){
            $data[$key]['venta'][$venta_index] = [
              "idVenta" => $venta_row['idVenta'],
              "idFolio" => $venta_row['idFolio'],
              "idInventario" => $venta_row['idInventario'],
              "idTransaccion" => $venta_row['idTransaccion'],
              "descuento" => $venta_row['descuento'],
              "idCobranza" => $venta_row['idCobranza'],
              "estado" => $venta_row['estado']
            ];

            if($venta_row['idInventario']){
              $sql = "SELECT * FROM Inventario WHERE idInventario = ".$venta_row['idInventario'];
              $statement = $connection->prepare($sql);
              $inventario = $statement->execute();
              $inv_row = $statement->fetch();
              $data[$key]['venta'][$venta_index]['inventario'] = [
                'idInventario' => $inv_row['idInventario'],
                'idProducto' => $inv_row['idProducto'],
                'tipo' => $inv_row['tipo'],
                'idAlmacen' => $inv_row['idAlmacen'],
                'fecha' => $inv_row['fecha']
              ];
            }

            if($venta_row['idTransaccion']){
              $sql = "SELECT * FROM Transaccion WHERE idTransaccion = ".$venta_row['idTransaccion'];
              $statement = $connection->prepare($sql);
              $transaccion = $statement->execute();
              $tra_row = $statement->fetch();
              $data[$key]['venta'][$venta_index]['transaccion'] = [
                'idTransaccion' => $tra_row['idTransaccion'],
                'monto' => $tra_row['monto'],
                'concepto' => $tra_row['concepto'],
                'tipoDePago' => $tra_row['tipoDePago'],
                'idAlmacen' => $tra_row['idAlmacen'],
                'fecha' => $tra_row['fecha']
              ];
            }

            $sql = "SELECT * FROM Almacen WHERE idAlmacen = ".$tra_row['idAlmacen'];
            $statement = $connection->prepare($sql);
            $almacen = $statement->execute();
            $alm_row = $statement->fetch();

            $data[$key]['venta'][$venta_index]['almacen'] = [
              'idAlmacen' => $alm_row['idAlmacen'],
              'name' => $alm_row['name'],
              'address' => $alm_row['address'],
              'rfc' => $alm_row['rfc'],
              'tel' => $alm_row['tel'],
              'iva' => $alm_row['iva']
            ];

            if ( $venta_row['idCobranza']){
              $sql = "SELECT * FROM Cobranza WHERE idCobranza = ".$venta_row['idCobranza'];
              $statement = $connection->prepare($sql);
              $transaccion = $statement->execute();
              $cob_row = $statement->fetch();
              $data[$key]['venta'][$venta_index]['cobranza'] = [
                'idCobranza' => $cob_row['idCobranza'],
                'monto' => $cob_row['monto'],
                'deudaTotal' => $cob_row['deudaTotal'],
                'fecha' => $cob_row['fecha']
              ];
            }
            $venta_index++;
          };
        }
      }
      echo json_encode($data);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
