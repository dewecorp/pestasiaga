<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_panitia WHERE id_panitia='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Panitia</title>
    <link rel="stylesheet" href="">
</head>

<body>
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
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#waktu" data-toggle="tab">
                                <i class="material-icons">home</i> WAKTU DAN TEMPAT
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#data" data-toggle="tab">
                                <i class="material-icons">archive</i> DATA KEGIATAN
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#logo" data-toggle="tab">
                                <i class="material-icons">image</i> LOGO KEGIATAN
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#gambar" data-toggle="tab">
                                <i class="material-icons">camera_alt</i> GAMBAR LATAR
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tentang" data-toggle="tab">
                                <i class="material-icons">help</i> TENTANG APLIKASI
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="waktu">
                            <div class="body">

                                <?php
									$sql = $koneksi->query("SELECT * FROM tb_panitia");
									while ($data = $sql->fetch_assoc()) {
									?>
                                <table style="font-size: 18px" class="table table-bordered table-hover">
                                    <tr>
                                        <td align="left" width="200px" style="font-weight: bold;">Waktu Kegiatan</td>
                                        <td align="left"><?php $hari=$data['waktu']; echo format_hari_tanggal($hari) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Tempat Kegiatan</td>
                                        <td><?=$data['tempat']; ?></td>
                                    </tr>
                                </table>
                                <?php
									}
									?>

                                <div class="">
                                    <a data-toggle="modal" data-target="#modal_waktu<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i>
                                            Edit</button></a>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="data">
                            <div class="body">
                                <?php
									$sql = $koneksi->query("SELECT * FROM tb_panitia");
									while ($data = $sql->fetch_assoc()) {
									?>
                                <table style="font-size: 18px" class="table table-bordered table-hover">
                                    <tr>
                                        <td width="200px" style="font-weight:bold">Ka. Kwarran</td>
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

                                <div class="">
                                    <a data-toggle="modal" data-target="#modal_edit<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i>
                                            Edit</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="logo">
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
                                <?php
									}
									?>
                                <div class="">
                                    <a data-toggle="modal" data-target="#modal_logo<?=$data['id']; ?>"><button class="btn btn-success btn-sm waves-effect"><i class="fa fa-edit"></i>
                                            Ganti</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="gambar">
                            <div class="body">

                                <?php
									$sql = $koneksi->query("SELECT * FROM tb_panitia");
									while ($data = $sql->fetch_assoc()) {
									?>
                                <table class="table table-bordered">
                                    <tr>
                                        <td align="center">
                                            <img src="../assets/images/<?=$data['bg']; ?>" width="300" height="160" alt="Background">
                                        </td>
                                    </tr>
                                </table>

                                <?php
									}
									?>
                                <div class="">
                                    <a data-toggle="modal" data-target="#modal_bg<?=$data['id']; ?>"><button class="btn btn-success btn-sm  waves-effect"><i class="fa fa-edit"></i>
                                            Ganti</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade align-justify" id="tentang">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <p style="font-size: 18px;">
                                            APLIKASI PENILAIAN PESTA SIAGA INI DIBUAT OLEH TIM IT KWARRAN KEDUNG
                                            <?php echo date('Y')?>. DENGAN SEMANGAT
                                            IKHLAS BAKTI BINA BANGSA BERBUDI BAWA LAKSANA, SEMOGA APLIKASI INI
                                            BERMANFAAT BAGI
                                            KEGIATAN KEPRAMUKAAN DI LINGKUNGAN KWARRAN KEDUNG KHUSUSNYA DAN DI
                                            LINGKUNGAN KWARCAB
                                            JEPARA UMUMNYA. BERBAKTI TIADA HENTI. MENJADI PANDU IBU PERTIWI.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <marquee>
        <h2>IKHLAS BAKTI BINA BANGSA BERBUDI BAWA LAKSANA</h2>
    </marquee>
</body>

</html>
<?php
include "modal_edit.php";
include "modal_logo.php";
include "modal_bg.php";
include "modal_waktu.php";
?>
