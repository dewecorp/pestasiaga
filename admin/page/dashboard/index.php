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
$data_user = $koneksi->query("SELECT * FROM tb_user");
// menghitung data user
$jumlah_user = $data_user->num_rows;
$total_peserta = $jumlah_peserta_pa + $jumlah_peserta_pi;
$sql = $koneksi->query("SELECT * FROM tb_user WHERE id ='$id'");
$tampil = $sql->fetch_assoc();
$level = ($tampil['level'] == 'admin') ? "Admin" : "Peserta";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="body">
        <div class="alert alert-success alert-dismissable" role="alert" id="alert">
            <font style="font-size: 22px;"><b>Salam Pramuka ......</b> Selamat Datang <strong> <?=$tampil['nama'];?>,
                </strong> Anda login sebagai <strong><?=$level?></strong>
            </font>
        </div>
    </div>
    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">domain</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>TAMAN-TAMAN</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_taman?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>BARUNG PUTRA</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_peserta_pa?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>BARUNG PUTRI</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_peserta_pi?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">visibility</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h5><b>DEWAN JURI</b></h5>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_juri?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h4><b>USER</b></h4>
                    </div>
                    <div class="number count-to" data-from="0" data-to="<?=$jumlah_user?>" data-speed="1000"
                        data-fresh-interval="20"></div>
                    <!--  <div class="text">
                            <h5><?=$jumlah_user?> Pengguna</h5>
                        </div> -->
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">alarm</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h4><b>WAKTU KEGIATAN</b></h4>
                    </div>
                    <div class="text">
                        <h5><?php $hari=$data['waktu'];
                            echo format_hari_tanggal($hari) ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">account_balance</i>
                </div>
                <div class="content">
                    <div class="text">
                        <h4><b>TEMPAT KEGIATAN</b></h4>
                    </div>
                    <div class="text">
                        <h5><?=$data['tempat'];?></h5>
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
                    <canvas id="myChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>GRAFIK NILAI BARUNG PUTRI</h2>
                </div>
                <div class="body">
                    <canvas id="myChart2" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="../assets/plugins/jquery/jquery.js"></script>
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#alert').alert().delay(5000).slideUp('slow');
});
</script>