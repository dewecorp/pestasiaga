<?php

include"../config/koneksi.php";
$id = @$_GET['id'];
// $sql = $koneksi->query("SELECT * FROM tb_juara WHERE id_juara='$id'");
require('../assets/vendor/setasign/fpdf/fpdf.php');


$pdf = new FPDF('P', 'cm', 'Legal', 'en');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->ln(0.5);
$pdf->Cell(0, 0, 'JUARA UMUM', 0, 1, 'C');
$pdf->ln(1);
$pdf->Cell(0, 0, 'PESTA SIAGA KWARRAN KEDUNG '.date('Y'), 0, 1, 'C');
$pdf->ln(1);
$pdf->Cell(1.5, 1.5, 'No.', 1, 0, 'C');
$pdf->Cell(8, 1.5, 'Pangkalan', 1, 0, 'C');
$pdf->Cell(2.5, 1.5, 'Nilai Putra', 1, 0, 'C');
$pdf->Cell(2.5, 1.5, 'Nilai Putri', 1, 0, 'C');
$pdf->Cell(2.5, 1.5, 'Total Nilai', 1, 0, 'C');
$pdf->Cell(2.5, 1.5, 'Juara', 1, 0, 'C');
$pdf->ln(1.5);

$no = 1;
$sql = $koneksi->query("SELECT * FROM tb_juara
        RIGHT JOIN tb_peserta_pa ON tb_juara.id_pa = tb_peserta_pa.id_pa
        RIGHT JOIN tb_peserta_pi ON tb_juara.id_pi = tb_peserta_pi.id_pi
        LEFT JOIN tb_rekap ON tb_juara.id_rekap = tb_rekap.id_rekap
        LEFT JOIN tb_rekap_pi ON tb_juara.id_rekap_pi = tb_rekap_pi.id_rekap_pi ORDER BY total_nilai DESC");
while ($data = $sql->fetch_assoc()) {
    $total_nilai = $data['nilai_akhir_pa'] + $data['nilai_akhir_pi'];

    $pdf->Cell(1.5, 1.5, '' . $no++ . "." . '', 1, 0, 'C');
    $pdf->Cell(8, 1.5, '' .$data['pangkalan']. '', 1, 0);
    $pdf->Cell(2.5, 1.5, ''.$data['nilai_akhir_pa']. '', 1, 0, 'C');
    $pdf->Cell(2.5, 1.5, ''.$data['nilai_akhir_pi']. '', 1, 0, 'C');
    $pdf->Cell(2.5, 1.5, ''.$total_nilai.'', 1, 0, 'C');
    $pdf->Cell(2.5, 1.5, 'Juara I', 1, 0, 'C');
    $pdf->ln(1.5);
}
$pdf->Output();
