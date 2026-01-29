<?php
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, ketua_juri FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat']) ? $data_panitia['tempat'] : 'Jepara';
$ketua_juri = isset($data_panitia['ketua_juri']) ? $data_panitia['ketua_juri'] : '..................';
$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
$filename = "rekappi-(" . date('d-m-Y') . ").xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");
?>
<h2 align="center">Rekap Nilai Barung Putri</h2>
<h2 align="center"><?= $nama_kegiatan ?></h2>
<table border="1">
	<tr>
		<th>No.</th>
		<th style="width: 20px;">Nomor Dada</th>
		<th style="width: 100px;">Nama Pangkalan</th>
		<th>Ketakwaan</th>
		<th>Toleransi</th>
		<th>Tanda Pengenal</th>
		<th>Rangking 1</th>
		<th>KIM</th>
		<th>Scout Skills</th>
		<th>LBB</th>
		<th>Kereta Bola</th>
		<th>Seni Budaya</th>
		<th>Bumbung Peduli</th>
		<th>Nilai Akhir</th>
		
	</tr>
	<?php
	$no = 1;
	
	$sql = $koneksi->query("SELECT * FROM tb_rekap_pi
	RIGHT JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi ORDER BY no_dada ASC") or die ($koneksi->error);
	while($data = $sql->fetch_assoc()) {
	
	?>
	<tr>
		<td align="center"><?=$no++;?></td>
		<td align="center"><?=$data['no_dada'];?></td>
		<td><?=$data['pangkalan'];?></td>
		<td align="center"><?=$data['ketakwaan'];?></td>
		<td align="center"><?=$data['toleransi'];?></td>
		<td align="center"><?=$data['tanda_pengenal'];?></td>
		<td align="center"><?=$data['rangking'];?></td>
		<td align="center"><?=$data['kim'];?></td>
		<td align="center"><?=$data['scout_skill'];?></td>
		<td align="center"><?=$data['lbb'];?></td>
		<td align="center"><?=$data['kereta_bola'];?></td>
		<td align="center"><?=$data['seni_budaya'];?></td>
		<td align="center"><?=$data['bumbung'];?></td>
		<td align="center"><?=$data['nilai_akhir_pi'];?></td>
		
	</tr>
	<?php
	}
	?>
</table>
<br>
<table border="0">
    <tr>
        <td colspan="10"></td>
        <td colspan="4" align="center">
            <?= $tempat ?>, <?= $tanggal_indo ?><br>
            Ketua Dewan Juri<br>
            <br><br><br>
            <b><u><?= $ketua_juri ?></u></b>
        </td>
    </tr>
</table>
<br>
<div style="text-align: left; font-style: italic;">Dicetak pada: <?= date('d-m-Y H:i:s') ?></div>
