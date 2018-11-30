<?php
  $host     = "167.99.172.182";
  $username = "sergio";
  $password = "";
  $dbname   = "PDVJoyeria";
  $dsn      = "mysql:host=$host;dbname=$dbname";
  $options  = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	
	//include 'plantilla.php';
	//require 'conexion.php';

	$sql = "SELECT  Producto.idLinea, Linea.nombre as Linea,  Producto.nombre as Descripcion, Inventario.tipo,  Transaccion.monto,  EstadoDeFolio.nombre as estado, Inventario.comentario, Inventario.idAlmacen, Almacen.name, Producto.codigo
		from Venta
        join Inventario on Venta.idInventario = Inventario.idInventario
		join Producto on Inventario.idProducto = Producto.idProducto
		join Folio on Venta.idFolio = Folio.idFolio
		join Linea on Producto.idLinea = Linea.idLinea
		join Transaccion on Venta.idTransaccion = Transaccion.idTransaccion
        join EstadoDeFolio on Folio.idEstadoDeFolio = EstadoDeFolio.idEstadosDeFolio
        join Almacen on Inventario.idAlmacen = Almacen.idAlmacen
        where Inventario.tipo < 0
        order by Producto.codigo
        ;";
	//$resultado = $mysqli->query($query);
	$connection = new PDO($dsn, $username, $password, $options );

	require 'C:/xampp/htdocs/PDVJoyeria/pdf/fpdf/fpdf.php';
	class PDF Extends FPDF
	{
		function Header()
		{

			//$this->Image('images/logo.png', 10, 10, -300 );
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(40);
			$this->Cell(100,10, 'JOYERIA CLAROS', 0, 'C');
			$this->Ln();	
			$this->Cell(100,10, 'Detalle de articulos vendidos en una fecha especifica', 0, 0, 'C');

			$this->Ln(30);	
		}
	}
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->Addpage();

		//$pdf->Image('images/logo.png', 10, 10, -300 );
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
				
				$pdf->Cell(15, 6, $row['idLinea'], 1, 0, 'c');
				$pdf->Cell(35, 6, $row['Linea'], 1, 0, 'c');
				$pdf->Cell(30, 6, $row['codigo'], 1, 0, 'c');
				$pdf->Cell(65, 6, $row['Descripcion'], 1, 0, 'c');
				$pdf->Cell(17, 6, ($row['tipo'])*-1, 1, 0, 'c');
				$pdf->Cell(30, 6, 15, 1, 0, 'c');
				$pdf->Ln();

			}

		$pdf ->Output();
	

?>