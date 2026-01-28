<?php
include"../config/koneksi.php";
$filename = "juri-(" . date('d-m-Y') . ").xls";
header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms.excel");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dewan Juri</title>
</head>

<body>

    <h2 align="center">Dewan Juri</h2>
    <h2 align="center">Pesta Siaga Kwarran Kedung
        <?= date('Y') ?></h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Nama Juri</th>
            <th>Pangkalan</th>
            <th>Koordinator Taman</th>
            <th>No HP/WA</th>
        </tr>
        <?php
            $no = 1;
            $sql = $koneksi->query("SELECT * FROM tb_juri
                    JOIN tb_taman ON tb_juri.id_taman = tb_taman.id_taman
            JOIN tb_peserta_pa ON tb_juri.id_pa = tb_peserta_pa.id_pa");
            while ($data = $sql->fetch_assoc()) {
            ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nama_juri']; ?></td>
            <td><?= $data['pangkalan']; ?></td>
            <td><?= $data['nama_taman']; ?></td>
            <td><?= $data['no_hp']; ?></td>
        </tr>
        <?php
            }
            ?>
    </table>
</body>

</html>