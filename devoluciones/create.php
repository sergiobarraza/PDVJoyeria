<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  if(isset($_POST['devolution'])){
    try {
      $data = $_POST['devolution'];

      function addProductToInv($folio, $products, $addToAlmId){
        //create folio
        $folioId = createFolio($addToAlmId, $folio['idPersona'], "Entrada Producto", $folio['codigo'], true);
        //create inventario +n
        foreach($products as $productId) {
          createInventario($productId, 1, $folioId);
        }
      }

      function retrieveProduct($folio, $products, $retrievedFromAlmId){
        $folioId = createFolio($retrievedFromAlmId, $folio['idPersona'], "Salida Producto", $folio[ 'codigo' ], true);
        foreach($products as $productId) {
          createInventario($productId, -1, $folioId);
        }
      }

      function setFolioDevuelto($idFolio, $devuelto){
        global $connection, $data;
        $sql = "UPDATE Folio SET devuelto = '$devuelto' WHERE idFolio = '$idFolio';";
        $statement = $connection->prepare($sql);
        $statement->execute();
      }

      function createFolio($idAlmacen, $idPersona, $estado, $codigo, $devuelto){
        global $connection, $data;

        $folio = array(
          "idAlmacen" => $idAlmacen,
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

      function createInventario($idProducto, $tipo, $idFolio){
        global $connection, $data;

        $inventario = array(
          "idProducto" => intval($idProducto),
          "tipo" => $tipo,
          "fecha" => date("Y-m-d"),
          "idFolio" => $idFolio
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

      function createTrasaction($monto, $concepto, $idFolio, $tipoDePago){
        global $connection, $data;

        $transaccion = array(
          "monto" => intval($monto),
          "concepto" => $concepto,
          "tipoDePago" => $tipoDePago,
          "fecha" => date("Y-m-d"),
          "idFolio" => $idFolio
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Transaccion",
          implode(", ", array_keys($transaccion)),
          ":" . implode(", :", array_keys($transaccion))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($transaccion);
      }

      // Si el folio esta en apartado:
      // agregar devuelto a folio
      // Productos devueltos salen de 200 y entran a almacen central id: 1
      // Nuevos productos (reemplazo) salen del almacen y entran a almacen
      // apartado id: 200
      // Se necesitan 4 folios nuevos
      if($data['folio']['devuelto'] < 0){
        setFolioDevuelto($data['folio']['idFolio'], true);
        if($data['folio']['estado'] == "Apartado"){
          // Productos devueltos salen de 200 y entran a almacen central id: 1
          retrieveProduct($data['folio'], $data['returned_products'], 200);
          addProductToInv($data['folio'], $data['returned_products'], 1);
          // Nuevos productos (reemplazo) salen del almacen y entran a apartados
          retrieveProduct($data['folio'], $data['new_products'], 1); // cambiar a almacen seleccionado
          addProductToInv($data['folio'], $data['new_products'], 200);

        } elseif ($data['folio']['estado'] == "Venta") {
          addProductToInv($data['folio'], $data['returned_products'], 1);
          retrieveProduct($data['folio'], $data['new_products'], 1);
        }
        //calcular transaccion
        if ($data['transaction']['payment_value'] > 0){
          createTrasaction($data['transaction']['payment_value'], "Diferencia de pago al devolver", $data['folio']['idFolio'], 'default' );
        }
      } else {
        echo "El folio ya ha sido devuelto";
      }
    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }
?>

