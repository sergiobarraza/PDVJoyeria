<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
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
