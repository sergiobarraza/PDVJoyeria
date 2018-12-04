<?php
  $host     = "167.99.172.182";
  $username = "sergio";
  $password = "";
  $dbname   = "PDVJoyeria";
  $dsn      = "mysql:host=$host;dbname=$dbname";
  $options  = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  
		//$sucursal = $_GET['sucursal'];
		$ano = $_GET['ano'];
		$mes = $_GET['mes'];
		$dia = $_GET['dia'];
		$fecha = "".$ano."-".$mes."-".$dia;
		$Hano = $_GET['Hano'];
		$Hmes = $_GET['Hmes'];
		$Hdia = $_GET['Hdia'];
		$fechafin = "".$Hano."-".$Hmes."-".$Hdia;

	//include 'plantilla.php';
	//require 'conexion.php';

	$sql = "SELECT a.idInventario, a.idLinea, a.Linea, a.codigo, a.Descripcion, a.tipo,  SUM(a.monto) as monto,  a.comentario, a.idAlmacen,  a.fecha
from (SELECT  Inventario.idInventario, Producto.idLinea, Linea.nombre as Linea, Producto.codigo, Producto.nombre as Descripcion, Inventario.tipo,  Transaccion.monto,  Inventario.comentario, Inventario.idAlmacen,  Inventario.fecha
		from Venta
        join Inventario on Venta.idInventario = Inventario.idInventario
		join Producto on Inventario.idProducto = Producto.idProducto
		join Folio on Venta.idFolio = Folio.idFolio
		join Linea on Producto.idLinea = Linea.idLinea
		join Transaccion on Venta.idTransaccion = Transaccion.idTransaccion
        join EstadoDeFolio on Folio.idEstadoDeFolio = EstadoDeFolio.idEstadosDeFolio
        where Inventario.tipo < 0 and Inventario.fecha >= '$fecha' and Inventario.fecha <= '$fechafin' ) as a
        group by a.idInventario, a.idLinea, a.Linea, a.codigo, a.Descripcion, a.tipo,  a.comentario, a.idAlmacen,  a.fecha
        order by a.idLinea asc
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
		
		$pdf->Cell(200,5, 'Detalle de articulos vendidos en una fecha especifica', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(200,5, 'Fecha de venta: ',0,1,'C');
		$pdf->Cell(200,5, 'Del: '.$dia.' de '.$meses[$mes].' del '.$ano ,0,1,'C');
		$pdf->Cell(200,5, 'Al : '.$Hdia.' de '.$meses[$Hmes].' del '.$Hano ,0,1,'C');
		$pdf->Cell(200,5, 'Sucursal: General',0,0,'C');
		$pdf->Ln(10);

		$pdf->Setfillcolor(232,232,232);
		$pdf->SetFont('Arial','B', 12);
		
		$pdf->Cell(30, 6, 'Linea', 1, 0, 'C', 1);
		$pdf->Cell(30, 6, 'Codigo', 1, 0, 'C', 1);
		$pdf->Cell(65, 6, 'Descripcion', 1, 0, 'C', 1);
		$pdf->Cell(17, 6, 'Unidad', 1, 0, 'C', 1);
		$pdf->Cell(30, 6, 'Precio', 1, 0, 'C', 1);
		$pdf->Cell(20, 6, 'Fecha', 1, 0, 'C', 1);
		$pdf->Ln();

		
		$pdf->SetFont('Arial','', 10);
		$idLineaAnterior = '';
		$query = $connection->query($sql);
			foreach($query->fetchAll() as $row)
			{
				if ($idLineaAnterior != $row['idLinea']) {
					$idLineaAnterior = $row['idLinea'];
					$lineaShow = $row['Linea'];
					$idLineaShow = $row['idLinea'];
				}else{
					$lineaShow = '';
					$idLineaShow = '';
				}
				$monto = floor($row['monto']*pow(10,2))/pow(10	,2);
				//$pdf->Cell(15, 6, $idLineaShow, 1, 0, 'C');
				$pdf->Cell(30, 6, $lineaShow, 1, 0, 'C');
				$pdf->Cell(30, 6, $row['codigo'], 1, 0, 'C');
				$pdf->Cell(65, 6, $row['Descripcion'], 1, 0, 'C');
				$pdf->Cell(17, 6, ($row['tipo'])*-1, 1, 0, 'C');
				$pdf->Cell(30, 6, $monto, 1, 0, 'c');
				$pdf->Cell(20, 6, $row['fecha'], 1, 0, 'C');
				$pdf->Ln();

			}

		$pdf ->Output();
	

?>