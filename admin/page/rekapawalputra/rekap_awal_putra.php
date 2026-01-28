<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_rekap WHERE id_rekap='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rekap Nilai Putra</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">list</i> Rekap Nilai Barung Putra</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        REKAP NILAI BARUNG PUTRA
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <a href="../laporan/rekappa_pdf.php" target="_blank" class="btn btn-info btn-sm waves-effect"><i class="fa fa-print"></i>
                            PDF</a>
                        <a href="../laporan/rekappa_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                    </div>
                    <br><br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th style="width: 20px;">No. Dada</th>
                                    <th>Pangkalan</th>
                                    <th>K</th>
                                    <th>T</th>
                                    <th>TP</th>
                                    <th>R1</th>
                                    <th>KIM</th>
                                    <th>SS</th>
                                    <th>LBB</th>
                                    <th>KB</th>
                                    <th>SB</th>
                                    <th>BP</th>
                                    <th>NA</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$no = 1;
									$sql = $koneksi->query("SELECT * FROM tb_rekap
									RIGHT JOIN tb_peserta_pa ON tb_peserta_pa.id_pa = tb_rekap.id_pa ORDER BY no_dada ASC");
									// echo "<pre>";
										// echo print_r($sql);
										// echo die();
										// $sql = $koneksi->query("SELECT * FROM tb_rekap a, tb_peserta_pa b
										// WHERE a.id_pa = b.id_pa
										// ORDER BY b.no_dada ASC");
										while ($data = $sql->fetch_assoc()) {
										if ($data['nilai_akhir_pa'] == "" || $data['nilai_akhir_pa'] == null) {
										$nilai = "<span class='badge bg-red'>Belum Input</span>";
										} else {
										$nilai = $data['nilai_akhir_pa'];
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
                                    <td align="center">
                                        <a href="?page=rekapawalputra&aksi=input&id=<?=$data['id_rekap']; ?>" class="btn bg-cyan btn-circle waves-effect waves-circle waves-float"><i class="material-icons">create</i><span></span>
                                        </a>
                                        <!-- <a data-toggle="modal"
                                            data-target="#modal_input<?=$data['id_rekap']; ?>"><button
                                                class="btn btn-warning btn-xs waves-effect"><i
                                                    class="material-icons">edit</i><span></span></button>
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
		include "modal_input.php";
		include "modal_coba.php";
		?>
