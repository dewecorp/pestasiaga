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
        @media (max-width: 768px) {
            .lead-message {
                font-size: 14px !important;
            }
            .lead-message h1, .lead-message h2, .lead-message h3, .lead-message h4, .lead-message h5, .lead-message h6 {
                font-size: 18px !important;
                line-height: 1.3 !important;
            }
            .lead-message p, .lead-message div, .lead-message span {
                font-size: 14px !important;
                line-height: 1.4 !important;
            }
            .event-info-box {
                padding: 20px 15px !important;
            }
            .event-info-divider-col {
                border-right: none !important;
                border-bottom: 1px solid rgba(255,255,255,0.2);
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }

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
    </style>
    <div class="jumbotron hero bg-light-brown" style="<?= !empty($data_panitia['hero_image']) ? "background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/".$data_panitia['hero_image']."'); background-size: cover; background-position: center; color: white;" : "" ?>">
        <div class="container">
            <h1 style="font-size: 60px; font-weight: bold;">Selamat Datang</h1>
            <h2><?= $data_panitia['nama_kegiatan'] ?> <?= date('Y') ?></h2>
        </div>
    </div>
    <div class="container content-section">
        <div class="row">
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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header bg-purple">
                        <h2><i class="glyphicon glyphicon-bullhorn"></i> Selamat Datang</h2>
                    </div>
                    <div class="body">
                        <?php if (!empty($data_panitia['info_image'])): ?>
                            <div style="text-align: center; margin-bottom: 20px;">
                                <img src="assets/images/<?= $data_panitia['info_image'] ?>" alt="Info Image" style="max-width: 100%; height: auto; max-height: 400px; mix-blend-mode: multiply;">
                            </div>
                        <?php endif; ?>
                        <div class="lead-message">
                            <?= $data_panitia['pesan_beranda'] ?? '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>