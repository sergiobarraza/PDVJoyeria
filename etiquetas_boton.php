<?php  
$pageSecurity = array("admin");
  require "config/security.php";
	$idProd = $_GET['producto'];
	$cantidad = 1;
	$host     = "167.99.172.182";
	  $username = "sergio";
	  $password = "";
	  $dbname   = "PDVJoyeria";
	  $dsn      = "mysql:host=$host;dbname=$dbname";
	  $options  = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	  $connection = new PDO($dsn, $username, $password, $options );
	  $sql = "SELECT Producto.codigo, Producto.precio, Producto.procedencia, Tipoprod.nombre from Producto  join Tipoprod on Tipoprod.idTipoprod = Producto.idTipoprod
	  where idProducto= $idProd";
      $query = $connection->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
      $codigo = $row["codigo"];
      $precio = $row["precio"];
      $procedencia = $row["procedencia"];
      $tipo = $row["nombre"];
      while(strlen($codigo)< 7) {
      	$codigo = '0'.$codigo;	
      }	
      $impresion= "^XA^FO420,10^GFA,1638,1638,18,,::::::::P0E1F8E07FFDFF03F03F,P0E3FC70EFFDFF87F87F8,P0E79E70EFFDFFCF3CF38,P0E70739CE01C1DE1EE1C,P0EE0739CE01C1DC0EE0C,P0EE031F8FF9C3DC0E7C,P0EE030F0FFDFF9C067F,P0EE030F0FFDFF18061F8,P0EE03060E01CF1C0E03C,O0CEE07060E01C79C0EC1C,N01CE707060E01C39C0EE0C,N01CE79E060F01C1CF3CF1C,O0FC3FE060FFDC1C7F87F8,O0FC1F8060FFDC0E3F03F,,::N07YFE,N04Y02,N0C7E30IFDFEFF3FCFF7F9,N08FF30FFEDFEFFBFEFF7F9,M018E330C30DC0E3B8EC00718,M011C3B0C30DC0E1B06C00708,M0318030C30DFEE3B8EFE0E08,M0218F30C30DFEFFBFCFF1C0C,M0218FB0C30DFEFF3F8FF1C04,M0418FB0C30DC0E7398C03804,M041C1B0C30DC0E339CC07002,M080E3B9C30DC0E3B8EE07002,M080FFBF830DFFE1B8EJF83,L01003E1F030DFF61F07JF81,L01003C0F079IFE1F87JF81,L01gIF,M08gG02,M043FF04007KFE7FE7FF84,M021I04004K0240240108,M0108004004K024014021,M0184004004K024014042,N0C2004004K024014084,N061804004K024024118,N030C04004K02404423,N018604004K02418466,O0C304004K027F84CC,O06184004K0240C598,O030C4004K0240473,O01864007KFE40466,P0C0400CK024060C,P060400CK0240618,P030400CK024063,P018400CK024046,Q0C400CK02408C,Q06300CK024018,Q03180CK02402,Q018C0CK02404,R0C60CK02408,R0610CK0241,R030CCK0242,R0184CK0284,S0C0CK0208,S060CK021,S0304K066,S0186K0CC,T0C3J0198,T0618I033,T030CI066,T0186I0CC,U0C300198,U0618033,U0308066,U018I0C,V0C0018,V06003,V03006,V01808,W0C1,W042,W024,W018,,:::^FS^FX Precio, procedencia y tipo^CF0,35^FO550,30^FD$".$precio."^FS^CF0,20^FO540,70^FD".$procedencia." ".$tipo."^FS^FX Third section with barcode.^BY2,1,50^FO448,103^A0N,30,50^BC^FD".$codigo."^FS^XZ";
?>

<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="js/dependencies/rsvp-3.1.0.min.js"></script>
	<script type="text/javascript" src="js/dependencies/sha-256.min.js"></script>
	<script type="text/javascript" src="js/qz-tray.js"></script>
	<title></title>
</head>
<body>


<script type="text/javascript">
	qz.websocket.connect().then(function() {
  		var config = qz.configs.create("ZDesigner GC420t (EPL)", {copies: <?php echo $cantidad; ?>});               // Exact printer name from OS
		var data = ['<?php echo $impresion; ?>'];   // Raw commands (ZPL provided)

		qz.print(config, data).then(function() {
   		alert("Sent data to printer");
   		window.close();
});
});
	function print() {
	   var config = qz.configs.create("ZDesigner GC420t (EPL)");

	   var data = [
	      'Data\n',
	      'Should be simple data\n',
	      'To be printed\n'
	   ];

	   qz.print(config, data).catch(function(e) {
	       console.error(e);
	   });

	   qz.websocket.connect().then(function() {
	   alert("Connected!");
	   
	   
	});
}
	//window.close();
</script>

</body>
</html>
