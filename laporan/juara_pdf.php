<?php
include"../config/koneksi.php";
require('../assets/vendor/setasign/fpdf/fpdf.php');
include "../admin/page/juaraumum/juara_logic.php";

$pdf = new FPDF('P', 'cm', 'Legal', 'en');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->ln(0.5);
$pdf->Cell(0, 0, 'JUARA UMUM', 0, 1, 'C');
$pdf->ln(1);
$pdf->Cell(0, 0, 'PESTA SIAGA KWARRAN KEDUNG '.date('Y'), 0, 1, 'C');
$pdf->ln(1);

// Headers
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(1.5, 1.5, 'No.', 1, 0, 'C');
$pdf->Cell(6, 1.5, 'Pangkalan', 1, 0, 'C');
$pdf->Cell(2, 1.5, 'Emas', 1, 0, 'C');
$pdf->Cell(2, 1.5, 'Perak', 1, 0, 'C');
$pdf->Cell(2, 1.5, 'Perunggu', 1, 0, 'C');
$pdf->Cell(2.5, 1.5, 'Total Nilai', 1, 0, 'C');
$pdf->Cell(4, 1.5, 'Keterangan', 1, 0, 'C');
$pdf->ln(1.5);

$pdf->SetFont('Arial', '', 10);
$no = 1;

foreach($stats as $pangkalan => $data) {
    $predikat = "";
    switch ($no) {
        case 1: $predikat = "Juara Umum I"; break;
        case 2: $predikat = "Juara Umum II"; break;
        case 3: $predikat = "Juara Umum III"; break;
        case 4: $predikat = "Harapan I"; break;
        case 5: $predikat = "Harapan II"; break;
        case 6: $predikat = "Harapan III"; break;
    }
    
    $pdf->Cell(1.5, 1, $no++ . ".", 1, 0, 'C');
    $pdf->Cell(6, 1, $pangkalan, 1, 0);
    $pdf->Cell(2, 1, $data['emas'], 1, 0, 'C');
    $pdf->Cell(2, 1, $data['perak'], 1, 0, 'C');
    $pdf->Cell(2, 1, $data['perunggu'], 1, 0, 'C');
    $pdf->Cell(2.5, 1, $data['nilai'], 1, 0, 'C');
    $pdf->Cell(4, 1, $predikat, 1, 0, 'C');
    $pdf->ln(1);
}

$pdf->Output();
?>