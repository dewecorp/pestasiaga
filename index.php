<?php
include "config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT * FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$page = @$_GET['page'];
$status_home = $data_panitia['status_home'] ?? 'Buka';

$page_titles = [
    'taman' => 'Data Taman',
    'juri' => 'Dewan Juri',
    'peserta_pa' => 'Peserta Barung Putra',
    'peserta_pi' => 'Peserta Barung Putri',
    'nilai_pa' => 'Rekap Nilai Putra',
    'nilai_pi' => 'Rekap Nilai Putri',
    'prestasi_berprestasi' => 'Barung Berprestasi',
    'prestasi_juaraumum' => 'Klasemen Juara Umum',
    'denah' => 'Denah Lokasi'
];
$current_title = $page_titles[$page] ?? ($data_panitia['nama_kegiatan'] ?? 'Pesta Siaga');
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
        .navbar-default .navbar-brand img {
            filter: drop-shadow(0 0 2px #ffffff);
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
        /* Menu aktif: penanda khusus underline emas elegan */
        .navbar-default .navbar-nav > li > a {
            position: relative;
            transition: color 0.2s ease;
        }
        .navbar-default .navbar-nav > li.active > a,
        .navbar-default .navbar-nav > li.active > a:hover,
        .navbar-default .navbar-nav > li.active > a:focus {
            background-color: transparent !important;
            color: #ffeb3b !important;
            font-weight: 700;
        }
        .navbar-default .navbar-nav > li.active > a::after {
            content: '';
            position: absolute;
            bottom: 6px;
            left: 12px;
            right: 12px;
            height: 3px;
            background-color: #ffeb3b;
            border-radius: 999px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
        }
        @media (min-width: 768px) and (max-width: 1099px) {
            .navbar-default .navbar-nav > li.active > a::after {
                left: 5px;
                right: 5px;
                bottom: 8px;
            }
        }
        .navbar-default .navbar-nav .dropdown-menu > li.active > a,
        .navbar-default .navbar-nav .dropdown-menu > li.active > a:hover,
        .navbar-default .navbar-nav .dropdown-menu > li.active > a:focus {
            background-color: #fdf3ea !important;
            color: #5D4037 !important;
            font-weight: 700;
            border-left: 4px solid #ef6c00;
            padding-left: 16px;
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
        /* Badge/label bulat (predikat, peringkat) */
        .label,
        .badge {
            border-radius: 999px !important;
            padding: 3px 10px;
            display: inline-block;
            font-weight: 700;
            font-size: 11px;
            line-height: 1.4;
            vertical-align: middle;
        }
        footer {
            background-color: #5D4037;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }

        /* Desktop: konten melebar penuh (tanpa batas 1170px Bootstrap) */
        @media (min-width: 768px) {
            .container {
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 32px !important;
                padding-right: 32px !important;
            }
        }

        /* Tablet & laptop kecil: navbar tetap satu baris */
        @media (min-width: 768px) and (max-width: 1099px) {
            .navbar-brand {
                padding: 10px 8px;
                font-size: 11px;
                white-space: nowrap;
            }
            .navbar-default .navbar-brand img {
                height: 26px !important;
                margin-right: 6px !important;
                vertical-align: middle !important;
            }
            .navbar-nav > li > a {
                padding-left: 5px;
                padding-right: 5px;
                font-size: 12px;
            }
            .navbar-right {
                margin-right: 0 !important;
            }
            .navbar-nav .navbar-btn {
                margin-left: 3px !important;
                margin-top: 8px !important;
            }
        }

        /* =============================================
           RESPONSIVE MOBILE APPS MODE
           ============================================= */

        /* Default: sembunyikan semua elemen mobile di desktop */
        .mobile-app-header,
        .mobile-bottom-nav,
        .mob-sheet-overlay,
        .mob-sheet-content,
        .mobile-grid-home,
        .mobile-card-view,
        .mobile-home-greeting,
        .mobile-event-info,
        .mobile-welcome {
            display: none !important;
        }
        .desktop-navbar-header,
        .desktop-navbar-collapse,
        .desktop-table-view {
            display: block !important;
        }

        /* Mobile Viewport: lebar layar <= 767px */
        @media (max-width: 767px) {
            body {
                padding-top: 50px;
                padding-bottom: 75px !important;
            }
            .hero {
                padding: 70px 16px 40px !important;
                margin-bottom: 15px !important;
            }
            .hero h1 {
                font-size: 26px !important;
                margin-bottom: 6px !important;
            }
            .hero h2 {
                font-size: 14px !important;
                margin-bottom: 0 !important;
            }

            /* JARAK KANAN KIRI MOBILE (TIDAK MENEMPEL LAYAR) */
            .container,
            .content-section,
            .container.content-section,
            .mobile-card-view {
                padding-left: 18px !important;
                padding-right: 18px !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }
            .content-section {
                padding-top: 10px !important;
                padding-bottom: 10px !important;
                min-height: auto;
            }
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .row > [class*="col-"] {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .hero {
                padding: 65px 18px 45px !important;
                margin-bottom: 10px !important;
                border-radius: 0 0 24px 24px !important;
            }
            .hero h1 {
                font-size: 24px !important;
                margin-bottom: 6px !important;
            }
            .hero h2 {
                font-size: 14px !important;
                margin-bottom: 0 !important;
            }
            .card {
                border-radius: 18px !important;
                box-shadow: 0 4px 18px rgba(0,0,0,0.05) !important;
                margin-bottom: 18px !important;
                overflow: hidden;
            }
            .card .header {
                padding: 14px 18px !important;
                border-radius: 18px 18px 0 0 !important;
            }
            .card .header h2 {
                font-size: 15px !important;
                font-weight: 700;
            }
            .card .body {
                padding: 16px 18px !important;
            }
            /* Footer & pesan sambutan disembunyikan di mobile */
            footer {
                display: none !important;
            }

            /* Sembunyikan elemen desktop & hamburger di mobile */
            .navbar-toggle,
            .navbar-collapse,
            .desktop-navbar-header,
            .desktop-navbar-collapse,
            .desktop-table-view {
                display: none !important;
            }

            /* Header Mobile Bar */
            .mobile-app-header {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                height: 50px;
                padding: 0 2px;
            }
            .mob-header-btn {
                width: 38px;
                height: 38px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #ffffff !important;
                text-decoration: none !important;
                border-radius: 8px;
                background: transparent;
                border: none;
                outline: none;
                flex-shrink: 0;
            }
            .mob-header-btn:active {
                background: rgba(255,255,255,0.15);
            }
            .mob-header-btn i.material-icons {
                font-size: 22px;
                line-height: 1;
            }
            .mob-header-title {
                font-size: 16px;
                font-weight: 700;
                color: #ffffff;
                text-align: center;
                flex: 1;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                padding: 0 8px;
                letter-spacing: 0.3px;
            }
            .mob-header-brand {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #ffffff;
                text-decoration: none !important;
                font-size: 13px;
                font-weight: 700;
                flex: 1;
                overflow: hidden;
            }
            .mob-header-brand img {
                height: 26px;
                width: auto;
                flex-shrink: 0;
            }
            .mob-header-brand span {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Tampilkan elemen mobile di HP */
            .mobile-card-view {
                display: block !important;
            }
            .mobile-grid-home {
                display: block !important;
            }
            .mobile-home-greeting,
            .mobile-event-info {
                display: block !important;
            }
            .mobile-welcome {
                display: none !important;
            }
            .desktop-home-block {
                display: none !important;
            }

            /* Mobile Bottom Navigation Bar */
            .mobile-bottom-nav {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 58px;
                background: #ffffff;
                border-top: 1px solid #e0e0e0;
                box-shadow: 0 -2px 12px rgba(0,0,0,0.08);
                z-index: 9999;
                align-items: center;
                justify-content: space-around;
                padding: 0 4px;
            }
            .mobile-bottom-nav .bnav-btn {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none !important;
                color: #78909c;
                font-size: 10px;
                font-weight: 600;
                padding: 3px 0;
                border: none;
                background: transparent;
                cursor: pointer;
                transition: color 0.15s ease;
                outline: none;
            }
            .mobile-bottom-nav .bnav-btn i.material-icons {
                font-size: 22px;
                margin-bottom: 2px;
                display: block;
                line-height: 1;
            }
            .mobile-bottom-nav .bnav-btn.active {
                color: #5D4037 !important;
            }
            .mobile-bottom-nav .bnav-btn.active i.material-icons {
                color: #5D4037 !important;
            }

            /* Mobile Grid Menu (3 Kolom Flex) */
            .mobile-grid-menu {
                display: flex !important;
                flex-wrap: wrap !important;
                margin-left: -5px !important;
                margin-right: -5px !important;
                margin-bottom: 16px !important;
            }
            .mobile-grid-item {
                flex: 0 0 33.3333% !important;
                max-width: 33.3333% !important;
                padding: 5px !important;
                text-align: center;
                text-decoration: none !important;
                box-sizing: border-box;
            }
            .mobile-grid-box {
                background: #ffffff;
                border-radius: 16px;
                padding: 14px 6px 12px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.04);
                border: 1px solid #edf2f7;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: transform 0.15s ease;
            }
            .mobile-grid-item:active .mobile-grid-box {
                transform: scale(0.95);
            }
            .mobile-grid-icon {
                width: 44px !important;
                height: 44px !important;
                border-radius: 12px;
                display: flex !important;
                align-items: center;
                justify-content: center;
                margin: 0 auto 6px auto;
                color: #ffffff;
                box-shadow: 0 3px 8px rgba(0,0,0,0.12);
            }
            .mobile-grid-icon i.material-icons {
                font-size: 24px !important;
                line-height: 1;
            }
            .mobile-grid-label {
                font-size: 11px;
                font-weight: 600;
                color: #37474f;
                line-height: 1.2;
                display: block;
                margin-top: 2px;
            }

            /* Mobile Home Greeting & Info Cards (App Style) */
            .mob-greeting-card {
                background: #ffffff;
                border-radius: 18px;
                padding: 16px 16px 14px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.05);
                border: 1px solid #edf2f7;
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 12px;
            }
            .mob-greeting-avatar {
                width: 46px;
                height: 46px;
                border-radius: 14px;
                background: #fdf3ea;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                overflow: hidden;
            }
            .mob-greeting-avatar img {
                width: 32px;
                height: 32px;
                object-fit: contain;
            }
            .mob-greeting-text {
                flex: 1;
                min-width: 0;
            }
            .mob-greeting-title {
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 0.6px;
                text-transform: uppercase;
                color: #a1887f;
                margin-bottom: 2px;
            }
            .mob-greeting-name {
                font-size: 15px;
                font-weight: 800;
                color: #3e2723;
                line-height: 1.25;
            }

            .mob-info-card {
                background: #ffffff;
                border-radius: 18px;
                padding: 14px 16px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.05);
                border: 1px solid #edf2f7;
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 10px;
            }
            .mob-info-tile {
                width: 42px;
                height: 42px;
                border-radius: 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .mob-info-tile i.material-icons {
                font-size: 22px;
            }
            .mob-info-body {
                flex: 1;
                min-width: 0;
            }
            .mob-info-label {
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 0.7px;
                text-transform: uppercase;
                color: #90a4ae;
                margin-bottom: 2px;
            }
            .mob-info-value {
                font-size: 14px;
                font-weight: 700;
                color: #263238;
                line-height: 1.3;
                word-break: break-word;
            }
            .mob-info-chip {
                display: inline-flex;
                align-items: center;
                gap: 3px;
                background: #f1f5f9;
                color: #546e7a;
                border-radius: 999px;
                padding: 2px 9px;
                font-size: 11px;
                font-weight: 700;
                margin-top: 5px;
            }
            .mob-info-chip i.material-icons {
                font-size: 13px;
            }

            .mob-stat-grid {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -4px 4px;
            }
            .mob-stat-cell {
                flex: 0 0 50%;
                max-width: 50%;
                padding: 0 4px;
                box-sizing: border-box;
                margin-bottom: 8px;
            }
            .mob-stat-box {
                background: #ffffff;
                border-radius: 16px;
                border: 1px solid #edf2f7;
                box-shadow: 0 3px 12px rgba(0,0,0,0.04);
                padding: 12px 12px 10px;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .mob-stat-icon {
                width: 36px;
                height: 36px;
                border-radius: 11px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .mob-stat-icon i.material-icons {
                font-size: 19px;
            }
            .mob-stat-num {
                font-size: 19px;
                font-weight: 800;
                color: #263238;
                line-height: 1;
            }
            .mob-stat-name {
                font-size: 10px;
                font-weight: 700;
                color: #90a4ae;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                margin-top: 3px;
            }

            .mob-section-title {
                font-size: 11px;
                font-weight: 800;
                color: #8d6e63;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin: 16px 0 10px;
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .mob-section-title i.material-icons {
                font-size: 16px;
            }

            /* Mobile Card View Items */
            .mob-card-item {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.04);
                border: 1px solid #edf2f7;
                padding: 14px 16px;
                margin-bottom: 12px;
                position: relative;
            }
            .mob-card-header {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 8px;
                border-bottom: 1px solid #f1f5f9;
                padding-bottom: 6px;
            }
            .mob-card-badge {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: #5D4037;
                color: #ffffff;
                font-size: 12px;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .mob-card-title {
                font-size: 13px;
                font-weight: 700;
                color: #263238;
                flex: 1;
                line-height: 1.3;
            }
            .mob-card-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                font-size: 12px;
                margin-top: 4px;
            }
            .mob-card-row .label-text {
                color: #78909c;
                font-weight: 600;
                min-width: 80px;
            }
            .mob-card-row .value-text {
                color: #37474f;
                font-weight: 600;
                text-align: right;
                flex: 1;
            }
            .mob-chips-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 5px;
                margin-top: 8px;
            }
            .mob-chip {
                background: #f8fafc;
                border-radius: 6px;
                padding: 5px 7px;
                border: 1px solid #edf2f7;
            }
            .mob-chip .chip-name {
                font-size: 9px;
                color: #78909c;
                text-transform: uppercase;
                letter-spacing: 0.3px;
                margin-bottom: 2px;
            }
            .mob-chip .chip-val {
                font-size: 12px;
                font-weight: 700;
                color: #263238;
            }
            .mob-final-score {
                background: linear-gradient(135deg, #5D4037 0%, #8D6E63 100%);
                color: #ffffff;
                border-radius: 8px;
                padding: 8px 12px;
                margin-top: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .mob-final-score .score-title {
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .mob-final-score .score-val {
                font-size: 18px;
                font-weight: 800;
            }

            /* Sheet Modal for Mobile Menu */
            .mob-sheet-overlay {
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5);
                backdrop-filter: blur(2px);
                z-index: 10000;
            }
            .mob-sheet-content {
                position: fixed;
                bottom: 0; left: 0; right: 0;
                background: #ffffff;
                border-radius: 18px 18px 0 0;
                padding: 16px 14px 25px;
                z-index: 10001;
                max-height: 80vh;
                overflow-y: auto;
                box-shadow: 0 -6px 25px rgba(0,0,0,0.18);
            }
            .mob-sheet-overlay.open {
                display: block !important;
            }
            .mob-sheet-content.open {
                display: block !important;
                animation: slideUpSheet 0.2s ease-out;
            }
            @keyframes slideUpSheet {
                from { transform: translateY(100%); }
                to { transform: translateY(0); }
            }
            .mob-sheet-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
                padding-bottom: 8px;
                border-bottom: 1px solid #f1f5f9;
            }
            .mob-sheet-title {
                font-size: 14px;
                font-weight: 700;
                color: #263238;
            }
            .mob-sheet-close {
                border: none;
                background: #f1f5f9;
                width: 28px;
                height: 28px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #555;
            }
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top bg-dark-brown" style="border:none;">
        <div class="container">
            <!-- Mobile App Header (Hanya tampil di mode mobile < 768px) -->
            <div class="mobile-app-header">
                <?php if (!empty($page)): ?>
                    <a href="./" class="mob-header-btn" title="Kembali ke Beranda">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <div class="mob-header-title"><?= htmlspecialchars($current_title) ?></div>
                    <a href="./" class="mob-header-btn" title="Beranda">
                        <i class="material-icons">home</i>
                    </a>
                <?php else: ?>
                    <div class="mob-header-brand">
                        <img src="assets/images/<?= $data_panitia['logo'] ?>" alt="Logo">
                        <span><?= htmlspecialchars($data_panitia['nama_kegiatan'] ?? '') ?></span>
                    </div>
                    <a href="auth/login.php" target="_blank" class="mob-header-btn" title="Login Admin">
                        <i class="material-icons" style="font-size:20px; color:#d7ccc8;">settings</i>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Navbar (Hanya tampil di mode desktop >= 768px) -->
            <div class="navbar-header desktop-navbar-header">
                <a class="navbar-brand" href="./">
                    <img src="assets/images/<?= $data_panitia['logo'] ?>" alt="Logo" style="height: 30px; display: inline-block; margin-right: 10px; vertical-align: top;">
                    <span class="brand-text"><?= $data_panitia['nama_kegiatan'] ?> <?= date('Y') ?></span>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse desktop-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?= empty($page) ? 'active' : '' ?>"><a href="./">Beranda</a></li>
                    <?php if (($data_panitia['status_home'] ?? 'Buka') == 'Buka') { ?>
                    <li class="<?= $page === 'taman' ? 'active' : '' ?>"><a href="?page=taman">Taman</a></li>
                    <li class="<?= $page === 'juri' ? 'active' : '' ?>"><a href="?page=juri">Juri</a></li>
                    <li class="dropdown <?= in_array($page, ['peserta_pa', 'peserta_pi']) ? 'active' : '' ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Peserta <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="<?= $page === 'peserta_pa' ? 'active' : '' ?>"><a href="?page=peserta_pa">Putra</a></li>
                            <li class="<?= $page === 'peserta_pi' ? 'active' : '' ?>"><a href="?page=peserta_pi">Putri</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?= in_array($page, ['nilai_pa', 'nilai_pi']) ? 'active' : '' ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nilai <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="<?= $page === 'nilai_pa' ? 'active' : '' ?>"><a href="?page=nilai_pa">Rekap Nilai Putra</a></li>
                            <li class="<?= $page === 'nilai_pi' ? 'active' : '' ?>"><a href="?page=nilai_pi">Rekap Nilai Putri</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?= in_array($page, ['prestasi_berprestasi', 'prestasi_juaraumum']) ? 'active' : '' ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestasi <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="<?= $page === 'prestasi_berprestasi' ? 'active' : '' ?>"><a href="?page=prestasi_berprestasi">Barung Berprestasi</a></li>
                            <li class="<?= $page === 'prestasi_juaraumum' ? 'active' : '' ?>"><a href="?page=prestasi_juaraumum">Juara Umum</a></li>
                        </ul>
                    </li>
                    <li class="<?= $page === 'denah' ? 'active' : '' ?>"><a href="?page=denah">Denah Lokasi</a></li>
                    <?php } ?>
                    <li>
                        <a href="auth/login.php" target="_blank" title="Login Admin" aria-label="Login Admin" class="navbar-btn" style="display:inline-flex;align-items:center;justify-content:center;margin-left:10px;margin-top:10px;width:34px;height:34px;border:none;background:transparent;padding:0;box-shadow:none;text-decoration:none;">
                            <i class="material-icons" style="font-size: 20px; line-height: 1; vertical-align: middle; color: #8D6E63;">settings</i>
                        </a>
                    </li>
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

    <?php if (($status_home ?? 'Buka') == 'Buka'): ?>
    <!-- Mobile Bottom Navigation Bar -->
    <div class="mobile-bottom-nav">
        <a href="./" class="bnav-btn <?= empty($page) ? 'active' : '' ?>">
            <i class="material-icons">home</i>
            <span>Beranda</span>
        </a>
        <a href="?page=peserta_pa" class="bnav-btn <?= in_array($page, ['peserta_pa', 'peserta_pi']) ? 'active' : '' ?>">
            <i class="material-icons">people</i>
            <span>Peserta</span>
        </a>
        <a href="?page=nilai_pa" class="bnav-btn <?= in_array($page, ['nilai_pa', 'nilai_pi']) ? 'active' : '' ?>">
            <i class="material-icons">assessment</i>
            <span>Nilai</span>
        </a>
        <a href="?page=prestasi_juaraumum" class="bnav-btn <?= in_array($page, ['prestasi_berprestasi', 'prestasi_juaraumum']) ? 'active' : '' ?>">
            <i class="material-icons">emoji_events</i>
            <span>Prestasi</span>
        </a>
        <button type="button" class="bnav-btn <?= in_array($page, ['taman', 'juri', 'denah']) ? 'active' : '' ?>" id="btnOpenMobileMenu" onclick="openMobSheet()">
            <i class="material-icons">apps</i>
            <span>Menu</span>
        </button>
    </div>

    <!-- Mobile Menu Bottom Sheet -->
    <div class="mob-sheet-overlay" id="mobSheetOverlay" onclick="closeMobSheet()"></div>
    <div class="mob-sheet-content" id="mobSheetContent">
        <div class="mob-sheet-header">
            <div class="mob-sheet-title">Semua Menu Kegiatan</div>
            <button type="button" class="mob-sheet-close" onclick="closeMobSheet()"><i class="material-icons" style="font-size:18px;">close</i></button>
        </div>
        <div class="mobile-grid-menu" style="margin-bottom:0;">
            <a href="?page=taman" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="material-icons">domain</i>
                    </div>
                    <span class="mobile-grid-label">Taman</span>
                </div>
            </a>
            <a href="?page=juri" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="material-icons">gavel</i>
                    </div>
                    <span class="mobile-grid-label">Dewan Juri</span>
                </div>
            </a>
            <a href="?page=peserta_pa" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                        <i class="material-icons">directions_run</i>
                    </div>
                    <span class="mobile-grid-label">Peserta PA</span>
                </div>
            </a>
            <a href="?page=peserta_pi" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #ec4899, #db2777);">
                        <i class="material-icons">local_florist</i>
                    </div>
                    <span class="mobile-grid-label">Peserta PI</span>
                </div>
            </a>
            <a href="?page=nilai_pa" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                        <i class="material-icons">bar_chart</i>
                    </div>
                    <span class="mobile-grid-label">Nilai PA</span>
                </div>
            </a>
            <a href="?page=nilai_pi" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        <i class="material-icons">analytics</i>
                    </div>
                    <span class="mobile-grid-label">Nilai PI</span>
                </div>
            </a>
            <a href="?page=prestasi_berprestasi" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                        <i class="material-icons">military_tech</i>
                    </div>
                    <span class="mobile-grid-label">Berprestasi</span>
                </div>
            </a>
            <a href="?page=prestasi_juaraumum" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #eab308, #ca8a04);">
                        <i class="material-icons">emoji_events</i>
                    </div>
                    <span class="mobile-grid-label">Juara Umum</span>
                </div>
            </a>
            <a href="?page=denah" class="mobile-grid-item" onclick="closeMobSheet()">
                <div class="mobile-grid-box">
                    <div class="mobile-grid-icon" style="background: linear-gradient(135deg, #14b8a6, #0d9488);">
                        <i class="material-icons">map</i>
                    </div>
                    <span class="mobile-grid-label">Denah</span>
                </div>
            </a>
        </div>
        <div style="margin-top:14px; text-align:center;">
            <a href="auth/login.php" target="_blank" class="btn btn-default btn-block" style="border-radius:10px; font-weight:600; color:#5D4037;">
                <i class="material-icons" style="font-size:16px; vertical-align:middle; margin-right:4px;">settings</i> Login Admin Panitia
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script>
        function openMobSheet() {
            var overlay = document.getElementById('mobSheetOverlay');
            var sheet = document.getElementById('mobSheetContent');
            if (overlay && sheet) {
                overlay.classList.add('open');
                sheet.classList.add('open');
            }
        }
        function closeMobSheet() {
            var overlay = document.getElementById('mobSheetOverlay');
            var sheet = document.getElementById('mobSheetContent');
            if (overlay && sheet) {
                overlay.classList.remove('open');
                sheet.classList.remove('open');
            }
        }

        // Samakan padding atas body dengan tinggi navbar aktual (tablet bisa 2 baris)
        (function () {
            function syncNavbarOffset() {
                var nav = document.querySelector('.navbar-fixed-top');
                if (!nav) return;
                var h = Math.round(nav.offsetHeight);
                if (window.innerWidth < 768) {
                    document.body.style.paddingTop = '50px';
                } else {
                    document.body.style.paddingTop = (h > 0 ? h : 50) + 'px';
                }
            }
            syncNavbarOffset();
            window.addEventListener('load', syncNavbarOffset);
            window.addEventListener('resize', syncNavbarOffset);
        })();
    </script>
</body>
</html>
