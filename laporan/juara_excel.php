<?php
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
include "../admin/page/juaraumum/juara_logic.php";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Juara_Umum.xls");
?>
<center>
    <h3>JUARA UMUM<br><?= $nama_kegiatan ?></h3>
</center>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Pangkalan</th>
            <th>Emas</th>
            <th>Perak</th>
            <th>Perunggu</th>
            <th>Total Nilai</th>
            <th>Keterangan</th>
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
            <td><?=$no++?></td>
            <td><?=$pangkalan?></td>
            <td><?=$data['emas']?></td>
            <td><?=$data['perak']?></td>
            <td><?=$data['perunggu']?></td>
            <td><?=$data['nilai']?></td>
            <td><?=$predikat?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>