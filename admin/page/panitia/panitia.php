<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_panitia WHERE id_panitia='$id'");
?>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">settings</i> Pengaturan</li>
        </ol>
    </div>

    <style>
        .setting-card { border: 0; border-radius: 14px; overflow: hidden; box-shadow: 0 5px 18px rgba(0,0,0,.08); }
        .setting-card .header { padding: 20px 24px; background: linear-gradient(135deg, #1b5e20, #43a047); color: #fff; }
        .setting-card .header h2 { color: #fff; font-size: 18px; margin: 0; }
        .setting-card .body { padding: 24px; }
        .setting-grid { display: flex; flex-wrap: wrap; margin: -8px; }
        .setting-item { display: flex; align-items: center; flex: 0 0 calc(50% - 16px); width: calc(50% - 16px); margin: 8px; padding: 16px; border-radius: 12px; background: #f7faf8; border-left: 4px solid #43a047; min-height: 82px; box-sizing: border-box; }
        @media (max-width: 767px) {
            .setting-item { flex: 0 0 calc(100% - 16px); width: calc(100% - 16px); }
        }
        .setting-item .material-icons { margin-right: 14px; color: #2e7d32; font-size: 30px; flex-shrink: 0; }
        .setting-item .setting-content { flex: 1; min-width: 0; }
        .setting-item .caption { display: block; color: #78909c; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; }
        .setting-item .value { display: block; margin-top: 5px; color: #263238; font-size: 15px; font-weight: 600; word-break: break-word; line-height: 1.4; }
        .setting-message { padding: 16px; border-radius: 10px; background: #f7faf8; margin-bottom: 14px; }
        .setting-message strong { display: block; color: #2e7d32; margin-bottom: 8px; }
        .setting-message .message-content { color: #455a64; line-height: 1.6; max-height: 120px; overflow: auto; }
        .setting-action { margin-top: 20px; }
        .status-pill { display: inline-block; padding: 7px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; letter-spacing: .6px; }
        .status-open { background: #e8f5e9; color: #2e7d32; }
        .status-closed { background: #ffebee; color: #c62828; }
        .media-preview-box { border-radius: 10px; padding: 12px; background: #f7faf8; border: 1px solid #e8f5e9; height: 180px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 15px; }
        .media-preview-box img { max-height: 100%; max-width: 100%; object-fit: contain; border-radius: 6px; }
    </style>

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card setting-card">
                <div class="header"><h2><i class="material-icons">event</i> WAKTU DAN TEMPAT</h2></div>
                <div class="body">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { ?>
                    <div class="setting-grid">
                        <div class="setting-item">
                            <i class="material-icons">today</i>
                            <div class="setting-content">
                                <span class="caption">Tanggal Kegiatan</span>
                                <span class="value"><?php $hari = $data['waktu'] ?? ''; echo $hari ? e(format_hari_tanggal($hari)) : '-'; ?></span>
                            </div>
                        </div>
                        <div class="setting-item">
                            <i class="material-icons">schedule</i>
                            <div class="setting-content">
                                <span class="caption">Waktu / Jam</span>
                                <span class="value"><?= e($data['jam'] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="setting-item">
                            <i class="material-icons">place</i>
                            <div class="setting-content">
                                <span class="caption">Lokasi Kegiatan</span>
                                <span class="value"><?= e($data['tempat'] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="setting-item">
                            <i class="material-icons">create</i>
                            <div class="setting-content">
                                <span class="caption">Tempat TTD</span>
                                <span class="value"><?= e($data['tempat_ttd'] ?? '-'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_waktu<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit Waktu dan Tempat</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card setting-card">
                <div class="header"><h2><i class="material-icons">message</i> PENGATURAN HOME & PESAN</h2></div>
                <div class="body">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { $is_open = ($data['status_home'] ?? '') === 'Buka'; ?>
                    <div style="margin-bottom: 18px;"><span class="caption">Status tampilan halaman utama</span><span class="status-pill <?= $is_open ? 'status-open' : 'status-closed'; ?>"><i class="material-icons" style="font-size:14px;vertical-align:middle;"><?= $is_open ? 'check_circle' : 'block'; ?></i> <?= $is_open ? 'HOME BUKA' : 'HOME TUTUP'; ?></span></div>
                    <div class="setting-message"><strong>Pesan Beranda</strong><div class="message-content"><?= $data['pesan_beranda'] ?? '<em>Belum ada pesan</em>'; ?></div></div>
                    <div class="setting-message"><strong>Pesan Saat Ditutup</strong><div class="message-content"><?= $data['pesan_tutup'] ?? '<em>Belum ada pesan</em>'; ?></div></div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_pesan<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit Pesan dan Status</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card setting-card">
                <div class="header"><h2><i class="material-icons">assignment</i> DATA KEGIATAN</h2></div>
                <div class="body">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { ?>
                    <div class="setting-grid">
                        <div class="setting-item">
                            <i class="material-icons">event_note</i>
                            <div class="setting-content">
                                <span class="caption">Nama Kegiatan</span>
                                <span class="value"><?= e($data['nama_kegiatan'] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="setting-item">
                            <i class="material-icons">person</i>
                            <div class="setting-content">
                                <span class="caption">Ketua Kwartir</span>
                                <span class="value"><?= e($data['ka_kwarran'] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="setting-item">
                            <i class="material-icons">supervisor_account</i>
                            <div class="setting-content">
                                <span class="caption">Ketua Panitia</span>
                                <span class="value"><?= e($data['ketua_panitia'] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="setting-item">
                            <i class="material-icons">gavel</i>
                            <div class="setting-content">
                                <span class="caption">Ketua Dewan Juri</span>
                                <span class="value"><?= e($data['ketua_juri'] ?? '-'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_edit<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit Data Kegiatan</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- LOGO KEGIATAN -->
        <div class="col-md-6 col-sm-12">
            <div class="card setting-card">
                <div class="header">
                    <h2><i class="material-icons">image</i> LOGO KEGIATAN</h2>
                </div>
                <div class="body text-center" style="text-align: center;">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { ?>
                    <div class="media-preview-box">
                        <?php if (!empty($data['logo']) && file_exists("../assets/images/" . safe_basename($data['logo']))): ?>
                            <img src="../assets/images/<?= e(safe_basename($data['logo'])); ?>" alt="Logo">
                        <?php else: ?>
                            <span class="text-muted">Belum ada logo</span>
                        <?php endif; ?>
                    </div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_logo<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti Logo</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- HERO IMAGE (BERANDA) -->
        <div class="col-md-6 col-sm-12">
            <div class="card setting-card">
                <div class="header">
                    <h2><i class="material-icons">photo_library</i> HERO IMAGE (BERANDA)</h2>
                </div>
                <div class="body text-center" style="text-align: center;">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { ?>
                    <div class="media-preview-box">
                        <?php if (!empty($data['hero_image']) && file_exists("../assets/images/" . safe_basename($data['hero_image']))): ?>
                            <img src="../assets/images/<?= e(safe_basename($data['hero_image'])); ?>" alt="Hero Image">
                        <?php else: ?>
                            <span class="text-muted">Belum ada hero image</span>
                        <?php endif; ?>
                    </div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_hero<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti Hero Image</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- DENAH LOKASI -->
        <div class="col-md-6 col-sm-12">
            <div class="card setting-card">
                <div class="header">
                    <h2><i class="material-icons">map</i> DENAH LOKASI</h2>
                </div>
                <div class="body text-center" style="text-align: center;">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { ?>
                    <div class="media-preview-box">
                        <?php if (!empty($data['denah_lokasi']) && file_exists("../assets/images/" . safe_basename($data['denah_lokasi']))): ?>
                            <img src="../assets/images/<?= e(safe_basename($data['denah_lokasi'])); ?>" alt="Denah Lokasi">
                        <?php else: ?>
                            <span class="text-muted">Belum ada denah lokasi</span>
                        <?php endif; ?>
                    </div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_denah<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti Denah Lokasi</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- BACKGROUND LOGIN -->
        <div class="col-md-6 col-sm-12">
            <div class="card setting-card">
                <div class="header">
                    <h2><i class="material-icons">wallpaper</i> BACKGROUND LOGIN</h2>
                </div>
                <div class="body text-center" style="text-align: center;">
                    <?php foreach (db_all($koneksi, "SELECT * FROM tb_panitia") as $data) { ?>
                    <div class="media-preview-box">
                        <?php if (!empty($data['bg']) && file_exists("../assets/images/" . safe_basename($data['bg']))): ?>
                            <img src="../assets/images/<?= e(safe_basename($data['bg'])); ?>" alt="Background Login">
                        <?php else: ?>
                            <span class="text-muted">Belum ada background</span>
                        <?php endif; ?>
                    </div>
                    <div class="setting-action"><a data-toggle="modal" data-target="#modal_bg<?= (int)$data['id_panitia']; ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti Background</a></div>
                    <?php } ?>
                </div>
            </div>
        </div>



    </div>
<?php
include "modal_edit.php";
include "modal_logo.php";
include "modal_bg.php";
include "modal_waktu.php";
include "modal_pesan.php";
include "modal_hero.php";
include "modal_denah.php";
?>