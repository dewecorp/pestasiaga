<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan, tempat, tempat_ttd, ketua_panitia FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = (isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung') . ' ' . date('Y');
$tempat = isset($data_panitia['tempat_ttd']) ? $data_panitia['tempat_ttd'] : 'Jepara';
$ketua_panitia = isset($data_panitia['ketua_panitia']) ? $data_panitia['ketua_panitia'] : '..................';
$bulan_indo = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tanggal_indo = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');

include "../admin/page/juaraumum/juara_logic.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Juara Umum</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { border-collapse: collapse; width: 100%; margin: 0 auto; }
        .table th, .table td { border: 1px solid black; padding: 8px 5px; text-align: center; }
        .table th { background-color: #cccccc; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3, .header h4 { margin: 5px 0; }
        .signature-table { width: 100%; border: none; margin-top: 20px; }
        .signature-table td { border: none; text-align: center; }
        .footer { text-align: left; font-style: italic; font-size: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>JUARA UMUM</h3>
        <h4><?= strtoupper($nama_kegiatan) ?></h4>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 35%;">Pangkalan</th>
                <th style="width: 15%;">Nilai Pa</th>
                <th style="width: 15%;">Nilai Pi</th>
                <th style="width: 15%;">Total</th>
                <th style="width: 15%;">Ket</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach($stats as $pangkalan => $data) {
                $predikat = "";
                switch ($no) {
                    case 1: $predikat = "Juara Umum I"; break;
                    case 2: $predikat = "Juara Umum II"; break;
                    case 3: $predikat = "Juara Umum III"; break;
                    case 4: $predikat = "Harapan I"; break;
                    case 5: $predikat = "Harapan II"; break;
                    case 6: $predikat = "Harapan III"; break;
                }
            ?>
            <tr>
                <td><?= $no++ ?>.</td>
                <td style="text-align: left; padding-left: 10px;"><?= $pangkalan ?></td>
                <td><?= $data['nilai_pa'] ?></td>
                <td><?= $data['nilai_pi'] ?></td>
                <td><?= $data['nilai'] ?></td>
                <td><?= $predikat ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">
                <?= $tempat . ', ' . $tanggal_indo ?><br>
                Ketua Panitia<br>
                <br><br><br>
                <b><u><?= $ketua_panitia ?></u></b>
            </td>
        </tr>
    </table>

    <div class="footer">Dicetak pada: <?= date('d-m-Y H:i:s') ?></div>

    <script>window.print();</script>
</body>
</html>
