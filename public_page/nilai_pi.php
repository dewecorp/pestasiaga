<div class="container content-section">
    <div class="card">
        <style>
            .table thead th {
                text-align: center !important;
                vertical-align: middle !important;
            }
        </style>
        <div class="header bg-purple">
            <h2>REKAP NILAI PUTRI</h2>
        </div>
        <div class="body">
            <?php
            // Ambil data taman untuk Putri
            $sql_taman = $koneksi->query("SELECT * FROM tb_taman WHERE nama_taman LIKE '%PUTRI%' ORDER BY id_taman ASC");
            $data_taman = [];
            while ($t = $sql_taman->fetch_assoc()) {
                $data_taman[] = $t;
            }

            // Fungsi mapping yang sama dengan admin
            if (!function_exists('map_col_public_pi')) {
                function map_col_public_pi($nama) {
                    $nama = strtolower(trim($nama));
                    if (strpos($nama, 'scout') !== false) return 'scout_skill';
                    if (strpos($nama, 'kim') !== false) return 'kim';
                    if (strpos($nama, 'bumbung') !== false) return 'bumbung';
                    if (strpos($nama, 'ketakwaan') !== false) return 'ketakwaan';
                    if (strpos($nama, 'toleransi') !== false) return 'toleransi';
                    if (strpos($nama, 'tanda') !== false) return 'tanda_pengenal';
                    if (strpos($nama, 'ranking') !== false || strpos($nama, 'rangking') !== false) return 'rangking';
                    if (strpos($nama, 'lbb') !== false) return 'lbb';
                    if (strpos($nama, 'seni') !== false) return 'seni_budaya';
                    if (strpos($nama, 'lempar') !== false) return 'lempar_bola';
                    if (strpos($nama, 'kereta') !== false) return 'kereta_bola';
                    $nama = str_replace([' putra', ' putri'], '', $nama);
                    return str_replace(' ', '_', $nama);
                }
            }

            $total_peserta_sql = $koneksi->query("SELECT COUNT(*) as total FROM tb_peserta_pi");
            $total_peserta = $total_peserta_sql->fetch_assoc()['total'];
            
            $total_taman = count($data_taman);
            $total_sel = $total_peserta * $total_taman;
            
            $terisi = 0;
            $sql_rekap = $koneksi->query("SELECT * FROM tb_rekap_pi");
            while($r = $sql_rekap->fetch_assoc()) {
                foreach($data_taman as $t) {
                    $col = map_col_public_pi($t['nama_taman']);
                    if(isset($r[$col]) && $r[$col] !== "" && $r[$col] !== null) {
                        $terisi++;
                    }
                }
            }
            
            $persentase = ($total_sel > 0) ? ($terisi / $total_sel) * 100 : 0;
            $persentase = round($persentase, 2);
            ?>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12">
                    <b>Progres Nilai Masuk: <?= $persentase ?>% (<?= $terisi ?> / <?= $total_sel ?>)</b>
                    <div class="progress" style="height: 20px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persentase ?>%; line-height: 20px;">
                            <?= $persentase ?>%
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Dada</th>
                            <th>Pangkalan</th>
                            <th>Ketakwaan</th>
                            <th>Toleransi</th>
                            <th>Tanda Pengenal</th>
                            <th>Rangking 1</th>
                            <th>KIM</th>
                            <th>LBB</th>
                            <th>Kereta Bola</th>
                            <th>Seni Budaya</th>
                            <th>Bumbung</th>
                            <th>Lempar Bola</th>
                            <th>Kerapian</th>
                            <th>Patriotisme</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM tb_rekap_pi 
                                              JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                                              ORDER BY tb_peserta_pi.no_dada ASC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['no_dada'] ?></td>
                            <td><?= $data['pangkalan'] ?></td>
                            <td><?= $data['ketakwaan'] ?></td>
                            <td><?= $data['toleransi'] ?></td>
                            <td><?= $data['tanda_pengenal'] ?></td>
                            <td><?= $data['rangking'] ?></td>
                            <td><?= $data['kim'] ?></td>
                            <td><?= $data['lbb'] ?></td>
                            <td><?= $data['kereta_bola'] ?></td>
                            <td><?= $data['seni_budaya'] ?></td>
                            <td><?= $data['bumbung'] ?></td>
                            <td><?= $data['lempar_bola'] ?></td>
                            <td><?= $data['kerapian'] ?></td>
                            <td><?= $data['patriotisme'] ?></td>
                            <td><strong><?= $data['nilai_akhir_pi'] ?></strong></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- JQuery DataTable Css -->
<link href="assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- JQuery DataTable Js -->
<script src="assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script>
    $(function () {
        $('.js-basic-example').DataTable({
            responsive: true
        });
    });
</script>