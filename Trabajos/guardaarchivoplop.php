<?php
	//include 'conexion.php';

    $pp = $_POST["archivo"];

    /**
 * PHP MySQL BLOB Demo
 */
class BobDemo {
 
    const DB_HOST = 'localhost';
    const DB_NAME = 'joyeria';
    const DB_USER = 'joyeriaclaro';
    const DB_PASSWORD = 'claro123';
 
    /**
     * Open the database connection
     */
    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;dbname=%s;charset=utf8", self::DB_HOST, self::DB_NAME);
 
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
            //for prior PHP 5.3.6
            //$conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
 
    /**
     * close the database connection
     */
    public function __destruct() {
        // close the database connection
        $this->pdo = null;
    }
 
}

if ($_FILES['archivo']["error"] > 0)
  {
  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
  }
else {
	echo "string";
    echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
    echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
    echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
    echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
    $blob = fopen($_FILES['archivo']['tmp_name'], 'rb');
    $sql = "INSERT INTO files(mime,data) VALUES(:mime,:data)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':mime', $mime);
    $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);
    echo $sql;
    $stmt->execute();;

}

  /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
//move_uploaded_file($_FILES['archivo']['tmp_name'],"img/" . $_FILES['archivo']['name']);<em id="__mceDel"> </em>
//echo "Guarda Archivo.php";
?>	