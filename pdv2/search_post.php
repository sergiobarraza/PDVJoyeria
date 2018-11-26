<?php
  require "../config/common.php";
  require "../config/database.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $seached_product;

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(isset($_POST['search'])) {
    try{
      $searchq = $_POST['search'];
      $searchq = preg_replace("#[^0-9a-z\w\ ]#i", "", $searchq);

      $sql_nombre = "SELECT * FROM Producto WHERE nombre = '$searchq' ";
      $sql_id = "SELECT * FROM Producto WHERE codigo = '$searchq'";

      $sql = $_POST['search_select'] == "Nombre" ? $sql_nombre : $sql_id;

      $statement = $connection->prepare($sql);
      $statement->bindValue(1, "%$searchq%", PDO::PARAM_STR);
      $seached_product = $statement->execute();


      if(!$statement->rowCount() == 0){

        while($row = $statement->fetch()){
          echo "<tr id=prod-".$row['idProducto'].">";
          echo "<th id='id-prod-".$row['idProducto']."' style='display: none;'>".$row['idProducto']."</th>";
          echo "<th class='prod-name'>".$row['nombre']."</th>";
          echo "<th class='prod-code'>".$row['codigo']."</th>";
          echo "<th><input type='number' min='0' max='100' id='discount-prod-".$row['idProducto']."' class='form-control' value='30' onchange="."'changeProdDiscountPrice(".'"prod-'.$row['idProducto'].'"'.")'></th>";
          echo "<th id='quantity-prod-".$row['idProducto']."'>1</th>";
          echo "<th id='price-prod-".$row['idProducto']."'>".$row['precio']."</th>";
          echo "<th id='price-discount-prod-".$row['idProducto']."'>".$row['precio']."</th>";
          echo "<th id='total-price-prod-".$row['idProducto']."'>".$row['precio']."</th>";
          echo "<th><button class='btn btn-default' onclick="."'deleteProduct(".'"prod-'.$row['idProducto'].'"'.")'>X</button></th>";
          echo "</tr>";
        }
      }

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
