<?php
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$filename = "rekappi-(" . date('d-m-Y') . ").xls";
header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms.excel");
?>
<h2 align="center">Rekap Nilai Barung Putri</h2>
<h2 align="center">Pesta Siaga Kwarran Kedung
<?= date('Y') ?></h2>
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