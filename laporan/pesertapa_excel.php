<?php
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, ketua_panitia FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$filename = "pesertapa-(" . date('d-m-Y') . ").xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");
?>
<h2 align="center">Peserta Barung Putra</h2>
<h2 align="center"><?= $nama_kegiatan ?></h2>
<table border="1">
    <tr>
        <th>No.</th>
        <th>Nomor Dada</th>
        <th>Nama Pangkalan</th>
        <th>Nama Pembina</th>

    </tr>
    </thead>
    <tbody>
        <?php
			$no = 1;
			$sql = $koneksi->query("SELECT * FROM tb_peserta_pa ORDER BY no_dada ASC") or die ($koneksi->error);
			while ($data = $sql->fetch_assoc()) {
	     ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['no_dada'];?></td>
            <td><?=$data['pangkalan'];?></td>
            <td><?=$data['pembina'];?></td>

        </tr>
        <?php
			}
			?>
</table>
<br>
<table border="0">
    <tr>
        <td colspan="2"></td>
        <td colspan="2" align="center">
            <?= $tempat ?>, <?= $tanggal_indo ?><br>
            Ketua Panitia<br>
            <br><br><br>
            <b><u><?= $ketua_panitia ?></u></b>
        </td>
    </tr>
</table>
<br>
<div style="text-align: left; font-style: italic;">Dicetak pada: <?= date('d-m-Y H:i:s') ?></div>
