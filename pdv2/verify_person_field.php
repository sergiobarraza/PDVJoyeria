<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  if(isset($_POST['validatePersonFields'])){
    try {
      $obj = $data = $_POST['validatePersonFields'];
      foreach($data as $key => $val) {
        $sql = "SELECT * FROM Persona WHERE ".$key." = '$val'";

        $statement = $connection->prepare($sql);
        $statement->execute();
        $count = $statement->rowCount();
        $data[$key] = $count == 0 ;
      }
      echo json_encode($data);
    } catch(PDOException $error){
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
