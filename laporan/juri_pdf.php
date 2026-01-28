<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
$filename = "juri-".date('d-m-Y').".pdf";
$content = '
<page>
    <style type="text/css">
        .table{padding: 20px; border-collapse: collapse;}
        .table th{padding: 8px 5px; background-color: #cccccc;}
        .table td{padding: 8px 5px;}
        .h4 {padding-bottom: 2px;}
    </style>
    ';
    $content .= '
   
    <h2 align="center">Dewan Juri</h2>
    <h2 align="center">'.$nama_kegiatan.'</h2>
    <table border="1" class="table">
        <tr>
            <th style="padding: 8px 5px;">No.</th>
            <th style="padding: 8px 5px;">Nama Juri</th>
            <th style="padding: 8px 5px;">Pangkalan</th>
            <th style="padding: 8px 5px;">Koordinator Taman</th>
            <th style="padding: 8px 5px;">No. HP/WA</th>
        </tr>';
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM tb_juri
        JOIN tb_taman ON tb_juri.id_taman = tb_taman.id_taman
        JOIN tb_peserta_pa ON tb_juri.id_pa = tb_peserta_pa.id_pa");
        while ($data = $sql->fetch_assoc()) {
            $content.= '
        <tr>
            <td>'.$no++.'</td>
            <td>'.$data['nama_juri'].'</td>
            <td>'.$data['pangkalan'].'</td>
            <td>'.$data['nama_taman'].'</td>
            <td>'.$data['no_hp'].'</td>
        </tr>
        ';
        }
        $content.='
    </table>
    <br>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                ' . $tempat . ', ' . $tanggal_indo . '<br>
                Ketua Panitia<br>
                <br><br><br>
                <b><u>' . $ketua_panitia . '</u></b>
            </td>
        </tr>
    </table>
    <br>
    <div style="text-align: left; font-style: italic; font-size: 10px;">Dicetak pada: '.date('d-m-Y H:i:s').'</div>
</page>
';
require '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'F4', 'EN');
$html2pdf->writeHTML($content);
$html2pdf->pdf->IncludeJS('print(true);');
ob_end_clean();
$pdfContent = $html2pdf->output($filename, 'S');
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Length: ' . strlen($pdfContent));
echo $pdfContent;
exit;
