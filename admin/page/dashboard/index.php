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
    <style>
        .welcome-card {
            border-radius: 16px !important;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #43a047 100%);
            color: #fff;
            padding: 0;
            margin-bottom: 24px;
            box-shadow: 0 6px 24px rgba(27,94,32,.3) !important;
            overflow: hidden;
            position: relative;
        }
        .welcome-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .welcome-card::after {
            content: '';
            position: absolute;
            bottom: -30px; left: 60px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .welcome-inner {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            position: relative;
            z-index: 1;
        }
        .welcome-avatar {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; font-weight: 700; color: #fff;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,.4);
            overflow: hidden;
        }
        .welcome-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .welcome-text { flex: 1; min-width: 0; }
        .welcome-text .greeting {
            font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px;
            opacity: .8; margin-bottom: 2px;
        }
        .welcome-text .name {
            font-size: 20px; font-weight: 700;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            line-height: 1.2; margin-bottom: 4px;
        }
        .welcome-text .meta {
            font-size: 12px; opacity: .75;
            display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
        }
        .welcome-text .meta span { display: flex; align-items: center; gap: 4px; }
        .welcome-text .meta .material-icons { font-size: 14px; }
        .welcome-divider {
            height: 1px;
            background: rgba(255,255,255,.15);
            margin: 0 24px;
        }
        .welcome-stats {
            display: flex;
            padding: 14px 24px;
            gap: 0;
            position: relative; z-index: 1;
        }
        .welcome-stat {
            flex: 1;
            text-align: center;
            padding: 0 8px;
            border-right: 1px solid rgba(255,255,255,.18);
        }
        .welcome-stat:last-child { border-right: none; }
        .welcome-stat .stat-num {
            font-size: 22px; font-weight: 700; line-height: 1;
        }
        .welcome-stat .stat-lbl {
            font-size: 10px; text-transform: uppercase;
            letter-spacing: .6px; opacity: .75; margin-top: 3px;
        }
        @media (max-width: 480px) {
            .welcome-inner { padding: 16px; gap: 12px; }
            .welcome-text .name { font-size: 17px; }
            .welcome-stats { padding: 12px 16px; }
            .welcome-stat .stat-num { font-size: 18px; }
        }
    </style>

    <div class="welcome-card">
        <div class="welcome-inner">
            <div class="welcome-avatar">
                <?php
                $foto = $tampil['foto'] ?? '';
                if (!empty($foto)) {
                    echo '<img src="../assets/images/'.htmlspecialchars($foto).'" alt="foto">';
                } else {
                    echo strtoupper(substr($tampil['nama'], 0, 1));
                }
                ?>
            </div>
            <div class="welcome-text">
                <div class="greeting">🌿 Salam Pramuka!</div>
                <div class="name"><?= htmlspecialchars($tampil['nama']) ?></div>
                <div class="meta">
                    <span><i class="material-icons">verified_user</i> <?= $level ?></span>
                    <?php if (!empty($data['nama_kegiatan'])): ?>
                    <span><i class="material-icons">event</i> <?= htmlspecialchars($data['nama_kegiatan']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($data['waktu'])): ?>
                    <span><i class="material-icons">today</i> <?= e(format_hari_tanggal($data['waktu'])) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="welcome-divider"></div>
        <div class="welcome-stats">
            <div class="welcome-stat">
                <div class="stat-num"><?= $jumlah_taman ?></div>
                <div class="stat-lbl">Taman</div>
            </div>
            <div class="welcome-stat">
                <div class="stat-num"><?= $jumlah_peserta_pa ?></div>
                <div class="stat-lbl">Barung Putra</div>
            </div>
            <div class="welcome-stat">
                <div class="stat-num"><?= $jumlah_peserta_pi ?></div>
                <div class="stat-lbl">Barung Putri</div>
            </div>
            <div class="welcome-stat">
                <div class="stat-num"><?= $jumlah_juri ?></div>
                <div class="stat-lbl">Dewan Juri</div>
            </div>
        </div>
    </div>
    <!-- Widgets -->

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
