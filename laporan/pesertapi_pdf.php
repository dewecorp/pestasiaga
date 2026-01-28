<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, tempat_ttd, ketua_panitia FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat_ttd']) ? $data_panitia['tempat_ttd'] : 'Jepara';
$ketua_panitia = isset($data_panitia['ketua_panitia']) ? $data_panitia['ketua_panitia'] : '..................';
$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
$content = '
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Peserta Barung Putri</title>
</head>
<body>
	<style type="text/css">
	.table{padding: 40px 100px; border-collapse: collapse; width: 100%; margin: 0 auto;}
	.table th{padding: 8px 8px; background-color: #cccccc; border: 1px solid black;}
	.table td{padding: 8px 8px; border: 1px solid black;}
	</style>
	';
    $content .= '
	<h2 align="center">Peserta Barung Putri</h2>
	<h2 align="center">'.$nama_kegiatan.'</h2>
	<table border="1" class="table">
		<tr>
			<th style="padding: 8px 8px;">No.</th>
			<th style="padding: 8px 8px;">Nomor Dada</th>
			<th style="padding: 8px 8px;">Nama Pangkalan</th>
			<th style="padding: 8px 8px;">Nama Pembina</th>
			
		</tr>';
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM tb_peserta_pi ORDER BY no_dada ASC") or die($koneksi->error);
        while ($data = $sql->fetch_assoc()) {
            $filename = "pesertapi-".date('d-m-Y').".pdf";
            $content.= '
		<tr>
			<td>'.$no++.'</td>
			<td>'.$data['no_dada'].'</td>
			<td>'.$data['pangkalan'].'</td>
			<td>'.$data['pembina'].'</td>
			
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
</body>
</html>
<script>window.print();</script>
';
echo $content;
exit;

