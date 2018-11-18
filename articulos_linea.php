 <?php
	$pageSecurity = array("admin");
  require "config/security.php";
  require "config/database.php";

	$linea = $_POST["linea"];
	$sql = "INSERT INTO Linea(nombre) VALUES ('$linea');";
	echo $sql;
	try {
      $connection = new PDO($dsn, $username, $password, $options );

      $new_user = array(
        "nombre" => $_POST['linea']
      );


      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      header("Refresh:0; url=articulos.php?status=errorlinea#nuevaLinea");
      exit;
    }
 
	header("Refresh:0; url=articulos.php?status=successlinea#nuevaLinea");

?>