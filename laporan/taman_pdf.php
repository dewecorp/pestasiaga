<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
$filename = "taman-".date('d-m-Y').".pdf";
$content = '
<page>
    <style type="text/css">
        .table{padding: 20px; border-collapse: collapse; margin: 0 auto; width: 100%;}
        .table th{padding: 8px 5px; background-color: #cccccc;}
        .table td{padding: 8px 5px;}
        .h4 {padding-bottom: 2px;}
    </style>
    ';
    $content .= '
   
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 5px 0;">Data Taman</h2>
        <h2 style="margin: 5px 0;">'.$nama_kegiatan.'</h2>
    </div>
    <table border="1" class="table" align="center">
        <tr>
            <th style="padding: 8px 5px; width: 5%;">No.</th>
            <th style="padding: 8px 5px; width: 45%;">Nama Taman</th>
            <th style="padding: 8px 5px; width: 50%;">Lokasi</th>
        </tr>';
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM tb_taman ORDER BY nama_taman ASC");
        while ($data = $sql->fetch_assoc()) {
            $content.= '
        <tr>
            <td>'.$no++.'</td>
            <td>'.$data['nama_taman'].'</td>
            <td>'.$data['lokasi'].'</td>
        </tr>
        ';
        }
        $content.='
    </table>
</page>
';
require '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'A4', 'EN');
$html2pdf->writeHTML($content);
$html2pdf->pdf->IncludeJS('print(true);');
ob_end_clean();
$pdfContent = $html2pdf->output($filename, 'S');
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Length: ' . strlen($pdfContent));
echo $pdfContent;
exit;
