<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_juara WHERE id_juara='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Juara Umum</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-blue">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">school</i> Juara Umum</li>
        </ol>
    </div>
    <div class="row clearfix js-sweatalert">
        <div class="col-lg-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        JUARA UMUM
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <a href="laporan/juara_pdf.php" target="_blank" class="btn btn-default btn-sm waves-effect"><i class="fa fa-print"></i>
                            Export PDF</a>
                        <a href="laporan/juara_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Export Excel</a>
                    </div><br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Nama Pangkalan</th>
                                    <th>Nilai Putra</th>
                                    <th>Nilai Putri</th>
                                    <th>Total Nilai</th>
                                    <th>Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $sql = $koneksi->query("SELECT * FROM tb_juara
                                    RIGHT JOIN tb_peserta_pa ON tb_juara.id_pa = tb_peserta_pa.id_pa
                                    RIGHT JOIN tb_peserta_pi ON tb_juara.id_pi = tb_peserta_pi.id_pi
                                    LEFT JOIN tb_rekap ON tb_juara.id_rekap = tb_rekap.id_rekap
                                    LEFT JOIN tb_rekap_pi ON tb_juara.id_rekap_pi = tb_rekap_pi.id_rekap_pi ORDER BY total_nilai DESC");
                                    while ($data = $sql->fetch_assoc()) {
                                    $total_nilai = $data['nilai_akhir_pa'] + $data['nilai_akhir_pi']; ?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$data['pangkalan']; ?></td>
                                    <td><?=$data['nilai_akhir_pa']; ?></td>
                                    <td><?=$data['nilai_akhir_pi']; ?></td>
                                    <td><?=$total_nilai?></td>
                                    <th></th>
                                </tr>
                                <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
