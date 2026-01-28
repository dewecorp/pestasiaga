<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
setlocale(LC_ALL, 'id-ID', 'id_ID');
include "../config/fungsi_hari.php";
include "../config/koneksi.php";
$id = $_GET['id'];
//Inisialisasi nilai variabel awal
$nama_pangkalan= "";
$total_nilai=null;
$nama_pangkalan1= "";
$total_nilai1=null;
//Query SQL untuk Barung Putra (Join Peserta & Rekap)
$nama_pangkalan = "";
$total_nilai = "";
$sql = $koneksi->query("SELECT p.pangkalan, r.nilai_akhir_pa
                        FROM tb_peserta_pa p
                        LEFT JOIN tb_rekap r ON p.id_pa = r.id_pa
                        ORDER BY CAST(r.nilai_akhir_pa AS UNSIGNED) DESC");
while ($data = $sql->fetch_assoc()) {
    $nama = $data['pangkalan'];
    $nilai = isset($data['nilai_akhir_pa']) ? $data['nilai_akhir_pa'] : 0;
    $nama_pangkalan .= "'$nama', ";
    $total_nilai .= "'$nilai', ";
}
// Hapus koma terakhir
$nama_pangkalan = rtrim($nama_pangkalan, ", ");
$total_nilai = rtrim($total_nilai, ", ");

//Query SQL untuk Barung Putri (Join Peserta & Rekap)
$nama_pangkalan1 = "";
$total_nilai1 = "";
$sql1 = $koneksi->query("SELECT p.pangkalan, r.nilai_akhir_pi 
                         FROM tb_peserta_pi p 
                         LEFT JOIN tb_rekap_pi r ON p.id_pi = r.id_pi 
                         ORDER BY CAST(r.nilai_akhir_pi AS DECIMAL(10,2)) DESC");
while ($data = $sql1->fetch_assoc()) {
    $nama = $data['pangkalan'];
    $nilai = isset($data['nilai_akhir_pi']) ? $data['nilai_akhir_pi'] : 0;
    $nama_pangkalan1 .= "'$nama', ";
    $total_nilai1 .= "'$nilai', ";
}
// Hapus koma terakhir
$nama_pangkalan1 = rtrim($nama_pangkalan1, ", ");
$total_nilai1 = rtrim($total_nilai1, ", ");
$id = @$_SESSION['id_user'];
$sql = $koneksi->query("SELECT * FROM tb_user WHERE id ='$id'");
$tampil = $sql->fetch_assoc();
$sql_logo = $koneksi->query("SELECT * FROM tb_panitia");
$data = $sql_logo->fetch_assoc();
if (isset($_SESSION['level']) == "") {
header("location:../login.php");
} else {
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>
        <?php
		$page = @$_GET['page'];
		if(!empty($page)){
		if ($page == 'index') {
		echo "Dashboard Admin";
		} elseif($page == 'taman') {
		echo "Taman-taman";
		} elseif($page == 'juri') {
		echo "Dewan Juri";
		} elseif($page == 'pesertapa') {
		echo "Barung Putra";
		} elseif($page == 'pesertapi') {
		echo "Barung Putri";
		} elseif($page == 'rekapawalputra') {
		echo "Rekap Nilai Barung Putra";
		} elseif($page == 'rekapawalputri') {
		echo "Rekap Nilai Barung Putri";
		} elseif($page == 'rekapakhirputra') {
		echo "Barung Berprestasi Putra";
		} elseif($page == 'rekapakhirputri') {
		echo "Barung Berprestasi Putri";
		} elseif($page == 'juaraumum') {
		echo "Juara Umum";
		} elseif($page == 'user') {
		echo "Data User";
		} elseif($page == 'panitia') {
		echo "Pengaturan";
		}
		} else {
		echo "Dashboard Admin";
		}
		?>
    </title>
    <!-- Favicon-->
    <link rel="icon" href="../assets/images/tunas.png" type="image/x-icon">
    <link href="../assets/css/material-google-font.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/roboto-google-font.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="../assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="../assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="../assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="../assets/css/select2.min.css" rel="stylesheet" />
    <link href="../assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- <link href="../aasets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <script src="../assets/plugins/sweetalert/sweetalert.min.js"></script> -->
    <link href="../assets/css/sweetalert2.min.css" rel="stylesheet">
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/sweetalert2@10.js"></script>

</head>
<style media="screen">
    .sidebar .user-info {
        padding: 13px 15px 12px 15px;
        white-space: nowrap;
        position: relative;
        border-bottom: 1px solid #e9e9e9;
        background: linear-gradient(45deg, #1b5e20, #4caf50);
        height: 135px;
    }
    .navbar .navbar-brand {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        font-size: 16px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 75vw;
    }
    .navbar .navbar-brand img {
        height: 36px;
        width: auto;
        display: inline-block;
        filter: drop-shadow(0 0 1px #ffffff) drop-shadow(0 0 3px #ffffff);
    }

</style>

<body class="theme-green">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Mohon Tunggu ...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/images/<?=$data['logo']; ?>" alt="Logo" style="height:24px; vertical-align:middle; margin-right:8px;">
                    <?= strtoupper('Sistem Informasi Nilai'); ?> | <?= isset($data['nama_kegiatan']) ? strtoupper($data['nama_kegiatan']) : '' ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div class="nav navbar-nav navbar-right" style="padding: 10px;">
                    <div class="pull-right navbar-brand"><?php $date=date('Y-m-d');
							echo format_hari_tanggal($date)?><span id="clock"></span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info" align="center">
                <div class="image">
                    <?php
                    $foto = isset($tampil['foto']) ? $tampil['foto'] : '';
                    if (!empty($foto)) {
                        echo '<img src="../assets/images/'.$foto.'" width="70" height="70" alt="User" style="object-fit:cover;border-radius:50%;box-shadow:0 0 0 2px #ffffff;">';
                    } else {
                        $initial = strtoupper(substr($tampil['nama'],0,1));
                        echo '<span style="display:inline-flex;align-items:center;justify-content:center;height:70px;width:70px;border-radius:50%;background:#e0e0e0;color:#333;font-weight:bold;font-size:28px;box-shadow:0 0 0 2px #ffffff;">'.$initial.'</span>';
                    }
                    ?>
                </div>
                <div class="info-container">
                    <div class="name" style="color: #000000; font-weight: bold; font-size: 18px; ">
                        <?=$tampil['nama']; ?>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header" id="dashboard">MENU UTAMA</li>
                    <li class="active">
                        <a href="index.php">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=taman">
                            <i class="material-icons">domain</i>
                            <span>Taman - Taman</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=juri">
                            <i class="material-icons">visibility</i>
                            <span>Dewan Juri</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Peserta</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="?page=pesertapa">Barung Putra</a>
                            </li>
                            <li>
                                <a href="?page=pesertapi">Barung Putri</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">list</i>
                            <span>Rekap Nilai</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="?page=rekapawalputra">Barung Putra</a>
                            </li>
                            <li>
                                <a href="?page=rekapawalputri">Barung Putri</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">thumb_up</i>
                            <span>Barung Berprestasi</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="?page=rekapakhirputra">Barung Putra</a>
                            </li>
                            <li>
                                <a href="?page=rekapakhirputri">Barung Putri</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?page=juaraumum">
                            <i class="material-icons">school</i>
                            <span>Juara Umum</span>
                        </a>
                    </li>
                    <li class="header" id="dashboard">PENGATURAN</li>
                    <li>
                        <a href="?page=backup">
                            <i class="material-icons">backup</i>
                            <span>Backup Restore</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=user">
                            <i class="material-icons">person</i>
                            <span>User</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=panitia">
                            <i class="material-icons">settings</i>
                            <span>Setting</span>
                        </a>
                    </li>
                    <li>
                        <a href="../auth/login.php">
                            <i class="material-icons">exit_to_app</i>
                            <span>Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?=date('Y')?> <a href="javascript:void(0);">Sistem Informasi Nilai</a>
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
        </aside>
        <!-- #Footer -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="body">
                    <?php
							$page = @$_GET['page'];
							$aksi = @$_GET['aksi'];
							if ($page == "juri") {
							if ($aksi == "") {
							include "page/juri/juri.php";
							} elseif ($aksi == "tambah") {
							include "page/juri/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/juri/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/juri/hapus.php";
							}
							} elseif ($page == "backup") {
							include "page/backup/backup.php";
							} elseif ($page == "pesertapa") {
							if ($aksi == "") {
							include "page/pesertapa/peserta_putra.php";
							} elseif ($aksi == "tambah") {
							include "page/pesertapa/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/pesertapa/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/pesertapa/hapus.php";
							}
							} elseif ($page == "pesertapi") {
							if ($aksi == "") {
							include "page/pesertapi/peserta_putri.php";
							} elseif ($aksi == "tambah") {
							include "page/pesertapi/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/pesertapi/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/pesertapi/hapus.php";
							}
							} elseif ($page == "taman") {
							if ($aksi == "") {
							include "page/taman/taman.php";
							} elseif ($aksi == "tambah") {
							include "page/taman/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/taman/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/taman/hapus.php";
							}
							} elseif ($page == "rekapawalputra") {
							if ($aksi == "") {
							include "page/rekapawalputra/rekap_awal_putra.php";
							} elseif ($aksi == "input") {
							include "page/rekapawalputra/input_nilai.php";
							} elseif ($aksi == "kembali") {
							include "page/rekapawalputra/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/rekapawalputra/hapus.php";
							}
							} elseif ($page == "rekapawalputri") {
							if ($aksi == "") {
							include "page/rekapawalputri/rekap_awal_putri.php";
							} elseif ($aksi == "input") {
							include "page/rekapawalputri/input_nilai.php";
							} elseif ($aksi == "kembali") {
							include "page/rekapawalputri/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/rekapawalputri/hapus.php";
							}
							} elseif ($page == "rekapakhirputra") {
							if ($aksi == "") {
							include "page/rekapakhirputra/rekap_akhir_putra.php";
							} elseif ($aksi == "tambah") {
							include "page/rekapakhirputra/tambah.php";
							} elseif ($aksi == "kembali") {
							include "page/rekapakhirputra/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/rekapakhirputra/hapus.php";
							}
							} elseif ($page == "rekapakhirputri") {
							if ($aksi == "") {
							include "page/rekapakhirputri/rekap_akhir_putri.php";
							} elseif ($aksi == "tambah") {
							include "page/rekapakhirputri/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/rekapakhirputri/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/rekapakhirputri/hapus.php";
							}
							} elseif ($page == "juaraumum") {
							if ($aksi == "") {
							include "page/juaraumum/juaraumum.php";
							} elseif ($aksi == "tambah") {
							include "page/juaraumum/tambah.php";
							} elseif ($aksi == "tambah") {
							include "page/juaraumum/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/juaraumum/hapus.php";
							}
							} elseif ($page == "panitia") {
							if ($aksi == "") {
							include "page/panitia/panitia.php";
							} elseif ($aksi == "tambah") {
							include "page/panitia/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/panitia/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/panitia/hapus.php";
							}
							} elseif ($page == "user") {
							if ($aksi == "") {
							include "page/user/user.php";
							} elseif ($aksi == "tambah") {
							include "page/user/tambah.php";
							} elseif ($aksi == "edit") {
							include "page/user/edit.php";
							} elseif ($aksi == "hapus") {
							include "page/user/hapus.php";
							}
							} elseif ($page == "") {
							include "page/dashboard/index.php";
							} ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Jquery Core Js -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="../assets/plugins/node-waves/waves.js"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="../assets/plugins/jquery-countto/jquery.countTo.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="../assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <!-- Chart Plugins Js -->
    <script src="../assets/plugins/chartjs/Chart.bundle.js"></script>
    <script src="../assets/plugins/chartjs/Chart.min.js"></script>
    <!-- Custom Js -->
    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/select2.min.js"></script>
    <script src="../assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="../assets/js/pages/charts/chartjs.js"></script>
    <!-- Demo Js -->
    <script src="../assets/js/demo.js"></script>
    <script src="../assets/js/pages/forms/basic-form-elements.js"></script>
    <!-- SweetAlert Plugin Js -->


    <script>
        $('.count-to').countTo();
        $("#dashboard").addClass('active');

    </script>
    <script>
        function updateClock() {
            var now = new Date();
            var h = now.getHours().toString().padStart(2,'0');
            var m = now.getMinutes().toString().padStart(2,'0');
            var s = now.getSeconds().toString().padStart(2,'0');
            var el = document.getElementById('clock');
            if (el) { el.textContent = ' | ' + h + ':' + m + ':' + s; }
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [<?php echo $nama_pangkalan; ?>],
                datasets: [{
                    label: '# NILAI BARUNG PUTRA',
                    data: [<?php echo $total_nilai; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>
    <script>
        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [<?=$nama_pangkalan1; ?>],
                datasets: [{
                    label: '# NILAI BARUNG PUTRI',
                    data: [<?=$total_nilai1; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>
</body>

</html>
<?php
	}
	?>
