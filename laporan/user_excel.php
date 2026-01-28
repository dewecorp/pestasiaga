<?php
include "../config/koneksi.php";
$filename = "user-(" . date('d-m-Y') . ").xls";
header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms.excel");
?>
<h2 align="center">Data User</h2>
<h2 align="center">Pesta Siaga Kwarran Kedung
<?= date('Y') ?></h2>
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