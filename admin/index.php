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
require_admin();

$page = $_GET['page'] ?? '';
$admin_titles = [
    '' => 'Dashboard Admin',
    'index' => 'Dashboard Admin',
    'taman' => 'Taman-taman',
    'juri' => 'Dewan Juri',
    'pesertapa' => 'Barung Putra',
    'pesertapi' => 'Barung Putri',
    'rekapawalputra' => 'Rekap Nilai Barung Putra',
    'rekapawalputri' => 'Rekap Nilai Barung Putri',
    'rekapakhirputra' => 'Barung Berprestasi Putra',
    'rekapakhirputri' => 'Barung Berprestasi Putri',
    'juaraumum' => 'Juara Umum',
    'backup' => 'Backup & Restore',
    'user' => 'Data User',
    'panitia' => 'Pengaturan'
];
$current_title = $admin_titles[$page] ?? 'Dashboard Admin';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= htmlspecialchars($current_title) ?> - Sistem Informasi Nilai</title>
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
    <link href="../assets/css/style.css?v=20260927" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="../assets/css/select2.min.css" rel="stylesheet" />
    <link href="../assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- <link href="../aasets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <script src="../assets/plugins/sweetalert/sweetalert.min.js"></script> -->
    <link href="../assets/css/sweetalert2.min.css?v=20260927-2" rel="stylesheet">
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
    @media (min-width: 768px) {
        .navbar .navbar-nav.navbar-right > li.navbar-date > a,
        .navbar .navbar-nav.navbar-right > li.dropdown > a.navbar-user {
            display: flex;
            align-items: center;
            height: 34px;
            padding-top: 0;
            padding-bottom: 0;
            color: #ffffff;
        }
        .navbar .navbar-nav.navbar-right > li.dropdown > a.navbar-user {
            gap: 10px;
        }
        .navbar .navbar-nav.navbar-right > li.dropdown > a.navbar-user:hover,
        .navbar .navbar-nav.navbar-right > li.dropdown > a.navbar-user:focus {
            color: #ffffff;
        }
        .navbar .navbar-nav.navbar-right > li.navbar-date > a {
            line-height: 34px;
            cursor: default;
        }
        .navbar .navbar-nav.navbar-right > li.navbar-date > a:hover,
        .navbar .navbar-nav.navbar-right > li.navbar-date > a:focus {
            color: #ffffff;
        }
        .navbar .navbar-nav.navbar-right .dropdown:hover > .dropdown-menu,
        .navbar .navbar-nav.navbar-right .dropdown-menu:hover {
            display: block;
        }
        .navbar .navbar-nav.navbar-right > li.dropdown > .dropdown-menu {
            top: 100% !important;
            right: 0;
            left: auto;
            margin-top: 8px !important;
        }
    }

    /* ===================================================
       GLOBAL STYLING: BADGE & PROGRESS BULAT (PILL SHAPE)
       =================================================== */
    .label,
    .badge,
    span.badge,
    span.label {
        border-radius: 999px !important;
        padding: 4px 12px !important;
        display: inline-block !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        line-height: 1.3 !important;
        vertical-align: middle !important;
        letter-spacing: 0.3px !important;
    }

    .progress {
        border-radius: 999px !important;
        overflow: hidden !important;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1) !important;
    }
    .progress .progress-bar {
        border-radius: 999px !important;
    }

    /* ===================================================
       ADMIN MOBILE APP VIEW (< 768px)
       =================================================== */
    .admin-mobile-app-header,
    .admin-mobile-bottom-nav {
        display: none;
    }

    @media (max-width: 767px) {
        body {
            background-color: #f4f6f9 !important;
            padding-top: 52px !important;
            padding-bottom: 64px !important;
        }

        .desktop-navbar-wrapper {
            display: none !important;
        }

        .navbar {
            height: 52px !important;
            min-height: 52px !important;
            padding: 0 12px !important;
            background: linear-gradient(135deg, #1b5e20, #2e7d32) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.18) !important;
            border: none !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1030 !important;
            margin: 0 !important;
        }
        .navbar > .container-fluid {
            padding: 0 !important;
            height: 100% !important;
        }

        .admin-mobile-app-header {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            height: 52px;
            width: 100%;
        }
        .admin-mobile-app-header .mob-header-btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            text-decoration: none !important;
            border-radius: 10px;
            background: rgba(255,255,255,0.12);
            border: none;
            outline: none;
            flex-shrink: 0;
            transition: background 0.15s ease;
        }
        .admin-mobile-app-header .mob-header-btn:active {
            background: rgba(255,255,255,0.25);
        }
        .admin-mobile-app-header .mob-header-btn i.material-icons {
            font-size: 22px;
            line-height: 1;
        }
        .admin-mobile-app-header .mob-header-title {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 10px;
            letter-spacing: 0.3px;
        }
        .admin-mobile-app-header .mob-header-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            text-decoration: none !important;
            flex: 1;
            min-width: 0;
        }
        .admin-mobile-app-header .mob-header-brand img {
            height: 30px;
            width: auto;
            flex-shrink: 0;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.25));
        }
        .admin-mobile-app-header .mob-brand-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .admin-mobile-app-header .mob-brand-title {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .admin-mobile-app-header .mob-brand-sub {
            font-size: 10px;
            color: rgba(255,255,255,0.85);
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Content Area Gutters */
        section.content {
            margin: 14px 0 72px 0 !important;
            padding: 0 16px !important;
            transition: none !important;
            box-sizing: border-box !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        section.content > .container-fluid,
        section.content .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        /* Netralkan negative margin dari .row Bootstrap */
        section.content .row,
        section.content .row.clearfix {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        section.content [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Mobile Bottom Navigation Bar */
        .admin-mobile-bottom-nav {
            display: flex !important;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 58px;
            background: #ffffff;
            border-top: 1px solid #e0e0e0;
            box-shadow: 0 -2px 14px rgba(0,0,0,0.08);
            z-index: 9999;
            align-items: center;
            justify-content: space-around;
            padding: 0 4px;
        }
        .admin-mobile-bottom-nav .bnav-btn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            color: #78909c;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 0;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: color 0.15s ease;
            outline: none;
        }
        .admin-mobile-bottom-nav .bnav-btn * {
            pointer-events: none;
        }
        .admin-mobile-bottom-nav .bnav-btn i.material-icons {
            font-size: 22px;
            margin-bottom: 2px;
            display: block;
            line-height: 1;
            transition: transform 0.15s ease;
        }
        .admin-mobile-bottom-nav .bnav-btn.active {
            color: #1b5e20 !important;
            font-weight: 700;
        }
        .admin-mobile-bottom-nav .bnav-btn.active i.material-icons {
            color: #1b5e20 !important;
            transform: scale(1.1);
        }
        .admin-mobile-bottom-nav .bnav-btn:active {
            background-color: rgba(27,94,32,0.06);
            border-radius: 10px;
        }

        /* Kartu & Container */
        .card {
            border-radius: 16px !important;
            border: 1px solid #edf2f7 !important;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04) !important;
            margin-bottom: 14px !important;
            overflow: hidden;
        }
        .card .header {
            padding: 14px 16px !important;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }
        .card .header h2 {
            font-size: 14px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .card .body {
            padding: 14px !important;
        }

        /* Breadcrumb Disembunyikan saat Mobile */
        .breadcrumb,
        ol.breadcrumb,
        .body > .breadcrumb {
            display: none !important;
        }

        /* Toolbar Aksi & Tombol */
        .card .body > .pull-right {
            float: none !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
            margin-bottom: 12px !important;
        }
        .card .body > br {
            display: none !important;
        }
        .card .body .btn {
            font-size: 12px !important;
            padding: 6px 12px !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
        }

        /* ========================================================
           TRANSFORMASI TABEL KE CARD VIEW DI MOBILE
           Tidak ada bentuk grid/tabel konvensional di HP
           ======================================================== */
        .table-responsive {
            border: none !important;
            overflow: visible !important;
            padding: 0 !important;
            margin: 0 0 8px 0 !important;
            background: transparent !important;
        }

        /* Sembunyikan Header Kolom Tabel */
        .table-responsive table thead,
        .table-responsive table.dataTable thead,
        .table thead {
            display: none !important;
        }

        /* Tabel dan Body menjadi block container vertikal */
        .table-responsive table,
        .table-responsive table.dataTable,
        .table-responsive table.table-bordered,
        .table-responsive table.table-striped,
        .table-responsive table.table-hover {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        .table-responsive table tbody,
        .table-responsive table.dataTable tbody {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        /* Tiap Baris (TR) Menjadi Kartu Mandiri */
        .table-responsive table tbody tr,
        .table-responsive table.dataTable tbody tr {
            display: block !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            padding: 12px 14px !important;
            margin-bottom: 12px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important;
            position: relative !important;
            box-sizing: border-box !important;
        }

        .table-responsive table tbody tr:hover,
        .table-responsive table.dataTable tbody tr:hover {
            background: #fafbfd !important;
        }

        /* Tiap Kolom (TD) Menjadi Baris Key-Value di dalam Kartu */
        .table-responsive table tbody tr td,
        .table-responsive table.dataTable tbody tr td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            text-align: right !important;
            padding: 7px 0 !important;
            border: none !important;
            border-bottom: 1px dashed #f1f5f9 !important;
            font-size: 13px !important;
            color: #1e293b !important;
            line-height: 1.4 !important;
            min-height: 30px !important;
            white-space: normal !important;
            word-break: break-word !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        /* Kolom terakhir (Aksi / Tombol) */
        .table-responsive table tbody tr td:last-child,
        .table-responsive table.dataTable tbody tr td:last-child {
            border-bottom: none !important;
            padding-top: 10px !important;
            padding-bottom: 2px !important;
            justify-content: flex-end !important;
            gap: 6px !important;
        }
        .table-responsive table tbody tr td:last-child::before,
        .table-responsive table.dataTable tbody tr td:last-child::before {
            display: none !important;
        }

        /* Kolom Pertama (No/Urut) */
        .table-responsive table tbody tr td:first-child {
            border-bottom: 1px solid #f1f5f9 !important;
            font-weight: 700 !important;
            color: #2e7d32 !important;
        }

        /* Label Otomatis dari Header Kolom via data-title */
        .table-responsive table tbody tr td::before,
        .table-responsive table.dataTable tbody tr td::before {
            content: attr(data-title);
            font-weight: 600;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
            margin-right: 12px;
            flex-shrink: 0;
            max-width: 48%;
        }

        .table-responsive table tbody tr td:not([data-title])::before,
        .table-responsive table tbody tr td[data-title=""]::before {
            display: none !important;
        }

        /* Tombol Aksi di dalam baris */
        .table-responsive table tbody tr td .btn,
        .table-responsive table.dataTable tbody tr td .btn {
            margin: 0 !important;
            padding: 5px 10px !important;
            font-size: 11px !important;
            border-radius: 6px !important;
            display: inline-flex;
            align-items: center !important;
            gap: 4px !important;
        }

        /* Penyesuaian khusus form input-nilai di kartu mobile */
        .table-responsive table tbody tr td .input-nilai {
            width: 75px !important;
            padding: 5px 6px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            text-align: right !important;
            border-radius: 6px !important;
            box-sizing: border-box !important;
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
        .table-responsive table tbody tr td .input-nilai:disabled {
            background: transparent !important;
            border: 1px dashed #cbd5e1 !important;
            color: #1e293b !important;
        }
        .table-responsive table tbody tr td .input-nilai:not(:disabled) {
            background: #ffffff !important;
            border: 1.5px solid #2e7d32 !important;
            box-shadow: 0 0 0 2px rgba(46,125,50,0.15) !important;
            color: #0f172a !important;
        }

        /* State jika tabel kosong */
        .table-responsive table tbody tr td.dataTables_empty,
        .table-responsive table.dataTable tbody tr td.dataTables_empty {
            display: block !important;
            text-align: center !important;
            padding: 24px 12px !important;
            color: #94a3b8 !important;
            font-style: italic !important;
            border: none !important;
        }
        .table-responsive table tbody tr td.dataTables_empty::before {
            display: none !important;
        }

        /* Hapus Pagination & Show Entries di Mobile */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate,
        .dataTables_wrapper .pagination,
        .pagination {
            display: none !important;
        }

        /* Modal Mobile: tanpa scroll internal, sudut konsisten */
        .modal {
            z-index: 100002 !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            padding-right: 0 !important;
        }
        .modal-backdrop {
            z-index: 100001 !important;
        }
        .modal .modal-dialog {
            width: auto !important;
            max-width: calc(100% - 24px) !important;
            margin: 16px auto 24px !important;
        }
        .modal .modal-content {
            display: block !important;
            max-height: none !important;
            height: auto !important;
            border: none !important;
            border-radius: 18px !important;
            overflow: hidden !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        }
        .modal .modal-content > form {
            display: block !important;
            overflow: visible !important;
        }
        .modal .modal-header {
            padding: 14px 18px !important;
            border-bottom: 1px solid #eef2f6 !important;
            border-radius: 0 !important;
        }
        .modal .modal-header .modal-title {
            font-size: 14px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
        }
        .modal .modal-header .close {
            margin-top: 0 !important;
            opacity: 0.45 !important;
            font-size: 22px !important;
            line-height: 1 !important;
        }
        .modal .modal-body {
            overflow: visible !important;
            max-height: none !important;
            padding: 14px 18px 6px !important;
        }
        .modal .modal-body .form-group {
            margin-bottom: 10px !important;
        }
        .modal .modal-body .form-line {
            padding-bottom: 4px !important;
        }
        .modal .modal-body .form-line label {
            font-size: 11px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.4px !important;
            color: #78909c !important;
            margin-bottom: 2px !important;
        }
        .modal .modal-body .form-control {
            font-size: 14px !important;
            padding: 6px 0 !important;
            border-radius: 0 !important;
        }
        .modal .modal-content > form > hr {
            display: none !important;
        }
        .modal .modal-footer {
            background: #ffffff !important;
            border-top: 1px solid #eef2f6 !important;
            padding: 12px 18px !important;
            text-align: right !important;
        }
        .modal .modal-footer .btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            margin: 0 0 0 8px !important;
            padding: 8px 18px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            border-radius: 999px !important;
            box-shadow: none !important;
        }

        /* Sidebar Drawer Mobile */
        aside#leftsidebar {
            z-index: 10001 !important;
            top: 0 !important;
            height: 100vh !important;
            box-shadow: 4px 0 24px rgba(0,0,0,0.25) !important;
        }
        body.overlay-open aside#leftsidebar,
        body.overlay-open .sidebar {
            margin-left: 0 !important;
            z-index: 100001 !important;
        }
        .overlay {
            z-index: 10000 !important;
        }
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
            <!-- Mobile App Header (< 768px) -->
            <div class="admin-mobile-app-header">
                <?php if (!empty($page) && $page !== 'index'): ?>
                    <a href="index.php" class="mob-header-btn" title="Kembali ke Dashboard">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <div class="mob-header-title"><?= htmlspecialchars($current_title) ?></div>
                    <a href="index.php" class="mob-header-btn" title="Dashboard">
                        <i class="material-icons">home</i>
                    </a>
                <?php else: ?>
                    <div class="mob-header-brand">
                        <img src="../assets/images/<?= $data['logo']; ?>" alt="Logo">
                        <div class="mob-brand-text">
                            <span class="mob-brand-title">Admin Pesta Siaga</span>
                            <span class="mob-brand-sub"><?= htmlspecialchars($data['nama_kegiatan'] ?? '') ?></span>
                        </div>
                    </div>
                    <a href="../auth/logout.php" class="js-logout mob-header-btn" title="Log Out">
                        <i class="material-icons">power_settings_new</i>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Topbar (>= 768px) -->
            <div class="desktop-navbar-wrapper">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/images/<?=$data['logo']; ?>" alt="Logo" style="height:24px; vertical-align:middle; margin-right:8px;">
                        <?= strtoupper('Sistem Informasi Nilai'); ?> | <?= isset($data['nama_kegiatan']) ? strtoupper(htmlspecialchars($data['nama_kegiatan'])) . ' ' . date('Y') : '' ?>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="navbar-date" style="white-space: nowrap;">
                            <a href="javascript:void(0);" class="navbar-date-link" style="pointer-events: none;">
                                <?php $date=date('Y-m-d'); echo format_hari_tanggal($date) ?><span id="clock"></span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle navbar-user" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="image">
                                    <?php
                                    $foto = isset($tampil['foto']) ? $tampil['foto'] : '';
                                    if (!empty($foto)) {
                                        echo '<img src="../assets/images/'.$foto.'" width="34" height="34" alt="User" style="object-fit:cover;border-radius:50%;box-shadow:0 0 0 2px rgba(255,255,255,0.8);">';
                                    } else {
                                        $initial = strtoupper(substr($tampil['nama'],0,1));
                                        echo '<span style="display:inline-flex;align-items:center;justify-content:center;height:34px;width:34px;border-radius:50%;background:rgba(255,255,255,0.85);color:#1b5e20;font-weight:bold;font-size:16px;box-shadow:0 0 0 2px rgba(255,255,255,0.8);">'.$initial.'</span>';
                                    }
                                    ?>
                                </span>
                                <span style="font-weight: 700; font-size: 14px; white-space: nowrap; max-width: 240px; overflow: hidden; text-overflow: ellipsis;">
                                    <?= htmlspecialchars($tampil['nama']); ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="../auth/logout.php" class="js-logout">
                                        <i class="material-icons">exit_to_app</i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header" id="dashboard">MENU UTAMA</li>
                    <?php $page_menu = @$_GET['page']; ?>
                    <li class="<?= (empty($page_menu) || $page_menu == 'index') ? 'active' : '' ?>">
                        <a href="index.php">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= ($page_menu == 'taman') ? 'active' : '' ?>">
                        <a href="?page=taman">
                            <i class="material-icons">domain</i>
                            <span>Taman - Taman</span>
                        </a>
                    </li>
                    <li class="<?= ($page_menu == 'juri') ? 'active' : '' ?>">
                        <a href="?page=juri">
                            <i class="material-icons">visibility</i>
                            <span>Dewan Juri</span>
                        </a>
                    </li>
                    <li class="<?= in_array($page_menu, ['pesertapa','pesertapi']) ? 'active' : '' ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Peserta</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?= ($page_menu == 'pesertapa') ? 'active' : '' ?>">
                                <a href="?page=pesertapa">Barung Putra</a>
                            </li>
                            <li class="<?= ($page_menu == 'pesertapi') ? 'active' : '' ?>">
                                <a href="?page=pesertapi">Barung Putri</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= in_array($page_menu, ['rekapawalputra','rekapawalputri']) ? 'active' : '' ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">list</i>
                            <span>Rekap Nilai</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?= ($page_menu == 'rekapawalputra') ? 'active' : '' ?>">
                                <a href="?page=rekapawalputra">Barung Putra</a>
                            </li>
                            <li class="<?= ($page_menu == 'rekapawalputri') ? 'active' : '' ?>">
                                <a href="?page=rekapawalputri">Barung Putri</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= in_array($page_menu, ['rekapakhirputra','rekapakhirputri']) ? 'active' : '' ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">thumb_up</i>
                            <span>Barung Berprestasi</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?= ($page_menu == 'rekapakhirputra') ? 'active' : '' ?>">
                                <a href="?page=rekapakhirputra">Barung Putra</a>
                            </li>
                            <li class="<?= ($page_menu == 'rekapakhirputri') ? 'active' : '' ?>">
                                <a href="?page=rekapakhirputri">Barung Putri</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= ($page_menu == 'juaraumum') ? 'active' : '' ?>">
                        <a href="?page=juaraumum">
                            <i class="material-icons">school</i>
                            <span>Juara Umum</span>
                        </a>
                    </li>
                    <li class="header" id="dashboard">PENGATURAN</li>
                    <li class="<?= ($page_menu == 'backup') ? 'active' : '' ?>">
                        <a href="?page=backup">
                            <i class="material-icons">backup</i>
                            <span>Backup Restore</span>
                        </a>
                    </li>
                    <li class="<?= ($page_menu == 'user') ? 'active' : '' ?>">
                        <a href="?page=user">
                            <i class="material-icons">person</i>
                            <span>User</span>
                        </a>
                    </li>
                    <li class="<?= ($page_menu == 'panitia') ? 'active' : '' ?>">
                        <a href="?page=panitia">
                            <i class="material-icons">settings</i>
                            <span>Setting</span>
                        </a>
                    </li>
                    <li>
                        <a href="../auth/logout.php" class="js-logout">
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
    <script src="../assets/js/xlsx.full.min.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script src="../assets/plugins/ckeditor/ckeditor.js"></script>
    <script>
        (function () {
            if (!window.CKEDITOR) return;
            ['ckeditor_beranda', 'ckeditor_tutup'].forEach(function (id) {
                if (document.getElementById(id) && !CKEDITOR.instances[id]) {
                    CKEDITOR.replace(id, {
                        toolbar: 'FullMessageToolbar',
                        height: 260,
                        allowedContent: true,
                        extraPlugins: 'justify'
                    });
                }
            });
        }());
    </script>
    <script src="../assets/js/select2.min.js"></script>
    <script src="../assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="../assets/js/pages/charts/chartjs.js?v=20260927"></script>
    <!-- Demo Js -->
    <script src="../assets/js/demo.js"></script>
    <script src="../assets/plugins/autosize/autosize.min.js"></script>
    <script src="../assets/js/pages/forms/basic-form-elements.js"></script>
    <!-- SweetAlert Plugin Js -->


    <script>
        $('.count-to').countTo();

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
        $(document).on('click', 'a.js-logout', function(e) {
            e.preventDefault();
            var href = this.getAttribute('href');
            if (!href) return;
            var targetUrl = href;
            try {
                targetUrl = new URL(href, window.location.href).href;
            } catch (err) {}
            if (window.Swal) {
                var fireResult = Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Yakin ingin keluar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, logout',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33'
                });
                if (fireResult && typeof fireResult.then === 'function') {
                    fireResult.then(function(result) {
                        var confirmed = !!(result && (result.isConfirmed || result.value));
                        if (confirmed) {
                            window.location.assign(targetUrl);
                        }
                    }
                    );
                    return;
                }
                return;
            }
            if (window.confirm('Yakin ingin keluar?')) {
                window.location.assign(targetUrl);
            }
        });
    </script>
    <script>
        var chartElement = document.getElementById('myChart');
        if (chartElement) {
        var ctx = chartElement.getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [<?php echo $nama_pangkalan; ?>],
                datasets: [{
                    label: '# NILAI BARUNG PUTRA',
                    data: [<?php echo $total_nilai; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
        }
    </script>
    <script>
        var chartElement2 = document.getElementById('myChart2');
        if (chartElement2) {
        var ctx = chartElement2.getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [<?=$nama_pangkalan1; ?>],
                datasets: [{
                    label: '# NILAI BARUNG PUTRI',
                    data: [<?=$total_nilai1; ?>],
                    backgroundColor: 'rgba(76, 175, 80, 0.5)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
        }
    </script>

    <!-- Mobile Bottom Navigation Bar (< 768px) -->
    <div class="admin-mobile-bottom-nav">
        <a href="index.php" class="bnav-btn <?= (empty($page) || $page === 'index') ? 'active' : '' ?>">
            <i class="material-icons">dashboard</i>
            <span>Dashboard</span>
        </a>
        <a href="?page=pesertapa" class="bnav-btn <?= in_array($page, ['pesertapa', 'pesertapi']) ? 'active' : '' ?>">
            <i class="material-icons">people</i>
            <span>Peserta</span>
        </a>
        <a href="?page=rekapawalputra" class="bnav-btn <?= in_array($page, ['rekapawalputra', 'rekapawalputri']) ? 'active' : '' ?>">
            <i class="material-icons">assessment</i>
            <span>Nilai</span>
        </a>
        <a href="?page=juaraumum" class="bnav-btn <?= in_array($page, ['rekapakhirputra', 'rekapakhirputri', 'juaraumum']) ? 'active' : '' ?>">
            <i class="material-icons">school</i>
            <span>Prestasi</span>
        </a>
        <button type="button" class="bnav-btn js-admin-mob-drawer-toggle">
            <i class="material-icons">menu</i>
            <span>Menu</span>
        </button>
    </div>

    <script>
        var mobDrawerBtn = document.querySelector('.js-admin-mob-drawer-toggle');
        if (mobDrawerBtn) {
            mobDrawerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.body.classList.toggle('overlay-open');
                if (document.body.classList.contains('overlay-open')) {
                    $('.overlay').fadeIn();
                } else {
                    $('.overlay').fadeOut();
                }
            });
        }

        // Setup otomatis label kolom untuk kartu baris di mobile (hilangkan tampilan tabel)
        function setupMobileTableCards() {
            var tables = document.querySelectorAll('.table-responsive table, table.dataTable');
            tables.forEach(function(table) {
                var ths = table.querySelectorAll('thead th');
                if (!ths || ths.length === 0) return;
                var headers = Array.from(ths).map(function(th) {
                    return th.innerText.replace(/[\n\r\t]+/g, ' ').trim();
                });
                var rows = table.querySelectorAll('tbody tr');
                rows.forEach(function(tr) {
                    var tds = tr.children;
                    for (var i = 0; i < tds.length; i++) {
                        if (headers[i] && !tds[i].classList.contains('dataTables_empty')) {
                            tds[i].setAttribute('data-title', headers[i]);
                        }
                    }
                });
            });
        }
        $(document).ready(function() {
            // Saat mobile (< 768px), set page length DataTable ke all (-1) agar semua data tampil
            if (window.innerWidth <= 767 && $.fn.DataTable) {
                $('.table-responsive table, table.dataTable').each(function() {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().page.len(-1).draw();
                    }
                });
            }
            setupMobileTableCards();
            $(document).on('draw.dt', function() {
                setupMobileTableCards();
            });
        });
    </script>
</body>

</html>

