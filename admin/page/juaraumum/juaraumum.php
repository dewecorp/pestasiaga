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
                        <a href="../laporan/juara_pdf.php" target="_blank" class="btn btn-default btn-sm waves-effect"><i class="fa fa-print"></i>
                            Export PDF</a>
                        <a href="../laporan/juara_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Export Excel</a>
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
                                    <th>Keterangan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    // Complex query to get combined scores from both tables based on pangkalan name
                                    $query = "
                                        SELECT 
                                            T.pangkalan,
                                            r_pa.nilai_akhir_pa as nilai_putra,
                                            r_pi.nilai_akhir_pi as nilai_putri,
                                            (CAST(COALESCE(NULLIF(r_pa.nilai_akhir_pa, ''), 0) AS UNSIGNED) + CAST(COALESCE(NULLIF(r_pi.nilai_akhir_pi, ''), 0) AS UNSIGNED)) as total_nilai
                                        FROM 
                                            (SELECT pangkalan FROM tb_peserta_pa UNION SELECT pangkalan FROM tb_peserta_pi) as T
                                        LEFT JOIN tb_peserta_pa pa ON T.pangkalan = pa.pangkalan
                                        LEFT JOIN tb_rekap r_pa ON pa.id_pa = r_pa.id_pa
                                        LEFT JOIN tb_peserta_pi pi ON T.pangkalan = pi.pangkalan
                                        LEFT JOIN tb_rekap_pi r_pi ON pi.id_pi = r_pi.id_pi
                                        ORDER BY total_nilai DESC
                                    ";
                                    
                                    $sql = $koneksi->query($query);
                                    
                                    if (!$sql) {
                                        echo "<tr><td colspan='6'>Query Error: " . $koneksi->error . "</td></tr>";
                                    } else {
                                        while ($data = $sql->fetch_assoc()) {
                                            $predikat = "";
                                            $badge_color = "";
                                            
                                            // Determine predicate for top 6
                                            switch ($no) {
                                                case 1:
                                                    $predikat = "Juara Umum I";
                                                    $badge_color = "bg-green";
                                                    break;
                                                case 2:
                                                    $predikat = "Juara Umum II";
                                                    $badge_color = "bg-green";
                                                    break;
                                                case 3:
                                                    $predikat = "Juara Umum III";
                                                    $badge_color = "bg-green";
                                                    break;
                                                case 4:
                                                    $predikat = "Harapan I";
                                                    $badge_color = "bg-orange";
                                                    break;
                                                case 5:
                                                    $predikat = "Harapan II";
                                                    $badge_color = "bg-orange";
                                                    break;
                                                case 6:
                                                    $predikat = "Harapan III";
                                                    $badge_color = "bg-orange";
                                                    break;
                                            }
                                ?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$data['pangkalan']; ?></td>
                                    <td><?=!empty($data['nilai_putra']) ? $data['nilai_putra'] : 0; ?></td>
                                    <td><?=!empty($data['nilai_putri']) ? $data['nilai_putri'] : 0; ?></td>
                                    <td><?=$data['total_nilai']?></td>
                                    <td>
                                        <?php if ($predikat != ""): ?>
                                        <span class="badge <?=$badge_color?>"><?=$predikat?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                        }
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
