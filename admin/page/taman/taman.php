<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_taman WHERE id_taman='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Taman-Taman</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">domain</i> Taman-taman</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        TAMAN-TAMAN
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#modal_tambah"><i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th style="text-align: center;">Nama Taman</th>
                                    <th style="text-align: center;">Lokasi</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$no = 1;
									$sql = $koneksi->query("SELECT * FROM tb_taman ORDER BY nama_taman ASC");
									while ($data = $sql->fetch_assoc()) {
									?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$data['nama_taman']; ?></td>
                                    <td><?=$data['lokasi']; ?></td>
                                    <td align="center">
                                        <a data-toggle="modal" data-target="#modal_edit<?=$data['id_taman']; ?>"><button class="btn btn-warning btn-xs waves-effect"><i class="material-icons">edit</i><span>Edit</span></button>
                                        </a>
                                        <a data-toggle="modal" data-target="#modal_konfirmasi<?=$data['id_taman']; ?>"><button class="btn btn-danger btn-xs waves-effect"><i class="material-icons">delete</i><span>Hapus</span></button>
                                        </a>
                                        <!-- <a href="?page=taman&aksi=hapus&id=<?=$data['id_taman']; ?>"
												onclick="return confirm('Yakin Menghapus Data?')"
												class="btn btn-danger btn-xs waves-effect" id="btn-hapus"><i
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
