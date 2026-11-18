<?php
$data = db_one($koneksi, "SELECT * FROM tb_panitia");
$pid  = (int)($data['id_panitia'] ?? 0);
$is_open = ($data['status_home'] ?? '') === 'Buka';
?>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">settings</i> Pengaturan</li>
        </ol>
    </div>

    <style>
        .setting-card { border: 0; border-radius: 14px; overflow: hidden; box-shadow: 0 5px 18px rgba(0,0,0,.08); }
        .setting-card > .header { padding: 20px 28px; background: linear-gradient(135deg, #1b5e20, #43a047); color: #fff; }
        .setting-card > .header h2 { color: #fff; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px; }
        .setting-card > .body { padding: 0; }

        /* Section divider */
        .setting-section { padding: 24px 28px; border-bottom: 1px solid #eef2ee; }
        .setting-section:last-child { border-bottom: none; }
        .setting-section-title {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .7px; color: #2e7d32; margin-bottom: 16px;
        }
        .setting-section-title .material-icons { font-size: 18px; }

        /* Info grid */
        .setting-grid { display: flex; flex-wrap: wrap; gap: 12px; }
        .setting-item {
            display: flex; align-items: center; flex: 1 1 calc(50% - 6px);
            padding: 14px 16px; border-radius: 10px;
            background: #f7faf8; border-left: 4px solid #43a047;
            min-width: 200px; box-sizing: border-box;
        }
        @media (max-width: 767px) { .setting-item { flex: 1 1 100%; } }
        .setting-item .material-icons { margin-right: 12px; color: #2e7d32; font-size: 26px; flex-shrink: 0; }
        .setting-item .setting-content { flex: 1; min-width: 0; }
        .setting-item .caption { display: block; color: #78909c; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; }
        .setting-item .value { display: block; margin-top: 4px; color: #263238; font-size: 14px; font-weight: 600; word-break: break-word; line-height: 1.4; }

        /* Status pill */
        .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; letter-spacing: .5px; }
        .status-open { background: #e8f5e9; color: #2e7d32; }
        .status-closed { background: #ffebee; color: #c62828; }

        /* Pesan box */
        .setting-message { border-radius: 8px; background: #f7faf8; padding: 14px 16px; margin-bottom: 10px; }
        .setting-message:last-of-type { margin-bottom: 0; }
        .setting-message strong { display: block; color: #2e7d32; margin-bottom: 6px; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; }
        .setting-message .message-content { color: #455a64; line-height: 1.6; max-height: 100px; overflow: auto; }

        /* Media preview */
        .media-grid { display: flex; flex-wrap: wrap; gap: 16px; }
        .media-block { flex: 1 1 calc(25% - 12px); min-width: 160px; }
        @media (max-width: 991px) { .media-block { flex: 1 1 calc(50% - 8px); } }
        @media (max-width: 575px) { .media-block { flex: 1 1 100%; } }
        .media-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #78909c; margin-bottom: 8px; }
        .media-preview-box {
            border-radius: 10px; background: #f7faf8; border: 1px solid #e0ede0;
            height: 150px; display: flex; align-items: center; justify-content: center;
            overflow: hidden; margin-bottom: 10px;
        }
        .media-preview-box img { max-height: 100%; max-width: 100%; object-fit: contain; border-radius: 6px; }

        /* Action row */
        .setting-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
        .setting-actions .btn { border-radius: 8px; }
    </style>

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card setting-card">
                <div class="header">
                    <h2><i class="material-icons">settings</i> PENGATURAN SISTEM</h2>
                </div>
                <div class="body">

                    <!-- SECTION: Waktu dan Tempat -->
                    <div class="setting-section">
                        <div class="setting-section-title"><i class="material-icons">event</i> Waktu dan Tempat</div>
                        <div class="setting-grid">
                            <div class="setting-item">
                                <i class="material-icons">today</i>
                                <div class="setting-content">
                                    <span class="caption">Tanggal Kegiatan</span>
                                    <span class="value"><?php $w=$data['waktu']??''; echo $w ? e(format_hari_tanggal($w)) : '-'; ?></span>
                                </div>
                            </div>
                            <div class="setting-item">
                                <i class="material-icons">schedule</i>
                                <div class="setting-content">
                                    <span class="caption">Waktu / Jam</span>
                                    <span class="value"><?= e($data['jam'] ?? '-') ?></span>
                                </div>
                            </div>
                            <div class="setting-item">
                                <i class="material-icons">place</i>
                                <div class="setting-content">
                                    <span class="caption">Lokasi Kegiatan</span>
                                    <span class="value"><?= e($data['tempat'] ?? '-') ?></span>
                                </div>
                            </div>
                            <div class="setting-item">
                                <i class="material-icons">create</i>
                                <div class="setting-content">
                                    <span class="caption">Tempat TTD</span>
                                    <span class="value"><?= e($data['tempat_ttd'] ?? '-') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="setting-actions">
                            <a data-toggle="modal" data-target="#modal_waktu<?= $pid ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit Waktu dan Tempat</a>
                        </div>
                    </div>

                    <!-- SECTION: Data Kegiatan -->
                    <div class="setting-section">
                        <div class="setting-section-title"><i class="material-icons">assignment</i> Data Kegiatan</div>
                        <div class="setting-grid">
                            <div class="setting-item">
                                <i class="material-icons">event_note</i>
                                <div class="setting-content">
                                    <span class="caption">Nama Kegiatan</span>
                                    <span class="value"><?= e($data['nama_kegiatan'] ?? '-') ?></span>
                                </div>
                            </div>
                            <div class="setting-item">
                                <i class="material-icons">person</i>
                                <div class="setting-content">
                                    <span class="caption">Ketua Kwartir</span>
                                    <span class="value"><?= e($data['ka_kwarran'] ?? '-') ?></span>
                                </div>
                            </div>
                            <div class="setting-item">
                                <i class="material-icons">supervisor_account</i>
                                <div class="setting-content">
                                    <span class="caption">Ketua Panitia</span>
                                    <span class="value"><?= e($data['ketua_panitia'] ?? '-') ?></span>
                                </div>
                            </div>
                            <div class="setting-item">
                                <i class="material-icons">gavel</i>
                                <div class="setting-content">
                                    <span class="caption">Ketua Dewan Juri</span>
                                    <span class="value"><?= e($data['ketua_juri'] ?? '-') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="setting-actions">
                            <a data-toggle="modal" data-target="#modal_edit<?= $pid ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit Data Kegiatan</a>
                        </div>
                    </div>

                    <!-- SECTION: Home & Pesan -->
                    <div class="setting-section">
                        <div class="setting-section-title"><i class="material-icons">message</i> Home &amp; Pesan</div>
                        <div style="margin-bottom: 14px;">
                            <span style="font-size:12px;color:#78909c;text-transform:uppercase;letter-spacing:.5px;margin-right:10px;">Status halaman utama</span>
                            <span class="status-pill <?= $is_open ? 'status-open' : 'status-closed' ?>">
                                <i class="material-icons" style="font-size:14px;"><?= $is_open ? 'check_circle' : 'block' ?></i>
                                <?= $is_open ? 'HOME BUKA' : 'HOME TUTUP' ?>
                            </span>
                        </div>
                        <div class="setting-message">
                            <strong>Pesan Beranda</strong>
                            <div class="message-content"><?= $data['pesan_beranda'] ?? '<em>Belum ada pesan</em>' ?></div>
                        </div>
                        <div class="setting-message">
                            <strong>Pesan Saat Ditutup</strong>
                            <div class="message-content"><?= $data['pesan_tutup'] ?? '<em>Belum ada pesan</em>' ?></div>
                        </div>
                        <div class="setting-actions">
                            <a data-toggle="modal" data-target="#modal_pesan<?= $pid ?>" class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit Pesan dan Status</a>
                        </div>
                    </div>

                    <!-- SECTION: Media -->
                    <div class="setting-section">
                        <div class="setting-section-title"><i class="material-icons">photo_library</i> Media</div>
                        <div class="media-grid">

                            <div class="media-block">
                                <div class="media-label">Logo Kegiatan</div>
                                <div class="media-preview-box">
                                    <?php if (!empty($data['logo']) && file_exists("../assets/images/" . safe_basename($data['logo']))): ?>
                                        <img src="../assets/images/<?= e(safe_basename($data['logo'])) ?>" alt="Logo">
                                    <?php else: ?><span class="text-muted">Belum ada logo</span><?php endif; ?>
                                </div>
                                <a data-toggle="modal" data-target="#modal_logo<?= $pid ?>" class="btn btn-success btn-sm btn-block waves-effect"><i class="fa fa-edit"></i> Ganti Logo</a>
                            </div>

                            <div class="media-block">
                                <div class="media-label">Hero Image (Beranda)</div>
                                <div class="media-preview-box">
                                    <?php if (!empty($data['hero_image']) && file_exists("../assets/images/" . safe_basename($data['hero_image']))): ?>
                                        <img src="../assets/images/<?= e(safe_basename($data['hero_image'])) ?>" alt="Hero Image">
                                    <?php else: ?><span class="text-muted">Belum ada hero image</span><?php endif; ?>
                                </div>
                                <a data-toggle="modal" data-target="#modal_hero<?= $pid ?>" class="btn btn-success btn-sm btn-block waves-effect"><i class="fa fa-edit"></i> Ganti Hero Image</a>
                            </div>

                            <div class="media-block">
                                <div class="media-label">Denah Lokasi</div>
                                <div class="media-preview-box">
                                    <?php if (!empty($data['denah_lokasi']) && file_exists("../assets/images/" . safe_basename($data['denah_lokasi']))): ?>
                                        <img src="../assets/images/<?= e(safe_basename($data['denah_lokasi'])) ?>" alt="Denah Lokasi">
                                    <?php else: ?><span class="text-muted">Belum ada denah</span><?php endif; ?>
                                </div>
                                <a data-toggle="modal" data-target="#modal_denah<?= $pid ?>" class="btn btn-success btn-sm btn-block waves-effect"><i class="fa fa-edit"></i> Ganti Denah</a>
                            </div>

                            <div class="media-block">
                                <div class="media-label">Background Login</div>
                                <div class="media-preview-box">
                                    <?php if (!empty($data['bg']) && file_exists("../assets/images/" . safe_basename($data['bg']))): ?>
                                        <img src="../assets/images/<?= e(safe_basename($data['bg'])) ?>" alt="Background Login">
                                    <?php else: ?><span class="text-muted">Belum ada background</span><?php endif; ?>
                                </div>
                                <a data-toggle="modal" data-target="#modal_bg<?= $pid ?>" class="btn btn-success btn-sm btn-block waves-effect"><i class="fa fa-edit"></i> Ganti Background</a>
                            </div>

                        </div>
                    </div>

                </div><!-- /.body -->
            </div><!-- /.card -->
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
