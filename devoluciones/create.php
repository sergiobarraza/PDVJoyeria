<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $pageSecurity = array("venta", "admin", "supervisor");

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['giveAwayProduct'])){
    try {
       function createVenta($idFolio, $idInventario, $estado){
        global $connection, $data;

        $venta = array(
          "idFolio" => $idFolio,
          "idInventario" => $idInventario,
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

      function createInventario($idProducto, $almacen = 0, $multiplier = 0){
        global $connection, $data;
        $inventario = array(
          "idProducto" => intval($idProducto),
          "tipo" => $multiplier,
          "comentario" => "entrega",
          "fecha" => date("Y-m-d")
        );

        if ($almacen > 0) {
          $inventario["idAlmacen"] = $almacen;
        }

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
      $data = $_POST['giveAwayProduct'];
      $idInventario = createInventario($data['prodId'], 200, -1);
      $idVenta = createVenta($data['folioId'], $idInventario, "entrega");

      $idInventario = createInventario($data['prodId']);
      $idVenta = createVenta($data['folioId'], $idInventario, "entrega");

      echo $idVenta;

    } catch(PDOException $error) {
      echo $error->getMessage();
    }

  }

  if(isset($_POST['devolution'])){
    try {
      $data = $_POST['devolution'];

      function addProductToInv($folio, $products, $addToAlmId){
        //create inventario +n
        foreach($products as $productId) {
          $idInventario = createInventario($addToAlmId, $productId, 1);
          createVenta($folio['idFolio'], $idInventario, null, "Entrada de producto", null);
        }
      }

      function retrieveProduct($folio, $products, $retrievedFromAlmId, $transaction){
        $idTransaccion = null;
        if($transaction['payment_value'] > 0){
          $idTransaccion = createTransaction($retrievedFromAlmId,$transaction['payment_value'], "Devolución", "efectivo");
        }

        foreach($products as $productId) {
          $idInventario = createInventario($retrievedFromAlmId, $productId, -1);
          createVenta($folio['idFolio'], $idInventario, null, "Salida de producto", $idTransaccion);
        }
      }

      function setFolioDevuelto($idFolio, $devuelto){
        global $connection, $data;
        $sql = "UPDATE Folio SET devuelto = '$devuelto' WHERE idFolio = '$idFolio';";
        $statement = $connection->prepare($sql);
        $statement->execute();
      }

      function createFolio($idPersona, $estado, $codigo, $devuelto){
        global $connection, $data;

        $folio = array(
          "idPersona" => $idPersona,
          "estado" => $estado,
          "codigo" => $codigo,
          "devuelto" => $devuelto
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Folio",
          implode(", ", array_keys($folio)),
          ":" . implode(", :", array_keys($folio))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($folio);
        return $connection->lastInsertId();
      }

      function createVenta($idFolio, $idInventario, $idCobranza, $estado, $idTransaccion){
        global $connection, $data;

        $venta = array(
          "idFolio" => $idFolio,
          "idInventario" => $idInventario,
          "idTransaccion" => $idTransaccion,
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

      function createInventario($idAlmacen, $idProducto, $tipo){
        global $connection, $data;

        $inventario = array(
          "idProducto" => intval($idProducto),
          "idAlmacen" => $idAlmacen,
          "tipo" => $tipo,
          "comentario" => "devolución",
          "fecha" => date("Y-m-d"),
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
          "monto" => floatval($monto),
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

      // Si el folio esta en apartado:
      // agregar devuelto a folio
      // Productos devueltos salen de 200 y entran a almacen central id: 1
      // Nuevos productos (reemplazo) salen del almacen y entran a almacen
      // apartado id: 200
      // Se necesitan 4 folios nuevos

      if($data['folio']['devuelto'] == 0 && $data['folio']['idEstadoDeFolio'] != 1){
        echo $data['folio']['idFolio'];
        setFolioDevuelto($data['folio']['idFolio'], true);
        if($data['folio']['idEstadoDeFolio'] == 1){
          // Productos devueltos salen de 200 y entran a almacen central id: 1
          retrieveProduct($data['folio'], $data['returned_products'], 200, null);
          addProductToInv($data['folio'], $data['returned_products'], $_SESSION['almacen']);
          // Nuevos productos (reemplazo) salen del almacen y entran a apartados
          retrieveProduct($data['folio'], $data['new_products'], $_SESSION['almacen'], $data['transaction']);
          addProductToInv($data['folio'], $data['new_products'], 200);

        } elseif ($data['folio']['idEstadoDeFolio'] == 3) {
          addProductToInv($data['folio'], $data['returned_products'], $_SESSION['almacen']);
          retrieveProduct($data['folio'], $data['new_products'], $_SESSION['almacen'], $data['transaction']);
        }
      } else {
        echo "El folio ya ha sido devuelto";
      }
    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }
?>

