<?php

	require 'C:/xampp/htdocs/PDV/pdf/fpdf/fpdf.php';
	
	class PDF Extends FPDF
	{

		function Header()
		{

			$this->Image('images/logo.png', 10, 10, -300 );
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(40);
			$this->Cell(100,10, 'Detalle de articulos vendidos en una fecha especifica', 0, 0, 'C');

			$this->Ln(30);
		}

		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0, 10, 'Pagina ', $this->PageNo().'/{nb}',0,0,'C' );	

		}

	}




?>