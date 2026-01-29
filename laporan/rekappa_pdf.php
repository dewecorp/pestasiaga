<?php
ob_start();
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, tempat_ttd, ketua_juri, logo FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat_ttd']) ? $data_panitia['tempat_ttd'] : 'Jepara';
$ketua_juri = isset($data_panitia['ketua_juri']) ? $data_panitia['ketua_juri'] : '..................';
$logo = isset($data_panitia['logo']) ? $data_panitia['logo'] : '';
$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
$content = '
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Rekap Nilai Barung Putra</title>
</head>
<body>
	<style type="text/css">
    @page { size: landscape; }
	.table{padding-left: 40px; padding-top: 10px; border-collapse: collapse; width: 100%;}
	.table th{padding: 8px 5px; background-color: #cccccc; border: 1px solid black;}
	.table td{padding: 8px 5px; border: 1px solid black;}
	</style>
	';
    $content .= '
	
	<table style="width: 100%; border: none; margin-bottom: 20px;">
		<tr>
			<td style="width: 10%; text-align: left; vertical-align: middle; border: none;">
				'.(!empty($logo) ? '<img src="../assets/images/'.$logo.'" style="height: 80px; width: auto;">' : '').'
			</td>
			<td style="width: 90%; text-align: center; vertical-align: middle; border: none;">
				<h4 style="margin: 0;">Rekap Nilai Barung Putra</h4>
				<h4 style="margin: 5px 0 0 0;">'.$nama_kegiatan.'</h4>
			</td>
		</tr>
	</table>
	<table border="1" class="table">
		<tr>
			
			<th style="width: 6px;">No.</th>
			<th align="center">No. Dada</th>
			<th align="center">Nama Pangkalan</th>
			<th>Ketakwaan</th>
			<th>Toleransi</th>
			<th>Tanda Pengenal</th>
			<th>Rangking 1</th>
			<th>KIM</th>
			<th>Scout</th>
			<th>LBB</th>
			<th>Kereta Bola</th>
			<th>Seni Budaya</th>
			<th>Bumbung</th>
			<th>Nilai Akhir</th>
			
		</tr>';
        $no = 1;
        
        $sql = $koneksi->query("SELECT * FROM tb_rekap
		RIGHT JOIN tb_peserta_pa ON tb_rekap.id_pa = tb_peserta_pa.id_pa ORDER BY no_dada ASC") or die($koneksi->error);
        while ($data = $sql->fetch_assoc()) {
            $filename = "rekappa-".date('d-m-Y').".pdf";
            $content.= '
		<tr>
			<td>'.$no++.'</td>
			<td align="center">'.$data['no_dada'].'</td>
			<td>'.$data['pangkalan'].'</td>
			<td align="center">'.$data['ketakwaan'].'</td>
			<td align="center">'.$data['toleransi'].'</td>
			<td align="center">'.$data['tanda_pengenal'].'</td>
			<td align="center">'.$data['rangking'].'</td>
			<td align="center">'.$data['kim'].'</td>
			<td align="center">'.$data['scout_skill'].'</td>
			<td align="center">'.$data['lbb'].'</td>
			<td align="center">'.$data['kereta_bola'].'</td>
			<td align="center">'.$data['seni_budaya'].'</td>
			<td align="center">'.$data['bumbung'].'</td>
			<td align="center">'.$data['nilai_akhir_pa'].'</td>
		</tr>
		';
        }
        $content.='
	</table>
    <br>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 70%;"></td>
            <td style="width: 30%; text-align: center;">
                ' . $tempat . ', ' . $tanggal_indo . '<br>
                Ketua Dewan Juri<br>
                <br><br><br>
                <b><u>' . $ketua_juri . '</u></b>
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

