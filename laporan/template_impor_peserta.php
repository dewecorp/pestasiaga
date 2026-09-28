<?php
include "../config/koneksi.php";
$jenis_code = $_GET['jenis'] ?? 'pa';
$jenis_name = ($jenis_code === 'pi') ? 'Putri' : 'Putra';
$filename = "Template_Impor_Peserta_Barung_" . $jenis_name . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h3>TEMPLATE IMPOR PESERTA BARUNG <?= strtoupper($jenis_name) ?></h3>
    <p><i>Catatan: Kolom Nomor Dada tidak perlu diisi. Nomor dada akan terisi otomatis oleh sistem.</i></p>
    <table border="1">
        <thead>
            <tr style="background-color: #4CAF50; color: #ffffff; font-weight: bold; text-align: center;">
                <th style="width: 50px;">No</th>
                <th style="width: 250px;">Nama Pangkalan</th>
                <th style="width: 200px;">Nama Pembina</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">1</td>
                <td>SDN 1 Kedung</td>
                <td>Budi Santoso, S.Pd.</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td>SDN 2 Kedung</td>
                <td>Siti Rahma, S.Pd.</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
