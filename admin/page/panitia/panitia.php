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
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        PENGATURAN
                    </h2>
                </div>
                <div class="body">
                    <div class="section">
                        <h4><i class="material-icons">home</i> WAKTU DAN TEMPAT</h4>
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
                                <td style="font-weight: bold;">Tempat Kegiatan</td>
                                <td><?=$data['tempat']; ?></td>
                            </tr>
                        </table>
                        <?php
							}
							?>
                        <div>
                            <a data-toggle="modal" data-target="#modal_waktu<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit</button></a>
                        </div>
                    </div>
                    <div class="section" style="margin-top:20px">
                        <h4><i class="material-icons">archive</i> DATA KEGIATAN</h4>
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
                        <?php
							}
							?>
                        <div>
                            <a data-toggle="modal" data-target="#modal_edit<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Edit</button></a>
                        </div>
                    </div>
                    <div class="section" style="margin-top:20px">
                        <h4><i class="material-icons">image</i> LOGO KEGIATAN</h4>
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
                        <?php
							}
							?>
                        <div>
                            <a data-toggle="modal" data-target="#modal_logo<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i> Ganti</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include "modal_edit.php";
include "modal_logo.php";
include "modal_waktu.php";
?>
