<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_juri WHERE id_juri='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dewan Juri</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-blue">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">visibility</i> Dewan Juri</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        DEWAN JURI
                    </h2>
                </div>
                <div class="body">
                    <div class="pull-right">
                        <a href="laporan/juri_pdf.php" target="_blank" class="btn btn-default btn-sm waves-effect"><i class="fa fa-print"></i>
                            PDF</a>
                        <a href="laporan/juri_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>

                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Nama Juri</th>
                                    <th>Pangkalan</th>
                                    <th>Koordinator Taman</th>
                                    <th>No HP/WA</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $sql = $koneksi->query("SELECT * FROM tb_juri
                                    JOIN tb_taman ON tb_juri.id_taman = tb_taman.id_taman
                                    JOIN tb_peserta_pa ON tb_juri.id_pa = tb_peserta_pa.id_pa");
                                    while ($data = $sql->fetch_assoc()) {
                                    ?>
                                <tr>
                                    <td><?= $no++ . "."; ?></td>
                                    <td><?= $data['nama_juri']; ?></td>
                                    <td><?= $data['pangkalan']; ?></td>
                                    <td><?= $data['nama_taman']; ?></td>
                                    <td><?= $data['no_hp']; ?></td>

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
