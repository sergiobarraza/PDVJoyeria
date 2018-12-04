 <?php
	$pageSecurity = array("admin");
  require "config/security.php";
  require "config/database.php";

	$linea = $_POST["linea"];
	$sql = "INSERT INTO Procedencia(nombre) VALUES ('$linea');";
	//echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );

      $new_user = array(
        "nombre" => $_POST['linea']
      );


      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorprocendencia#nuevaLinea");
      
    }
 
	header("Refresh:0; url=articulos.php?status=successprocendencia&articulo=$linea#nuevaLinea");

?>