<?php
// Check status
$status_home = $data_panitia['status_home'] ?? 'Buka';

if ($status_home == 'Tutup') {
    // Show closing message
    ?>
    <div class="jumbotron hero bg-light-brown" style="<?= !empty($data_panitia['hero_image']) ? "background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/".$data_panitia['hero_image']."'); background-size: cover; background-position: center; color: white;" : "" ?>">
        <div class="container">
            <h1>KEGIATAN SELESAI</h1>
            <h2><?= $data_panitia['nama_kegiatan'] ?> <?= date('Y') ?></h2>
        </div>
    </div>
    <div class="container content-section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header bg-red">
                        <h2><i class="glyphicon glyphicon-info-sign"></i> PENGUMUMAN</h2>
                    </div>
                    <div class="body">
                         <?php if (!empty($data_panitia['tutup_image'])): ?>
                            <div style="text-align: center; margin-bottom: 20px;">
                                <img src="assets/images/<?= $data_panitia['tutup_image'] ?>" alt="Tutup Image" style="max-width: 100%; height: auto; max-height: 400px; mix-blend-mode: multiply;">
                            </div>
                        <?php endif; ?>
                         <div class="lead-message">
                            <?= $data_panitia['pesan_tutup'] ?? 'Kegiatan telah selesai.' ?>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    // Fetch counts - Explicit connection to avoid scope issues
    $koneksi_count = mysqli_connect("localhost","root","","pestasiaga");
    
    // Default values
    $jml_taman = 0;
    $jml_juri = 0;
    $jml_pa = 0;
    $jml_pi = 0;

    if ($koneksi_count) {
        $q_taman = $koneksi_count->query("SELECT COUNT(*) as total FROM tb_taman");
        if ($q_taman && $q_taman->num_rows > 0) {
            $row = $q_taman->fetch_assoc();
            $jml_taman = $row['total'];
        }

        $q_juri = $koneksi_count->query("SELECT COUNT(*) as total FROM tb_juri");
        if ($q_juri && $q_juri->num_rows > 0) {
            $row = $q_juri->fetch_assoc();
            $jml_juri = $row['total'];
        }

        $q_pa = $koneksi_count->query("SELECT COUNT(*) as total FROM tb_peserta_pa");
        if ($q_pa && $q_pa->num_rows > 0) {
            $row = $q_pa->fetch_assoc();
            $jml_pa = $row['total'];
        }

        $q_pi = $koneksi_count->query("SELECT COUNT(*) as total FROM tb_peserta_pi");
        if ($q_pi && $q_pi->num_rows > 0) {
            $row = $q_pi->fetch_assoc();
            $jml_pi = $row['total'];
        }
    }

    // Show normal home
    ?>
    <style>
        .event-info-card {
            margin-top: -30px;
            margin-bottom: 35px;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 12px 30px rgba(230, 81, 0, 0.25), 0 4px 15px rgba(0,0,0,0.06);
            background: linear-gradient(135deg, #ff9800 0%, #e65100 100%);
            color: white;
            position: relative;
            z-index: 10;
        }

        .event-info-box {
            padding: 28px 30px;
        }

        .info-header-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            backdrop-filter: blur(4px);
        }

        .info-header-icon i {
            font-size: 24px;
            color: #fff;
        }

        .info-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 4px;
        }

        .info-value-main {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
            line-height: 1.3;
            color: #ffffff;
        }

        .info-time-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 4px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            padding: 16px 10px;
            transition: all 0.25s ease;
            backdrop-filter: blur(4px);
            margin-bottom: 10px;
            text-align: center;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .stat-icon {
            font-size: 20px;
            margin-bottom: 4px;
            opacity: 0.9;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 6px;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
        }
        .welcome-card {
            background: #ffffff;
            border: 1px solid #eceff1;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(93, 64, 55, 0.07);
            margin-bottom: 30px;
            padding: 26px;
        }

        .welcome-body {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .welcome-media {
            flex: 0 0 300px;
            max-width: 300px;
        }

        .welcome-media img {
            display: block;
            width: 100%;
            height: auto;
        }

        .welcome-content {
            flex: 1;
            min-width: 0;
        }

        .welcome-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: #8d6e63;
            background: #faf3ec;
            border: 1px solid #f0e4d8;
            border-radius: 999px;
            padding: 6px 13px;
            margin-bottom: 14px;
        }

        .welcome-eyebrow i.material-icons {
            font-size: 15px;
            color: #a1887f;
        }

        .welcome-text {
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            line-height: 1.85;
            color: #546e7a;
            text-align: left;
        }

        .welcome-text h1,
        .welcome-text h2,
        .welcome-text h3,
        .welcome-text h4,
        .welcome-text h5,
        .welcome-text h6 {
            font-size: 19px !important;
            font-weight: 800 !important;
            color: #3e2723 !important;
            margin: 0 0 10px !important;
            line-height: 1.35 !important;
            letter-spacing: 0.2px;
            text-align: left !important;
        }

        .welcome-text p,
        .welcome-text div,
        .welcome-text span,
        .welcome-text li {
            font-size: 15px !important;
            line-height: 1.85 !important;
            color: #546e7a !important;
            text-align: left !important;
        }

        .welcome-text p {
            margin-bottom: 10px !important;
        }

        .welcome-text strong,
        .welcome-text b {
            color: #3e2723 !important;
            font-weight: 700 !important;
        }

        .welcome-text img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }

        .welcome-text ul,
        .welcome-text ol {
            padding-left: 20px;
            margin-bottom: 10px;
        }

        @media (max-width: 991px) {
            .welcome-card {
                padding: 20px;
            }
            .welcome-body {
                gap: 20px;
            }
            .welcome-media {
                flex: 0 0 220px;
                max-width: 220px;
            }
        }
    </style>
    <div class="jumbotron hero bg-light-brown" style="<?= !empty($data_panitia['hero_image']) ? "background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/".$data_panitia['hero_image']."'); background-size: cover; background-position: center; color: white;" : "" ?>">
        <div class="container">
            <h1 style="font-size: 60px; font-weight: bold;">Selamat Datang</h1>
            <h2><?= $data_panitia['nama_kegiatan'] ?> <?= date('Y') ?></h2>
        </div>
    </div>

    <?php
    // Tanggal kegiatan terformat untuk tampilan mobile
    $tgl_mobile = '-';
    if (!empty($data_panitia['waktu'])) {
        $d_mobile = date_create($data_panitia['waktu']);
        if ($d_mobile) {
            $bulan_mobile = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ];
            $bln_mobile = date_format($d_mobile, "m");
            $tgl_mobile = date_format($d_mobile, "d") . ' ' . ($bulan_mobile[$bln_mobile] ?? $bln_mobile) . ' ' . date_format($d_mobile, "Y");
        } else {
            $tgl_mobile = $data_panitia['waktu'];
        }
    }
    ?>

    <!-- MOBILE: Kartu Sapaan + Informasi Kegiatan (App Style) -->
    <div class="container mobile-home-greeting" style="padding-top: 0;">
        <div class="mob-greeting-card">
            <div class="mob-greeting-avatar">
                <img src="assets/images/<?= $data_panitia['logo'] ?>" alt="Logo">
            </div>
            <div class="mob-greeting-text">
                <div class="mob-greeting-title">Selamat Datang di</div>
                <div class="mob-greeting-name"><?= e($data_panitia['nama_kegiatan']) ?> <?= date('Y') ?></div>
            </div>
        </div>
    </div>

    <div class="container mobile-event-info" style="padding-top: 0;">
        <div class="mob-section-title"><i class="material-icons">info</i> Informasi Kegiatan</div>

        <div class="mob-info-card">
            <div class="mob-info-tile" style="background:#fff3e0;">
                <i class="material-icons" style="color:#ef6c00;">event</i>
            </div>
            <div class="mob-info-body">
                <div class="mob-info-label">Waktu Kegiatan</div>
                <div class="mob-info-value"><?= e($tgl_mobile) ?></div>
                <?php if (!empty($data_panitia['jam'])): ?>
                    <span class="mob-info-chip">
                        <i class="material-icons">schedule</i> <?= e($data_panitia['jam']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="mob-info-card">
            <div class="mob-info-tile" style="background:#e8f5e9;">
                <i class="material-icons" style="color:#2e7d32;">place</i>
            </div>
            <div class="mob-info-body">
                <div class="mob-info-label">Lokasi Kegiatan</div>
                <div class="mob-info-value"><?= e($data_panitia['tempat']) ?></div>
            </div>
        </div>

        <div class="mob-section-title"><i class="material-icons">leaderboard</i> Ringkasan Data</div>
        <div class="mob-stat-grid">
            <div class="mob-stat-cell">
                <div class="mob-stat-box">
                    <div class="mob-stat-icon" style="background:#e8f5e9;">
                        <i class="material-icons" style="color:#2e7d32;">domain</i>
                    </div>
                    <div>
                        <div class="mob-stat-num"><?= (int)$jml_taman ?></div>
                        <div class="mob-stat-name">Taman</div>
                    </div>
                </div>
            </div>
            <div class="mob-stat-cell">
                <div class="mob-stat-box">
                    <div class="mob-stat-icon" style="background:#fff8e1;">
                        <i class="material-icons" style="color:#f57f17;">gavel</i>
                    </div>
                    <div>
                        <div class="mob-stat-num"><?= (int)$jml_juri ?></div>
                        <div class="mob-stat-name">Dewan Juri</div>
                    </div>
                </div>
            </div>
            <div class="mob-stat-cell">
                <div class="mob-stat-box">
                    <div class="mob-stat-icon" style="background:#e3f2fd;">
                        <i class="material-icons" style="color:#1565c0;">directions_run</i>
                    </div>
                    <div>
                        <div class="mob-stat-num"><?= (int)$jml_pa ?></div>
                        <div class="mob-stat-name">Peserta Putra</div>
                    </div>
                </div>
            </div>
            <div class="mob-stat-cell">
                <div class="mob-stat-box">
                    <div class="mob-stat-icon" style="background:#fce4ec;">
                        <i class="material-icons" style="color:#c2185b;">local_florist</i>
                    </div>
                    <div>
                        <div class="mob-stat-num"><?= (int)$jml_pi ?></div>
                        <div class="mob-stat-name">Peserta Putri</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container content-section">
        <div class="row desktop-home-block">
            <div class="col-md-12">
                <!-- Info Box with Counts -->
                <div class="card event-info-card">
                    <div class="event-info-box">
                        <div class="row">
                            <div class="col-md-6 text-center event-info-divider-col" style="border-right: 1px solid rgba(255,255,255,0.25);">
                                <div class="info-header-icon">
                                    <i class="material-icons">event</i>
                                </div>
                                <div class="info-label">Waktu Kegiatan</div>
                                <div class="info-value-main">
                                    <?php
                                    if (!empty($data_panitia['waktu'])) {
                                        $date = date_create($data_panitia['waktu']);
                                        if ($date) {
                                            $bulan_indo = [
                                                '01' => 'Januari',
                                                '02' => 'Februari',
                                                '03' => 'Maret',
                                                '04' => 'April',
                                                '05' => 'Mei',
                                                '06' => 'Juni',
                                                '07' => 'Juli',
                                                '08' => 'Agustus',
                                                '09' => 'September',
                                                '10' => 'Oktober',
                                                '11' => 'November',
                                                '12' => 'Desember'
                                            ];
                                            $tgl = date_format($date, "d");
                                            $bln = date_format($date, "m");
                                            $thn = date_format($date, "Y");
                                            echo $tgl . ' ' . ($bulan_indo[$bln] ?? $bln) . ' ' . $thn;
                                        } else {
                                            echo $data_panitia['waktu'];
                                        }
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </div>
                                <?php if (!empty($data_panitia['jam'])): ?>
                                    <div>
                                        <span class="info-time-badge">
                                            <i class="material-icons" style="font-size: 15px; vertical-align: middle;">schedule</i>
                                            <?= e($data_panitia['jam']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="info-header-icon">
                                    <i class="material-icons">place</i>
                                </div>
                                <div class="info-label">Lokasi Kegiatan</div>
                                <div class="info-value-main">
                                    <?= e($data_panitia['tempat']) ?>
                                </div>
                            </div>
                        </div>
                        <div style="background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%); height: 1px; margin: 24px 0 20px 0;"></div>
                        <div class="row">
                            <div class="col-xs-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon"><i class="material-icons">domain</i></div>
                                    <div class="stat-number"><?php echo $jml_taman; ?></div>
                                    <div class="stat-label">Taman</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon"><i class="material-icons">gavel</i></div>
                                    <div class="stat-number"><?php echo $jml_juri; ?></div>
                                    <div class="stat-label">Dewan Juri</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon"><i class="material-icons">people</i></div>
                                    <div class="stat-number"><?php echo $jml_pa; ?></div>
                                    <div class="stat-label">Peserta Putra</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon"><i class="material-icons">people_outline</i></div>
                                    <div class="stat-number"><?php echo $jml_pi; ?></div>
                                    <div class="stat-label">Peserta Putri</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Apps Grid Menu (Hanya Muncul di Mobile) -->
        <div class="row mobile-grid-home">
            <div class="col-xs-12">
                <div style="font-size:12px; font-weight:700; color:#5D4037; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:10px; display:flex; align-items:center; gap:6px;">
                    <i class="material-icons" style="font-size:18px;">grid_view</i> Menu Kegiatan
                </div>
                <div class="mobile-grid-menu">
                    <a href="?page=taman" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="material-icons">domain</i>
                            </div>
                            <span class="mobile-grid-label">Taman</span>
                        </div>
                    </a>
                    <a href="?page=juri" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="material-icons">gavel</i>
                            </div>
                            <span class="mobile-grid-label">Dewan Juri</span>
                        </div>
                    </a>
                    <a href="?page=peserta_pa" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                                <i class="material-icons">directions_run</i>
                            </div>
                            <span class="mobile-grid-label">Peserta PA</span>
                        </div>
                    </a>
                    <a href="?page=peserta_pi" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #ec4899, #db2777);">
                                <i class="material-icons">local_florist</i>
                            </div>
                            <span class="mobile-grid-label">Peserta PI</span>
                        </div>
                    </a>
                    <a href="?page=nilai_pa" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                                <i class="material-icons">bar_chart</i>
                            </div>
                            <span class="mobile-grid-label">Nilai PA</span>
                        </div>
                    </a>
                    <a href="?page=nilai_pi" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                <i class="material-icons">analytics</i>
                            </div>
                            <span class="mobile-grid-label">Nilai PI</span>
                        </div>
                    </a>
                    <a href="?page=prestasi_berprestasi" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                                <i class="material-icons">military_tech</i>
                            </div>
                            <span class="mobile-grid-label">Berprestasi</span>
                        </div>
                    </a>
                    <a href="?page=prestasi_juaraumum" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #eab308, #ca8a04);">
                                <i class="material-icons">emoji_events</i>
                            </div>
                            <span class="mobile-grid-label">Juara Umum</span>
                        </div>
                    </a>
                    <a href="?page=denah" class="mobile-grid-item">
                        <div class="mobile-grid-box">
                            <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #14b8a6, #0d9488);">
                                <i class="material-icons">map</i>
                            </div>
                            <span class="mobile-grid-label">Denah</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row desktop-home-block">
            <div class="col-md-12">
                <div class="welcome-card">
                    <div class="welcome-body">
                        <?php if (!empty($data_panitia['info_image'])): ?>
                        <div class="welcome-media">
                            <img src="assets/images/<?= $data_panitia['info_image'] ?>" alt="Ilustrasi Sambutan">
                        </div>
                        <?php endif; ?>
                        <div class="welcome-content">
                            <span class="welcome-eyebrow">
                                <i class="material-icons">campaign</i> Sambutan Panitia
                            </span>
                            <div class="welcome-text">
                                <?= $data_panitia['pesan_beranda'] ?? '' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MOBILE: Pesan Sambutan (App Style) -->
        <div class="row mobile-welcome">
            <div class="col-xs-12">
                <div class="mob-section-title"><i class="material-icons">campaign</i> Pesan Sambutan</div>
                <div class="mob-welcome-card">
                    <?php if (!empty($data_panitia['info_image'])): ?>
                        <div class="mob-welcome-img">
                            <img src="assets/images/<?= $data_panitia['info_image'] ?>" alt="Info Image">
                        </div>
                    <?php endif; ?>
                    <div class="mob-welcome-text">
                        <?= $data_panitia['pesan_beranda'] ?? '' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>