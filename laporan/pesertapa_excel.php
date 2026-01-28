<?php
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$filename = "pesertapa-(" . date('d-m-Y') . ").xls";
header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms.excel");
?>
<h2 align="center">Peserta Barung Putra</h2>
<h2 align="center">Pesta Siaga Kwarran Kedung
    <?= date('Y') ?></h2>
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