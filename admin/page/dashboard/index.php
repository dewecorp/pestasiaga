<?php
session_start();
error_reporting();
setlocale(LC_ALL, 'id-ID', 'id_ID');
include "../config/koneksi.php";

$id = @$_GET['id'];
$id = @$_SESSION['id_user'];
$peserta_pa = $koneksi->query("SELECT * FROM tb_peserta_pa WHERE id_pa='$id'");
$peserta_pi = $koneksi->query("SELECT * FROM tb_peserta_pi WHERE id_pi='$id'");
$panitia = $koneksi->query("SELECT * FROM tb_panitia");
$data = $panitia->fetch_assoc();
// mengambil data taman
$data_taman = $koneksi->query("SELECT * FROM tb_taman");
// menghitung data taman
$jumlah_taman = $data_taman->num_rows;
$data_peserta_pa = $koneksi->query("SELECT * FROM tb_peserta_pa");
// menghitung data peserta putra
$jumlah_peserta_pa = $data_peserta_pa->num_rows;
$data_peserta_pi = $koneksi->query("SELECT * FROM tb_peserta_pi");
// menghitung data peserta putri
$jumlah_peserta_pi = $data_peserta_pi->num_rows;
$data_juri = $koneksi->query("SELECT * FROM tb_juri");
// menghitung data juri
$jumlah_juri = $data_juri->num_rows;
$total_peserta = $jumlah_peserta_pa + $jumlah_peserta_pi;
$sql = $koneksi->query("SELECT * FROM tb_user WHERE id ='$id'");
$tampil = $sql->fetch_assoc();
$level = ($tampil['level'] == 'admin') ? "Admin" : "Peserta";

?>
    <div class="body">
        <div class="alert alert-success alert-dismissable" role="alert" id="alert">
            <font style="font-size: 22px;"><b>Salam Pramuka ......</b> Selamat Datang <strong> <?=$tampil['nama'];?>,
                </strong> Anda login sebagai <strong><?=$level?></strong>
            </font>
        </div>
    </div>
    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">domain</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>TAMAN-TAMAN</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_taman?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>BARUNG PUTRA</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_peserta_pa?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>BARUNG PUTRI</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_peserta_pi?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">visibility</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>DEWAN JURI</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_juri?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">alarm</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h4><b>WAKTU KEGIATAN</b></h4>
                    </div>
                    <div class="text">
                        <h5><?php
                            $hari = $data['waktu'] ?? '';
                            echo !empty($hari) ? e(format_hari_tanggal($hari)) : '-';
                            if (!empty($data['jam'])) {
                                echo '<br><small>' . e($data['jam']) . '</small>';
                            }
                            ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">account_balance</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h4><b>LOKASI KEGIATAN</b></h4>
                    </div>
                    <div class="text">
                        <h5><?= e($data['tempat'] ?? '-'); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progres Nilai Section -->
    <?php
    // Helper function for dashboard
    if (!function_exists('map_col_dash')) {
        function map_col_dash($nama) {
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

    // Putra Progress
    $sql_t_pa = $koneksi->query("SELECT * FROM tb_taman WHERE nama_taman LIKE '%PUTRA%'");
    $data_t_pa = []; while($t = $sql_t_pa->fetch_assoc()) $data_t_pa[] = $t;
    $total_sel_pa = $jumlah_peserta_pa * count($data_t_pa);
    $terisi_pa = 0;
    $sql_r_pa = $koneksi->query("SELECT * FROM tb_rekap");
    while($r = $sql_r_pa->fetch_assoc()) {
        foreach($data_t_pa as $t) {
            $col = map_col_dash($t['nama_taman']);
            if(isset($r[$col]) && $r[$col] !== "" && $r[$col] !== null) $terisi_pa++;
        }
    }
    $persen_pa = ($total_sel_pa > 0) ? round(($terisi_pa / $total_sel_pa) * 100, 2) : 0;

    // Putri Progress
    $sql_t_pi = $koneksi->query("SELECT * FROM tb_taman WHERE nama_taman LIKE '%PUTRI%'");
    $data_t_pi = []; while($t = $sql_t_pi->fetch_assoc()) $data_t_pi[] = $t;
    $total_sel_pi = $jumlah_peserta_pi * count($data_t_pi);
    $terisi_pi = 0;
    $sql_r_pi = $koneksi->query("SELECT * FROM tb_rekap_pi");
    while($r = $sql_r_pi->fetch_assoc()) {
        foreach($data_t_pi as $t) {
            $col = map_col_dash($t['nama_taman']);
            if(isset($r[$col]) && $r[$col] !== "" && $r[$col] !== null) $terisi_pi++;
        }
    }
    $persen_pi = ($total_sel_pi > 0) ? round(($terisi_pi / $total_sel_pi) * 100, 2) : 0;
    ?>
    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-cyan">
                    <h2>PROGRES NILAI BARUNG PUTRA</h2>
                </div>
                <div class="body">
                    <b>Persentase: <?= $persen_pa ?>% (<?= $terisi_pa ?> / <?= $total_sel_pa ?>)</b>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?= $persen_pa ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_pa ?>%">
                            <?= $persen_pa ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-light-green">
                    <h2>PROGRES NILAI BARUNG PUTRI</h2>
                </div>
                <div class="body">
                    <b>Persentase: <?= $persen_pi ?>% (<?= $terisi_pi ?> / <?= $total_sel_pi ?>)</b>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?= $persen_pi ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_pi ?>%">
                            <?= $persen_pi ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>GRAFIK NILAI BARUNG PUTRA</h2>
                </div>
                <div class="body">
                    <canvas id="myChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>GRAFIK NILAI BARUNG PUTRI</h2>
                </div>
                <div class="body">
                    <canvas id="myChart2" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
<script src="../assets/plugins/jquery/jquery.js"></script>
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#alert').alert().delay(5000).slideUp('slow');
});
</script>
