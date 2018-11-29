<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  if(isset($_GET['almacen_index'])) {
    try {
      $data = [];
      $sql = "SELECT * FROM Almacen";
      $statement = $connection->prepare($sql);
      $folios = $statement->execute();

      if($statement->rowCount() > 0) {
        $index = 0;
        while($row = $statement->fetch()){
          $data['almacenes'][$index] = [
            'idAlmacen' => $row['idAlmacen'],
            'name' => $row['name'],
            'address' => $row['address'],
            'rfc' => $row['rfc'],
            'tel' => $row['tel'],
            'iva' => $row['iva'],
            'nombreFiscal' => $row['nombrefiscal']
          ];
          $index++;
        }
      }
      echo json_encode($data);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }

?>
