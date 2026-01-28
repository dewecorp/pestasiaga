<?php
include "../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
$filename = "barung-berprestasi-putri-(" . date('d-m-Y') . ").xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");
?>
<h2 align="center">Barung Berprestasi Putri</h2>
<h2 align="center"><?= $nama_kegiatan ?></h2>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nomor Dada</th>
            <th>Pangkalan</th>
            <th>Total Nilai</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM tb_rekap_pi 
                              JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                              ORDER BY CAST(nilai_akhir_pi AS UNSIGNED) DESC LIMIT 6");
        
        while ($data = $sql->fetch_assoc()) {
            $predikat = "";
            switch ($no) {
                case 1: $predikat = "Tergiat I"; break;
                case 2: $predikat = "Tergiat II"; break;
                case 3: $predikat = "Tergiat III"; break;
                case 4: $predikat = "Harapan I"; break;
                case 5: $predikat = "Harapan II"; break;
                case 6: $predikat = "Harapan III"; break;
            }
        ?>
        <tr>
            <td><?=$no++."."; ?></td>
            <td><?=$data['no_dada']; ?></td>
            <td><?=$data['pangkalan']; ?></td>
            <td><?=$data['nilai_akhir_pi']; ?></td>
            <td><?=$predikat; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
