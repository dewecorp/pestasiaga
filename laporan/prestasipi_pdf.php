<?php
ob_start();
include "../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
$content = '
<page>
    <style type="text/css">
    .table{border-collapse: collapse; width: 100%; margin: 0 auto;}
    .table th{padding: 8px 5px; background-color: #cccccc; text-align: center; font-weight: bold;}
    .table td{padding: 8px 5px;}
    </style>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <h3 style="margin: 5px 0;">Barung Berprestasi Putri</h3>
        <h4 style="margin: 5px 0;">'.$nama_kegiatan.'</h4>
    </div>

    <table border="1" class="table" align="center">
        <thead>
            <tr>
                <th style="width: 40px;">No.</th>
                <th style="width: 100px;">No. Dada</th>
                <th style="width: 250px;">Nama Pangkalan</th>
                <th style="width: 100px;">Total Nilai</th>
                <th style="width: 150px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>';
        
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM tb_rekap_pi 
                              JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                              ORDER BY CAST(nilai_akhir_pi AS UNSIGNED) DESC LIMIT 6");
        while ($data = $sql->fetch_assoc()) {
            $predikat = "";
            switch ($no) {
                case 1: $predikat = "Tergiat I"; break;
                case 2: $predikat = "Tergiat II"; break;
                case 3: $predikat = "Tergiat III"; break;
                case 4: $predikat = "Harapan I"; break;
                case 5: $predikat = "Harapan II"; break;
                case 6: $predikat = "Harapan III"; break;
            }
            $content.= '
            <tr>
                <td align="center">'.$no++.'</td>
                <td align="center">'.$data['no_dada'].'</td>
                <td>'.$data['pangkalan'].'</td>
                <td align="center">'.$data['nilai_akhir_pi'].'</td>
                <td align="center">'.$predikat.'</td>
            </tr>';
        }
        $content.='
        </tbody>
    </table>
</page>
';

require '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'en');
    $html2pdf->writeHTML($content);
    $html2pdf->pdf->IncludeJS('print(true);');
    $filename = "barung-berprestasi-putri-".date('d-m-Y').".pdf";
    ob_end_clean();
    $pdfContent = $html2pdf->output($filename, 'S');
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($pdfContent));
    echo $pdfContent;
    exit;
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>
