<?php
include "config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT * FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $data_panitia['nama_kegiatan'] ?></title>
    <link rel="icon" href="assets/images/<?= $data_panitia['logo'] ?>" type="image/x-icon">
    <!-- Bootstrap Core Css -->
    <link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="assets/css/material-google-font.css" rel="stylesheet" type="text/css">
    <link href="assets/css/roboto-google-font.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            padding-top: 50px; /* Adjust for fixed navbar */
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
        }
        .bg-dark-brown {
            background-color: #5D4037 !important;
            border-color: #4E342E !important;
            color: white !important;
        }
        .bg-light-brown {
            background-color: #8D6E63 !important;
            color: white !important;
        }
        .bg-purple {
            background-color: #7B1FA2 !important;
            color: white !important;
        }
        .bg-red {
            background-color: #F44336 !important;
            color: white !important;
        }
        .navbar-default .navbar-brand {
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        .navbar-default .navbar-nav > li > a {
            color: white;
        }
        .navbar-default .navbar-nav > li > a:hover,
        .navbar-default .navbar-nav > li > a:focus {
            color: #ffeb3b;
            background-color: transparent;
        }
        .navbar-default .navbar-nav > .open > a, 
        .navbar-default .navbar-nav > .open > a:hover, 
        .navbar-default .navbar-nav > .open > a:focus {
            background-color: #4E342E;
            color: white;
        }
        @media (max-width: 767px) {
            .navbar-default .navbar-nav .open .dropdown-menu > li > a {
                color: white !important;
            }
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                color: #ffeb3b !important;
            }
        }
        .hero {
            text-align: center;
            padding: 250px 0;
            margin-bottom: 30px;
        }
        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 4em;
            font-weight: 700;
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
        .hero h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5em;
            font-weight: 600;
            margin-bottom: 30px;
            margin-top: 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
            text-transform: uppercase;
        }
        .hero p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.6em;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            line-height: 1.5;
        }
        .lead-message {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5em;
            text-align: center;
            line-height: 1.6;
            font-weight: 500;
            color: #333;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .content-section {
            padding: 20px 0;
            min-height: 400px;
        }
        .card {
            background: #fff;
            min-height: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-bottom: 30px;
            border-radius: 10px;
            border: 1px solid #eee;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }
        .card .header {
            color: #555;
            padding: 25px;
            position: relative;
            border-bottom: 1px solid rgba(204, 204, 204, 0.35);
            border-radius: 10px 10px 0 0;
        }
        .card .header.bg-purple, 
        .card .header.bg-dark-brown, 
        .card .header.bg-light-brown,
        .card .header.bg-red {
            color: #fff !important;
        }
        .card .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: normal;
            color: inherit; /* Inherit color from header */
        }
        .card .body {
            padding: 20px;
        }
        footer {
            background-color: #5D4037;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top bg-dark-brown">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="assets/images/<?= $data_panitia['logo'] ?>" alt="Logo" style="height: 30px; display: inline-block; margin-right: 10px; vertical-align: top;">
                    <?= $data_panitia['nama_kegiatan'] ?> <?= date('Y') ?>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Beranda</a></li>
                    <?php if (($data_panitia['status_home'] ?? 'Buka') == 'Buka') { ?>
                    <li><a href="?page=taman">Taman</a></li>
                    <li><a href="?page=juri">Juri</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Peserta <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=peserta_pa">Putra</a></li>
                            <li><a href="?page=peserta_pi">Putri</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nilai <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=nilai_pa">Rekap Nilai Putra</a></li>
                            <li><a href="?page=nilai_pi">Rekap Nilai Putri</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestasi <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=prestasi_berprestasi">Barung Berprestasi</a></li>
                            <li><a href="?page=prestasi_juaraumum">Juara Umum</a></li>
                        </ul>
                    </li>
                    <li><a href="?page=denah">Denah Lokasi</a></li>
                    <?php } ?>
                    <li><a href="auth/login.php" target="_blank" class="btn btn-warning navbar-btn" style="color: #5D4037 !important; font-weight: bold; margin-left: 10px;">Login Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?php
    $page = @$_GET['page'];
    $status_home = $data_panitia['status_home'] ?? 'Buka';

    // Add spacing for non-home pages
    $is_home = (empty($page) || ($status_home == 'Tutup' && !empty($page)));
    if (!$is_home) {
        echo '<div style="margin-top: 30px;"></div>';
    }

    if ($status_home == 'Tutup' && !empty($page)) {
        // Redirect to home if accessed directly while closed
        include "public_page/home.php";
    } elseif (empty($page)) {
        include "public_page/home.php";
    } elseif ($page == 'taman') {
        include "public_page/taman.php";
    } elseif ($page == 'juri') {
        include "public_page/juri.php";
    } elseif ($page == 'peserta_pa') {
        include "public_page/peserta_pa.php";
    } elseif ($page == 'peserta_pi') {
        include "public_page/peserta_pi.php";
    } elseif ($page == 'nilai_pa') {
        include "public_page/nilai_pa.php";
    } elseif ($page == 'nilai_pi') {
        include "public_page/nilai_pi.php";
    } elseif ($page == 'prestasi_berprestasi') {
        include "public_page/prestasi_berprestasi.php";
    } elseif ($page == 'prestasi_juaraumum') {
        include "public_page/prestasi_juaraumum.php";
    } elseif ($page == 'denah') {
        include "public_page/denah.php";
    } else {
        include "public_page/home.php";
    }
    ?>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= $data_panitia['nama_kegiatan'] ?>. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>
</body>
</html>