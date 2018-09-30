<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $searchq;
  $sql;

  if(isset($_POST['tel'])) {
    $searchq = $_POST['tel'];
    $searchq = preg_replace("/\D/", '', $searchq);

    $sql = "SELECT * FROM Persona WHERE tel = '$searchq' ";

  } else if ($_POST['rfc']) {
    $searchq = $_POST['rfc'];
    $searchq = preg_replace("/\s+/", '', $searchq);

    $sql = "SELECT * FROM Persona WHERE rfc = '$searchq' ";
  }

  try {
    $statement = $connection->prepare($sql);
    $statement->bindValue(1, "%$searchq%", PDO::PARAM_STR);
    $seached_person = $statement->execute();

    $data;

    if(!$statement->rowCount() == 0) {
      while($row = $statement->fetch()){
        $data = [
          'id' => $row['idPersona'],
          'nombre' => $row['nombre'],
          'apellido' => $row['apellido'],
          'rfc' => $row['rfc'],
          'tel' => $row['tel']
        ];
      }
    } else {
      echo "No se encontro informacion.";
    }

    header('Content-type: application/json');
    echo json_encode( $data );

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

?>
