<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
require('../assets/vendor/setasign/fpdf/fpdf.php');
include "../admin/page/juaraumum/juara_logic.php";

$pdf = new FPDF('P', 'cm', 'Legal', 'en');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->ln(0.5);
$pdf->Cell(0, 0, 'JUARA UMUM', 0, 1, 'C');
$pdf->ln(1);
$pdf->Cell(0, 0, strtoupper($nama_kegiatan), 0, 1, 'C');
$pdf->ln(1);

// Headers
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(1, 1.5, 'No.', 1, 0, 'C');
$pdf->Cell(6.5, 1.5, 'Pangkalan', 1, 0, 'C');
$pdf->Cell(3, 1.5, 'Nilai Pa', 1, 0, 'C');
$pdf->Cell(3, 1.5, 'Nilai Pi', 1, 0, 'C');
$pdf->Cell(3, 1.5, 'Total', 1, 0, 'C');
$pdf->Cell(3, 1.5, 'Ket', 1, 0, 'C');
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
    
    $pdf->Cell(1, 1, $no++ . ".", 1, 0, 'C');
    $pdf->Cell(6.5, 1, $pangkalan, 1, 0);
    $pdf->Cell(3, 1, $data['nilai_pa'], 1, 0, 'C');
    $pdf->Cell(3, 1, $data['nilai_pi'], 1, 0, 'C');
    $pdf->Cell(3, 1, $data['nilai'], 1, 0, 'C');
    $pdf->Cell(3, 1, $predikat, 1, 0, 'C');
    $pdf->ln(1);
}

ob_end_clean();
$pdfContent = $pdf->Output('S');
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="juara_umum.pdf"');
header('Content-Length: ' . strlen($pdfContent));
echo $pdfContent;
exit;
?>