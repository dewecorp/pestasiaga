<?php
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
$filename = "taman-(" . date('d-m-Y') . ").xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Taman</title>
</head>

<body>

    <h2 align="center">Data Taman</h2>
    <h2 align="center"><?= $nama_kegiatan ?></h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Nama Taman</th>
            <th>Lokasi</th>
        </tr>
        <?php
            $no = 1;
            $sql = $koneksi->query("SELECT * FROM tb_taman ORDER BY nama_taman ASC");
            while ($data = $sql->fetch_assoc()) {
            ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nama_taman']; ?></td>
            <td><?= $data['lokasi']; ?></td>
        </tr>
        <?php
            }
            ?>
    </table>
</body>

</html>
