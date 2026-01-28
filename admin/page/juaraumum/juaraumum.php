<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_juara WHERE id_juara='$id'");
?>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
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
                        <a href="../laporan/juara_pdf.php" target="_blank" class="btn btn-danger btn-sm waves-effect"><i class="fa fa-print"></i> Export PDF</a>
                        <a href="../laporan/juara_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Export Excel</a>
                    </div><br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Nama Pangkalan</th>
                                    <th>Total Nilai Putra</th>
                                    <th>Total Nilai Putri</th>
                                    <th>Total Nilai</th>
                                    <th>Keterangan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'juara_logic.php';

                                $no = 1;
                                foreach($stats as $pangkalan => $data) {
                                    $predikat = "";
                                    $badge_color = "";
                                    
                                    switch ($no) {
                                        case 1: $predikat = "Juara Umum I"; $badge_color = "bg-green"; break;
                                        case 2: $predikat = "Juara Umum II"; $badge_color = "bg-green"; break;
                                        case 3: $predikat = "Juara Umum III"; $badge_color = "bg-green"; break;
                                        case 4: $predikat = "Harapan I"; $badge_color = "bg-orange"; break;
                                        case 5: $predikat = "Harapan II"; $badge_color = "bg-orange"; break;
                                        case 6: $predikat = "Harapan III"; $badge_color = "bg-orange"; break;
                                    }
                                ?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$pangkalan; ?></td>
                                    <td><?=$data['nilai_pa']?></td>
                                    <td><?=$data['nilai_pi']?></td>
                                    <td><?=$data['nilai']?></td>
                                    <td>
                                        <?php if ($predikat != ""): ?>
                                        <span class="badge <?=$badge_color?>"><?=$predikat?></span>
                                        <?php endif; ?>
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
