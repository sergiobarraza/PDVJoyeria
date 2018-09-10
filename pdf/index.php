<?php
	require 'fpdf/fpdf.php';
	$pdf = new FPDF();
	$pdf ->Addpage();
	$pdf ->Output();

?>