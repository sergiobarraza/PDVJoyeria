<?php
  $host     = "167.99.172.182";
  $username = "sergio";
  $password = "";
  $dbname   = "PDVJoyeria";
  $dsn      = "mysql:host=$host;dbname=$dbname";
  $options  = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  
		//$sucursal = $_GET['sucursal'];
		/*$ano = $_GET['ano'];
		$mes = $_GET['mes'];
		$dia = $_GET['dia'];
		$fecha = "".$ano."-".$mes."-".$dia;*/
		$fecha = date("d-M-Y");

	//include 'plantilla.php';
	//require 'conexion.php';

	$sql = "SELECT * from
			(select a.idAlmacen, a.Almname, a.linea, a.codigo, a.producto, SUM(a.tipo) as cantidad from
			(select Inventario.idAlmacen, Almacen.name as Almname, Linea.nombre as linea, Producto.codigo, Producto.nombre as producto, Inventario.tipo from Inventario
			join Producto on Producto.idProducto = Inventario.idProducto
			join Linea on Producto.idLinea = Linea.idLinea
			join Almacen on Inventario.idAlmacen = Almacen.idAlmacen
			where Inventario.idAlmacen <> 200
			order by Inventario.idAlmacen asc, cast(Producto.codigo as unsigned) asc) as a
			group by a.idAlmacen, a.linea, a.codigo, a.producto,a.Almname) as b
			where cantidad <>0
        ;";
        $meses = array(
								0 => "", 
								1 => "Enero", 
								2 => "Febrero", 
								3 => "Marzo", 
								4 => "Abril", 
								5 => "Mayo", 
								6 => "Junio", 
								7 => "Julio", 
								8 => "Agosto", 
								9 => "Septiembre", 
								10 => "Octubre", 
								11 => "Noviembre", 
								12 => "Diciembre", 
								

							);

       	
	$connection = new PDO($dsn, $username, $password, $options );
	
	require 'C:/xampp/htdocs/PDVJoyeria/pdf/fpdf/fpdf.php';
	class PDF Extends FPDF
	{
		function Header()
		{

			$this->Image('images/logo.jpg', 0, 0, -300 );
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(40);
			$this->Cell(120,30, 'JOYERIA CLAROS', 0,1, 'C');
			//$this->Ln();	
			/*$this->Cell(200,5, 'Detalle de articulos vendidos en una fecha especifica', 0, 1, 'C');
			$this->SetFont('Arial', '', 12);
			$this->Cell(200,5, 'Fecha de venta: 18-Agosto-2018',0,1,'C');
			$this->Cell(200,5, 'Sucursal: Blanco',0,0,'C');*/
			$this->Ln(10);	
		}

		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0, 10, 'Pagina '. $this->PageNo().'/{nb}',0,0,'R' );	

		}
	}
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->Addpage();

		//Header
		/*$pdf->Image('images/logo.jpg', 0, 0, -300 );
		$pdf->SetFont('Arial', 'B', 15);
		$pdf->Cell(40);
		$pdf->Cell(120,30, 'JOYERIA CLAROS', 0,1, 'C');*/
		
		$pdf->Cell(200,5, 'Inventario General', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(200,5, 'Fecha de venta: '.$fecha ,0,1,'C');
		$pdf->Cell(200,5, 'Sucursal: General',0,0,'C');
		$pdf->Ln(10);

		$pdf->Setfillcolor(232,232,232);
		$pdf->SetFont('Arial','B', 12);
		$pdf->Cell(40, 6, 'Almacen', 1, 0, 'C', 1);
		$pdf->Cell(35, 6, 'Linea', 1, 0, 'C', 1);
		$pdf->Cell(30, 6, 'Codigo', 1, 0, 'C', 1);
		$pdf->Cell(65, 6, 'Descripcion', 1, 0, 'C', 1);
		$pdf->Cell(20, 6, 'Cantidad', 1, 0, 'C', 1);
		$pdf->Ln();

		
		$pdf->SetFont('Arial','', 10);
		$idLineaAnterior = '';
		$query = $connection->query($sql);
		foreach($query->fetchAll() as $row)
		{
/*			if ($idLineaAnterior != $row['idLinea']) {
				$idLineaAnterior = $row['idLinea'];
				$lineaShow = $row['Linea'];
				$idLineaShow = $row['idLinea'];
			}else{
				$lineaShow = '';
				$idLineaShow = '';
			}*/
			//$monto = floor($row['monto']*pow(10,2))/pow(10,2);
			$pdf->Cell(40, 6, $row['Almname'], 1, 0, 'C');
			$pdf->Cell(35, 6, $row['linea'], 1, 0, 'C');
			$pdf->Cell(30, 6, $row['codigo'], 1, 0, 'C');
			$pdf->Cell(65, 6, $row['producto'], 1, 0, 'C');
			$pdf->Cell(20, 6, ($row['cantidad']), 1, 0, 'C');
			$pdf->Ln();

		}

		$pdf ->Output();
	

?>