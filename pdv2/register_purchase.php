<?php
  require "../config/common.php";
  require "../config/database.php";

  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['register_purchase'])){
    try {
      $data = $_POST['register_purchase'];

      if($data['order_type'] == "defaultCheck1"){
        //Mostrador
        $folio = array(
          "idAlmacen" => 1,
          "idPersona" => $data['idPersona'],
          "estado" => "Compra a Mostrador"
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "Folio",
          implode(", ", array_keys($folio)),
          ":" . implode(", :", array_keys($folio))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($folio);

        $folioId = $connection->lastInsertId();

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

        $paymentType = implode(", ", array_keys($data["payment_type"]));

        $transaccion = array(
          "monto" => $data['monto'],
          "concepto" => "Venta",
          "idFolio" => $folioId,
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


      }elseif ($data['order_type'] == "defaultCheck2") {
        //Apartado
        echo "Apartado";
      }elseif ($data['order_type'] == "defaultCheck3") {
        //Factura
        echo "Factura";
      }

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>

