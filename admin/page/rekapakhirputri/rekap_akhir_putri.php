<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_prestasi_pi WHERE id_prestasi_pi='$id'");
?>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">thumb_up</i> Barung Berprestasi Putri</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        BARUNG BERPRESTASI PUTRI
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <a href="../laporan/prestasipi_pdf.php" target="_blank" class="btn btn-danger btn-sm waves-effect"><i class="fa fa-print"></i>
                PDF</a>
                        <a href="../laporan/prestasipi_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Nomor Dada</th>
                                    <th>Pangkalan</th>
                                    <th>Total Nilai</th>
                                    <th>Keterangan</th>
                                    <!--  <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                           $no = 1;
                           // Modified query to fetch top 6 scores directly from tb_rekap_pi
                           $sql = $koneksi->query("SELECT * FROM tb_rekap_pi 
                                                 JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                                                 ORDER BY CAST(nilai_akhir_pi AS UNSIGNED) DESC LIMIT 6");
                           
                           while ($data = $sql->fetch_assoc()) {
                                // Determine predicate based on rank ($no)
                                $predikat = "";
                                $badge_color = "";
                                
                                switch ($no) {
                                    case 1:
                                        $predikat = "Tergiat I";
                                        $badge_color = "bg-green";
                                        break;
                                    case 2:
                                        $predikat = "Tergiat II";
                                        $badge_color = "bg-orange";
                                        break;
                                    case 3:
                                        $predikat = "Tergiat III";
                                        $badge_color = "bg-red";
                                        break;
                                    case 4:
                                        $predikat = "Harapan I";
                                        $badge_color = "bg-blue";
                                        break;
                                    case 5:
                                        $predikat = "Harapan II";
                                        $badge_color = "bg-blue";
                                        break;
                                    case 6:
                                        $predikat = "Harapan III";
                                        $badge_color = "bg-blue";
                                        break;
                                }
                           ?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$data['no_dada']; ?></td>
                                    <td><?=$data['pangkalan']; ?></td>
                                    <td><?=$data['nilai_akhir_pi']; ?></td>
                                    <td>
                                        <span class="badge <?=$badge_color?>"><?=$predikat?></span>
                                    </td>
                                    <!-- <td align="center">
                                 <a href="?page=rekapakhirputri&aksi=hapus&id=<?=$data['id_prestasi_pi']; ?>"
                                    onclick="return confirm('Yakin Menghapus Data?')"
                                    class="btn btn-danger btn-xs waves-effect"><i
                                    class="material-icons">delete</i><span>Hapus</span></a>
                                 </td> -->
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
