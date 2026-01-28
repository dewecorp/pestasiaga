<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_rekap_pi WHERE id_rekap_pi='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rekap Nilai Putri</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-blue">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">list</i> Rekap Nilai Barung Putri</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        REKAP NILAI BARUNG PUTRI
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <a href="laporan/rekappi_pdf.php" target="_blank" class="btn btn-info btn-sm waves-effect"><i class="fa fa-print"></i>
                            PDF</a>
                        <a href="laporan/rekappi_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th style="width: 20px;">No. Dada</th>
                                    <th style="width: 100px;">Pangkalan</th>
                                    <th>Ketakwaan</th>
                                    <th>Toleransi</th>
                                    <th>Tanda Pengenal</th>
                                    <th>Rangking 1</th>
                                    <th>KIM</th>
                                    <th>Scout Skills</th>
                                    <th>LBB</th>
                                    <th>Kereta Bola</th>
                                    <th>Seni Budaya</th>
                                    <th>Bumbung Peduli</th>
                                    <th>Nilai Akhir</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $sql = $koneksi->query("SELECT * FROM tb_rekap_pi
                                    RIGHT JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi ORDER BY no_dada ASC");
                                    // $sql = $koneksi->query("SELECT *
                                    // FROM tb_rekap_pi a
                                    // RIGHT JOIN tb_peserta_pi b ON a.id_pi = b.id_pi
                                    // ORDER BY no_dada ASC");
                                    // $sql = $koneksi->query("SELECT * FROM tb_peserta_pi a, tb_rekap_pi b
                                    // WHERE a.id_pi = b.id_pi
                                    // ORDER BY a.no_dada ASC");
                                    while ($data = $sql->fetch_assoc()) {
                                    if ($data['nilai_akhir_pi'] == "" || $data['nilai_akhir_pi'] == null) {
                                    $nilai = "<span class='badge bg-red'>Belum Input Nilai</span>";
                                    } else {
                                    $nilai = $data['nilai_akhir_pi'];
                                    } ?>
                                <tr>
                                    <td align="center"><?=$no++."."; ?></td>
                                    <td align="center"><?=$data['no_dada']; ?></td>
                                    <td><?=$data['pangkalan']; ?></td>
                                    <td align="center"><?=$data['ketakwaan']; ?></td>
                                    <td align="center"><?=$data['toleransi']; ?></td>
                                    <td align="center"><?=$data['tanda_pengenal']; ?></td>
                                    <td align="center"><?=$data['rangking']; ?></td>
                                    <td align="center"><?=$data['kim']; ?></td>
                                    <td align="center"><?=$data['scout_skill']; ?></td>
                                    <td align="center"><?=$data['lbb']; ?></td>
                                    <td align="center"><?=$data['kereta_bola']; ?></td>
                                    <td align="center"><?=$data['seni_budaya']; ?></td>
                                    <td align="center"><?=$data['bumbung']; ?></td>
                                    <td align="center"><?=$nilai?></td>

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
