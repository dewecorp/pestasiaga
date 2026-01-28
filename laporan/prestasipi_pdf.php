<?php
require('../assets/vendor/setasign/fpdf/fpdf.php');
$pdf = new FPDF('P', 'cm', 'Legal');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Halo PDF!!!');
$pdf->Output();