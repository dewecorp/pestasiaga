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

    <div class="row clearfix">
        <!-- WAKTU DAN TEMPAT -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">home</i> WAKTU DAN TEMPAT
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table style="font-size: 18px" class="table table-bordered table-hover">
                        <tr>
                            <td align="left" width="200px" style="font-weight: bold;">Waktu Kegiatan</td>
                            <td align="left"><?php $hari=$data['waktu']; echo format_hari_tanggal($hari) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Lokasi Kegiatan</td>
                            <td><?=$data['tempat']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Tempat TTD</td>
                            <td><?=$data['tempat_ttd']; ?></td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_waktu<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit</button></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- PENGATURAN HOME & PESAN -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">message</i> PENGATURAN HOME & PESAN
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table style="font-size: 18px" class="table table-bordered table-hover">
                        <tr>
                            <td align="left" width="200px" style="font-weight: bold;">Status Home</td>
                            <td align="left">
                                <?php if ($data['status_home'] == 'Buka'): ?>
                                    <span class="label label-success">BUKA</span>
                                <?php else: ?>
                                    <span class="label label-danger">TUTUP</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="200px" style="font-weight: bold;">Pesan Beranda</td>
                            <td align="left"><?= isset($data['pesan_beranda']) ? $data['pesan_beranda'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td align="left" width="200px" style="font-weight: bold;">Pesan Tutup</td>
                            <td align="left"><?= isset($data['pesan_tutup']) ? $data['pesan_tutup'] : ''; ?></td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_pesan<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit</button></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- DATA KEGIATAN -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">archive</i> DATA KEGIATAN
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table style="font-size: 18px" class="table table-bordered table-hover">
                        <tr>
                            <td width="200px" style="font-weight:bold">Nama Kegiatan</td>
                            <td><?= isset($data['nama_kegiatan']) ? $data['nama_kegiatan'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td width="200px" style="font-weight:bold">Ketua Kwartir</td>
                            <td><?=$data['ka_kwarran']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Ketua Panitia</td>
                            <td><?=$data['ketua_panitia']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Ketua Dewan Juri</td>
                            <td><?=$data['ketua_juri']; ?></td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_edit<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit</button></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- LOGO KEGIATAN -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">image</i> LOGO KEGIATAN
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td align="center">
                                <img src="../assets/images/<?=$data['logo']; ?>" width="180" height="160" alt="Logo">
                            </td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_logo<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti</button></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- HERO IMAGE (BERANDA) -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">image</i> HERO IMAGE (BERANDA)
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td align="center">
                                <?php if (!empty($data['hero_image'])): ?>
                                    <img src="../assets/images/<?=$data['hero_image']; ?>" width="400" height="200" alt="Hero Image">
                                <?php else: ?>
                                    <p>Belum ada hero image</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_hero<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti</button></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- DENAH LOKASI -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">map</i> DENAH LOKASI
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td align="center">
                                <?php if (!empty($data['denah_lokasi'])): ?>
                                    <img src="../assets/images/<?=$data['denah_lokasi']; ?>" width="400" height="200" alt="Denah Lokasi">
                                <?php else: ?>
                                    <p>Belum ada denah lokasi</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_denah<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti</button></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- BACKGROUND LOGIN -->
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        <i class="material-icons">image</i> BACKGROUND LOGIN
                    </h2>
                </div>
                <div class="body">
                    <?php
                    $sql = $koneksi->query("SELECT * FROM tb_panitia");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td align="center">
                                <img src="../assets/images/<?=$data['bg']; ?>" width="400" height="200" alt="Background">
                            </td>
                        </tr>
                    </table>
                    <div>
                        <a data-toggle="modal" data-target="#modal_bg<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti</button></a>
                    </div>
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