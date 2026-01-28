<?php
include "../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$filename = "user-(" . date('d-m-Y') . ").xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");
?>
<h2 align="center">Data User</h2>
<h2 align="center"><?= $nama_kegiatan ?></h2>
<table border="1">
	<tr>
		<th>No.</th>
		<th>Username</th>
		<th>Password</th>
		<th>Nama</th>
		<th>Level</th>
	</tr>
</thead>
<tbody>
	<?php
		$no = 1;
		$sql = $koneksi->query("SELECT * FROM tb_user");
		while($data = $sql->fetch_assoc()) {
		$level = ($data['level'] == 'admin') ? "Admin" : "User";
	?>
	<tr>
		<td><?=$no++;?></td>
		<td><?=$data['username'];?></td>
		<td><?=$data['password'];?></td>
		<td><?=$data['nama'];?></td>
		<td><?=$level?></td>
	</tr>
	<?php
	}
	?>
</table>
<br>
<table border="0">
    <tr>
        <td colspan="3"></td>
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
