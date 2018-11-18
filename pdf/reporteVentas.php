<?php
  $host     = "167.99.172.182";
  $username = "sergio";
  $password = "";
  $dbname   = "PDVJoyeria";
  $dsn      = "mysql:host=$host;dbname=$dbname";
  $options  = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	
	include 'plantilla.php';
	//require 'conexion.php';

	$sql = "SELECT Folio.codigo as '#',  Linea.nombre as Linea, Producto.codigo, Producto.nombre as Descripcion, Inventario.tipo as Unidad, Inventario.idFolio, Transaccion.monto, Folio.estado 
		from Inventario 
		join Producto on Inventario.idProducto = Producto.idProducto
		join Folio on Inventario.idFolio = Folio.idFolio
		join Linea on Producto.idLinea = Linea.idLinea
		join Transaccion on Folio.idFolio = Transaccion.idFolio
		where Folio.estado = 'Compra a Mostrador';";
	//$resultado = $mysqli->query($query);
	$connection = new PDO($dsn, $username, $password, $options );

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->Addpage();
	
	$pdf->Setfillcolor(232,232,232);
	$pdf->SetFont('Arial','B', 12);
	$pdf->Cell(15, 6, '#', 1, 0, 'c', 1);
	$pdf->Cell(35, 6, 'Linea', 1, 0, 'c', 1);
	$pdf->Cell(30, 6, 'Codigo', 1, 0, 'c', 1);
	$pdf->Cell(65, 6, 'Descripcion', 1, 0, 'c', 1);
	$pdf->Cell(17, 6, 'Unidad', 1, 0, 'c', 1);
	$pdf->Cell(30, 6, 'Precio', 1, 0, 'c', 1);
	$pdf->Ln();

	
	$pdf->SetFont('Arial','', 10);
	
	$query = $connection->query($sql);
		foreach($query->fetchAll() as $row)
		{
			
			$pdf->Cell(15, 6, $row['#'], 1, 0, 'c');
			$pdf->Cell(35, 6, $row['Linea'], 1, 0, 'c');
			$pdf->Cell(30, 6, $row['codigo'], 1, 0, 'c');
			$pdf->Cell(65, 6, $row['Descripcion'], 1, 0, 'c');
			$pdf->Cell(17, 6, ($row['Unidad'])*-1, 1, 0, 'c');
			$pdf->Cell(30, 6, $row['monto'], 1, 0, 'c');
			$pdf->Ln();

		}

	$pdf ->Output();

?>