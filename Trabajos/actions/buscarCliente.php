<?php
  require "../../config/common.php";
  require "../../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  if(isset($_POST['client_index'])){
    try {
      $sql = "SELECT * FROM Persona WHERE idPersona <> 1;";
      $statement = $connection->prepare($sql);
      $statement->execute();
      if($statement->rowCount() >0 ){
        $index = 0;
        $users;
        while($row = $statement->fetch()) {
          $users[$index] = array(
            "idPersona" => $row['idPersona'],
            "nombre" => $row['nombre'],
            "apellido" => $row['apellido'],
            "tel" => $row['tel'],
            "email" => $row['email'],
            "tipo" => $row['tipo'],
            "rfc" => $row['rfc'],
          );
          $index++;
        }
      }
      echo json_encode($users);

    } catch (PDOException $error0) {
      echo $sql0 . "<br>" . $error0->getMessage();
    }
  }
?>

