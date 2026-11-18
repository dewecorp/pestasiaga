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

        /* Admin Mobile Quick Grid Menu (< 768px) */
        .admin-mobile-grid {
            display: none;
        }
        @media (max-width: 767px) {
            .welcome-card {
                border-radius: 18px !important;
                margin-bottom: 16px !important;
            }
            .admin-mobile-grid {
                display: block;
                margin-bottom: 16px;
            }
            .mob-section-title {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
                margin-bottom: 10px;
                padding: 0 4px;
            }
            .mob-section-title span {
                font-size: 13px;
                font-weight: 700;
                color: #1b5e20;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .mob-section-title small {
                font-size: 11px;
                color: #78909c;
                font-weight: 500;
            }
            .mob-grid-row {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }
            .mob-grid-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: #ffffff;
                border-radius: 14px;
                padding: 10px 4px 8px;
                text-decoration: none !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                border: 1px solid #edf2f7;
                transition: transform 0.15s ease, box-shadow 0.15s ease;
            }
            .mob-grid-item:active {
                transform: scale(0.93);
                box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            }
            .mob-grid-icon {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ffffff;
                margin-bottom: 5px;
                box-shadow: 0 3px 8px rgba(0,0,0,0.14);
            }
            .mob-grid-icon i.material-icons {
                font-size: 22px;
                line-height: 1;
            }
            .mob-grid-label {
                font-size: 10px;
                font-weight: 600;
                color: #37474f;
                text-align: center;
                line-height: 1.15;
                max-width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                padding: 0 2px;
            }
            /* Icon Gradients */
            .icon-teal   { background: linear-gradient(135deg, #00897b, #004d40); }
            .icon-blue   { background: linear-gradient(135deg, #1e88e5, #0d47a1); }
            .icon-amber  { background: linear-gradient(135deg, #fb8c00, #e65100); }
            .icon-rose   { background: linear-gradient(135deg, #e91e63, #880e4f); }
            .icon-cyan   { background: linear-gradient(135deg, #00acc1, #006064); }
            .icon-purple { background: linear-gradient(135deg, #8e24aa, #4a148c); }
            .icon-orange { background: linear-gradient(135deg, #ff8f00, #e65100); }
            .icon-red    { background: linear-gradient(135deg, #e53935, #b71c1c); }
            .icon-green  { background: linear-gradient(135deg, #43a047, #1b5e20); }
            .icon-slate  { background: linear-gradient(135deg, #546e7a, #263238); }
            .icon-sky    { background: linear-gradient(135deg, #0288d1, #01579b); }
            .icon-indigo { background: linear-gradient(135deg, #3949ab, #1a237e); }
        }
        .chart-responsive-wrap {
            position: relative;
            height: 380px;
            width: 100%;
        }
        @media (max-width: 767px) {
            .chart-responsive-wrap {
                height: 560px !important;
            }
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

    <!-- Mobile Quick Grid Menu (Hanya tampil di HP < 768px) -->
    <div class="admin-mobile-grid">
        <div class="mob-section-title">
            <span>Menu Cepat</span>
            <small>Akses cepat layanan admin</small>
        </div>
        <div class="mob-grid-row">
            <a href="?page=taman" class="mob-grid-item">
                <div class="mob-grid-icon icon-teal">
                    <i class="material-icons">domain</i>
                </div>
                <span class="mob-grid-label">Taman</span>
            </a>
            <a href="?page=juri" class="mob-grid-item">
                <div class="mob-grid-icon icon-blue">
                    <i class="material-icons">groups</i>
                </div>
                <span class="mob-grid-label">Dewan Juri</span>
            </a>
            <a href="?page=pesertapa" class="mob-grid-item">
                <div class="mob-grid-icon icon-amber">
                    <i class="material-icons">directions_run</i>
                </div>
                <span class="mob-grid-label">Barung PA</span>
            </a>
            <a href="?page=pesertapi" class="mob-grid-item">
                <div class="mob-grid-icon icon-rose">
                    <i class="material-icons">local_florist</i>
                </div>
                <span class="mob-grid-label">Barung PI</span>
            </a>
            <a href="?page=rekapawalputra" class="mob-grid-item">
                <div class="mob-grid-icon icon-cyan">
                    <i class="material-icons">format_list_numbered</i>
                </div>
                <span class="mob-grid-label">Rekap PA</span>
            </a>
            <a href="?page=rekapawalputri" class="mob-grid-item">
                <div class="mob-grid-icon icon-purple">
                    <i class="material-icons">assessment</i>
                </div>
                <span class="mob-grid-label">Rekap PI</span>
            </a>
            <a href="?page=rekapakhirputra" class="mob-grid-item">
                <div class="mob-grid-icon icon-orange">
                    <i class="material-icons">thumb_up</i>
                </div>
                <span class="mob-grid-label">Berprestasi</span>
            </a>
            <a href="?page=juaraumum" class="mob-grid-item">
                <div class="mob-grid-icon icon-red">
                    <i class="material-icons">school</i>
                </div>
                <span class="mob-grid-label">Juara Umum</span>
            </a>
            <a href="?page=user" class="mob-grid-item">
                <div class="mob-grid-icon icon-green">
                    <i class="material-icons">person</i>
                </div>
                <span class="mob-grid-label">Data User</span>
            </a>
            <a href="?page=panitia" class="mob-grid-item">
                <div class="mob-grid-icon icon-slate">
                    <i class="material-icons">settings</i>
                </div>
                <span class="mob-grid-label">Pengaturan</span>
            </a>
            <a href="../index.php" target="_blank" class="mob-grid-item">
                <div class="mob-grid-icon icon-sky">
                    <i class="material-icons">public</i>
                </div>
                <span class="mob-grid-label">Lihat Web</span>
            </a>
            <a href="?page=backup" class="mob-grid-item">
                <div class="mob-grid-icon icon-indigo">
                    <i class="material-icons">backup</i>
                </div>
                <span class="mob-grid-label">Backup DB</span>
            </a>
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
                    <div class="chart-responsive-wrap">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>GRAFIK NILAI BARUNG PUTRI</h2>
                </div>
                <div class="body">
                    <div class="chart-responsive-wrap">
                        <canvas id="myChart2"></canvas>
                    </div>
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
