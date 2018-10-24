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
      $sql = "SELECT * FROM Folio where Codigo IS NOT NULL;";

      $statement = $connection->prepare($sql);
      $folios = $statement->execute();
      $data = [];
      if($statement->rowCount() > 0) {
        $index = 0;
        while($row = $statement->fetch()){
          $data[$index] = [
            'idFolio' => $row['idFolio'],
            'idAlmacen' => $row['idAlmacen'],
            'idPersona' => $row['idPersona'],
            'estado' => $row['estado'],
            'codigo' => $row['codigo']
          ];
          $index++;
        }
        foreach($data as $key => $row) {
          $sql = "SELECT * FROM Almacen WHERE idAlmacen = ".$row['idAlmacen'];

          $statement = $connection->prepare($sql);
          $almacen = $statement->execute();
          $data[$key]['almacen'] = $statement->fetch();

          $sql = "SELECT * FROM Persona WHERE idPersona = ".$row['idPersona'];

          $statement = $connection->prepare($sql);
          $persona = $statement->execute();
          $data[$key]['persona'] = $statement->fetch();

          $sql = "SELECT * FROM Inventario WHERE idFolio = ".$row['idFolio'];

          $statement = $connection->prepare($sql);
          $inventario = $statement->execute();
          $inv_index = 0;
          while($inv_row = $statement->fetch()){
            $data[$key]['inventario'][$inv_index] = [
              'idInventario' => $inv_row['idInventario'],
              'idProducto' => $inv_row['idProducto'],
              'tipo' => $inv_row['tipo'],
              'idFolio' => $inv_row['idFolio'],
              'fecha' => $inv_row['fecha']
            ];
            $inv_index++;
          }

          $sql = "SELECT * FROM Transaccion WHERE idFolio = ".$row['idFolio'];

          $statement = $connection->prepare($sql);
          $statement->execute();
          $tra_index = 0;
          while($tra_row = $statement->fetch()){
            $data[$key]['transaccion'][$tra_index] = [
              'idTransaccion' => $tra_row['idTransaccion'],
              'monto' => $tra_row['monto'],
              'concepto' => $tra_row['concepto'],
              'idFolio' => $tra_row['idFolio'],
              'tipoDePago' => $tra_row['tipoDePago'],
              'fecha' => $tra_row['fecha']
            ];
            $tra_index++;
          }

          $sql = "SELECT * FROM Cobranza WHERE idFolio = ".$row['idFolio'];

          $statement = $connection->prepare($sql);
          $statement->execute();
          $cob_index = 0;
          while($cob_row = $statement->fetch()){
            $data[$key]['cobranza'][$cob_index] = [
              'idCobranza' => $cob_row['idCobranza'],
              'monto' => $cob_row['monto'],
              'idFolio' => $cob_row['idFolio'],
              'fecha' => $cob_row['fecha']
            ];
            $cob_index++;
          }

          $sql = "SELECT * FROM Cobranza WHERE idFolio = ".$row['idFolio'];

          $statement = $connection->prepare($sql);
          $statement->execute();
          $cob_index = 0;
          while($cob_row = $statement->fetch()){
            $data[$key]['cobranza'][$cob_index] = [
              'idCobranza' => $cob_row['idCobranza'],
              'monto' => $cob_row['monto'],
              'idFolio' => $cob_row['idFolio'],
              'fecha' => $cob_row['fecha']
            ];
            $cob_index++;
          }
        }
      }
      echo json_encode($data);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
