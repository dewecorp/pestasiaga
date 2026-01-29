<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, tempat_ttd, ketua_panitia, logo FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat_ttd']) ? $data_panitia['tempat_ttd'] : 'Jepara';
$ketua_panitia = isset($data_panitia['ketua_panitia']) ? $data_panitia['ketua_panitia'] : '..................';
$logo = isset($data_panitia['logo']) ? $data_panitia['logo'] : '';
$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
$filename = "taman-".date('d-m-Y').".pdf";
$content = '
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Taman</title>
</head>
<body>
    <style type="text/css">
        .table{padding: 20px; border-collapse: collapse; margin: 0 auto; width: 100%;}
        .table th{padding: 8px 5px; background-color: #cccccc; border: 1px solid black;}
        .table td{padding: 8px 5px; border: 1px solid black;}
        .h4 {padding-bottom: 2px;}
    </style>
    ';
    $content .= '
   
    <table style="width: 100%; border: none; margin-bottom: 20px;">
        <tr>
            <td style="width: 10%; text-align: left; vertical-align: middle; border: none;">
                '.(!empty($logo) ? '<img src="../assets/images/'.$logo.'" style="height: 80px; width: auto;">' : '').'
            </td>
            <td style="width: 90%; text-align: center; vertical-align: middle; border: none;">
                <h2 style="margin: 5px 0;">Data Taman</h2>
                <h2 style="margin: 5px 0;">'.$nama_kegiatan.'</h2>
            </td>
        </tr>
    </table>
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
    <div style="text-align: left; font-style: italic; font-size: 10px;">Dicetak pada: ' . date('d-m-Y H:i:s') . '</div>
</body>
</html>
<script>window.print();</script>
';

echo $content;

