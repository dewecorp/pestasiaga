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
    // Show normal home
    ?>
    <div class="jumbotron hero bg-light-brown" style="<?= !empty($data_panitia['hero_image']) ? "background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/".$data_panitia['hero_image']."'); background-size: cover; background-position: center; color: white;" : "" ?>">
        <div class="container">
            <h1 style="font-size: 60px; font-weight: bold;">Selamat Datang</h1>
            <h2><?= $data_panitia['nama_kegiatan'] ?> <?= date('Y') ?></h2>
        </div>
    </div>
    <div class="container content-section">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin-top: -30px; z-index: 10; position: relative; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <div class="body" style="background-color: #ff9800; color: white; padding: 20px;">
                        <div class="row">
                            <div class="col-md-6 text-center" style="border-right: 1px solid rgba(255,255,255,0.3);">
                                <h4 style="margin-top: 0; color: white;"><i class="glyphicon glyphicon-calendar"></i> WAKTU KEGIATAN</h4>
                                <p style="font-size: 18px; font-weight: bold; margin-bottom: 0;">
                                    <?php
                                    $date = date_create($data_panitia['waktu']);
                                    echo date_format($date, "d F Y");
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header bg-purple">
                        <h2><i class="glyphicon glyphicon-bullhorn"></i> Informasi Terkini</h2>
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