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
                <div class="card" style="margin-top: -15px; margin-bottom: 30px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); position: relative; z-index: 10;">
                    <div class="body" style="background-color: #ff9800; color: white; padding: 20px;">
                        <div class="row">
                            <div class="col-md-6 text-center" style="border-right: 1px solid rgba(255,255,255,0.3);">
                                <h4 style="margin-top: 0; color: white;"><i class="glyphicon glyphicon-calendar"></i> WAKTU KEGIATAN</h4>
                                <p style="font-size: 18px; font-weight: bold; margin-bottom: 0;">
                                    <?php
                                    if (!empty($data_panitia['waktu'])) {
                                        $date = date_create($data_panitia['waktu']);
                                        echo ($date) ? date_format($date, "d F Y") : $data_panitia['waktu'];
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </p>
                                <?php if (!empty($data_panitia['jam'])): ?>
                                    <p style="font-size: 16px; margin-bottom: 0;"><?= $data_panitia['jam'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 text-center">
                                <h4 style="margin-top: 0; color: white;"><i class="glyphicon glyphicon-map-marker"></i> LOKASI KEGIATAN</h4>
                                <p style="font-size: 18px; font-weight: bold; margin-bottom: 0;">
                                    <?= $data_panitia['tempat'] ?>
                                </p>
                            </div>
                        </div>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.3); margin: 20px 0;">
                        <div class="row text-center">
                            <div class="col-xs-3 col-md-3" style="border-right: 1px solid rgba(255,255,255,0.3);">
                                <h3 style="margin: 0; font-weight: bold; color: white !important;"><?php echo $jml_taman; ?></h3>
                                <small style="color: white !important;">TAMAN</small>
                            </div>
                            <div class="col-xs-3 col-md-3" style="border-right: 1px solid rgba(255,255,255,0.3);">
                                <h3 style="margin: 0; font-weight: bold; color: white !important;"><?php echo $jml_juri; ?></h3>
                                <small style="color: white !important;">DEWAN JURI</small>
                            </div>
                            <div class="col-xs-3 col-md-3" style="border-right: 1px solid rgba(255,255,255,0.3);">
                                <h3 style="margin: 0; font-weight: bold; color: white !important;"><?php echo $jml_pa; ?></h3>
                                <small style="color: white !important;">PESERTA PUTRA</small>
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <h3 style="margin: 0; font-weight: bold; color: white !important;"><?php echo $jml_pi; ?></h3>
                                <small style="color: white !important;">PESERTA PUTRI</small>
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