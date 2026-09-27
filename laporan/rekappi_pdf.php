<?php
ob_start();
include "../config/koneksi.php";
include_once "../config/qrcode.php";

$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, tempat_ttd, ketua_panitia, logo FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat_ttd']) && !empty($data_panitia['tempat_ttd']) ? $data_panitia['tempat_ttd'] : (isset($data_panitia['tempat']) ? $data_panitia['tempat'] : 'Jepara');
$ketua_panitia = isset($data_panitia['ketua_panitia']) ? $data_panitia['ketua_panitia'] : '..................';
$logo = isset($data_panitia['logo']) ? $data_panitia['logo'] : '';

$qr_text = "VERIFIKASI TTE DOKUMEN SAH\nKetua Panitia: " . $ketua_panitia . "\n" . strtoupper($nama_kegiatan);
$qr_signature = generate_qr_base64($qr_text);

$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');

$content = '
<!DOCTYPE html>
<html>
<head>
    <title>Cetak REKAP NILAI BARUNG PUTRI</title>
</head>
<body>
	<style type="text/css">
    @page { size: landscape; }
	.table{padding-left: 40px; padding-top: 10px; border-collapse: collapse; width: 100%;}
	.table th{padding: 8px 5px; background-color: #cccccc; border: 1px solid black;}
	.table td{padding: 8px 5px; border: 1px solid black;}
	</style>

	<table style="width: 100%; border: none; margin-bottom: 20px;">
		<tr>
			<td style="width: 10%; text-align: left; vertical-align: middle; border: none;">
				'.(!empty($logo) ? '<img src="../assets/images/'.$logo.'" style="height: 80px; width: auto;">' : '').'
			</td>
			<td style="width: 90%; text-align: center; vertical-align: middle; border: none;">
				<h4 style="margin: 0;">REKAP NILAI BARUNG PUTRI</h4>
				<h4 style="margin: 5px 0 0 0;">'.strtoupper($nama_kegiatan).'</h4>
			</td>
		</tr>
	</table>
	<table border="1" class="table">
		<tr>
			<th style="width: 5px;">No.</th>
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

        $sql = $koneksi->query("SELECT * FROM tb_rekap_pi
		RIGHT JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi ORDER BY no_dada ASC");
        while ($data = $sql->fetch_assoc()) {
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
			<td align="center">'.$data['nilai_akhir_pi'].'</td>
		</tr>
		';
        }
        $content.='
	</table>
    <br>
    <table style="width: 100%; border: none; margin-top: 15px;">
        <tr>
            <td style="width: 70%;"></td>
            <td style="width: 30%; text-align: center; vertical-align: top;">
                ' . $tempat . ', ' . $tanggal_indo . '<br>
                Ketua Panitia<br>
                <div style="margin: 5px 0;">
                    <img src="' . $qr_signature . '" style="width: 70px; height: 70px;">
                </div>
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
?>
