<?php
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, ketua_panitia FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat']) ? $data_panitia['tempat'] : 'Jepara';
$ketua_panitia = isset($data_panitia['ketua_panitia']) ? $data_panitia['ketua_panitia'] : '..................';
$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
$filename = "juri-(" . date('d-m-Y') . ").xls";
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
    <title>Dewan Juri</title>
</head>

<body>

    <h2 align="center">Dewan Juri</h2>
    <h2 align="center"><?= $nama_kegiatan ?></h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Nama Juri</th>
            <th>Pangkalan / Instansi</th>
            <th>Koordinator Taman</th>
            <th>No HP/WA</th>
        </tr>
        <?php
            $no = 1;
            $sql = $koneksi->query("SELECT j.*, t.nama_taman,
                COALESCE(NULLIF(j.pangkalan, ''), p.pangkalan, '-') AS pangkalan_instansi
            FROM tb_juri j
            LEFT JOIN tb_taman t ON j.id_taman = t.id_taman
            LEFT JOIN tb_peserta_pa p ON j.id_pa = p.id_pa
            ORDER BY j.id_juri ASC");
            while ($data = $sql->fetch_assoc()) {
            ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['nama_juri']); ?></td>
            <td><?= htmlspecialchars($data['pangkalan_instansi']); ?></td>
            <td><?= htmlspecialchars($data['nama_taman'] ?? '-'); ?></td>
            <td><?= htmlspecialchars($data['no_hp']); ?></td>
        </tr>
        <?php
            }
            ?>
    </table>
    <br>
    <div style="text-align: left; font-style: italic;">Dicetak pada: <?= date('d-m-Y H:i:s') ?></div>
</body>

</html>
