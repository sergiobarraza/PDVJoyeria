<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['folio_index'])) {
    try {
      $sql = "SELECT * FROM Folio WHERE estado = 'Apartado'";

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
        }
      }
      echo json_encode($data);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
