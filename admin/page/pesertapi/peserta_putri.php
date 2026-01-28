<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_peserta_pi WHERE id_pi='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Peserta Putri</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">people</i> Peserta Barung Putri</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        PESERTA BARUNG PUTRI
                    </h2>
                </div>
                <div class="body">
                    <div class="pull-right">
                        <a href="../laporan/pesertapi_pdf.php" target="_blank" class="btn btn-default btn-sm waves-effect"><i class="fa fa-print"></i>
                            PDF</a>
                        <a href="../laporan/pesertapi_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                        <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#modal_tambah"><i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>
                    <br><br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Nomor Dada</th>
                                    <th>Nama Pangkalan</th>
                                    <th>Nama Pembina</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $sql = $koneksi->query("SELECT * FROM tb_peserta_pi ORDER BY no_dada ASC") or die($koneksi->error);
                                    while ($data = $sql->fetch_assoc()) {
                                    ?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$data['no_dada']; ?></td>
                                    <td><?=$data['pangkalan']; ?></td>
                                    <td><?=$data['pembina']; ?></td>
                                    <td align="center">
                                        <a data-toggle="modal" data-target="#modal_edit<?=$data['id_pi']; ?>"><button class="btn btn-warning btn-xs waves-effect"><i class="material-icons">edit</i><span>Edit</span></button>
                                        </a>
                                        <a data-toggle="modal" data-target="#modal_konfirmasi<?=$data['id_pi']; ?>"><button class="btn btn-danger btn-xs waves-effect"><i class="material-icons">delete</i><span>Hapus</span></button>
                                        </a>
                                        <!--  <a href="?page=pesertapi&aksi=hapus&id=<?=$data['id_pi']; ?>"
                                                onclick="return confirm('Yakin Menghapus Data?')"
                                                class="btn btn-danger btn-xs waves-effect"><i
                                                class="material-icons">delete</i><span>Hapus</span>
                                            </a> -->
                                    </td>
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
<?php 

include "modal_tambah.php";
include "modal_edit.php";
include "modal_konfirmasi.php";
 ?>
