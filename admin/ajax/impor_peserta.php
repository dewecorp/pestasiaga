<?php
include "../../config/koneksi.php";

header('Content-Type: application/json');

// Ensure user is authenticated as admin
if (empty($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Akses tidak diizinkan. Silakan login terlebih dahulu.']);
    exit;
}

$csrf_token = $_POST['csrf_token'] ?? '';
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
    echo json_encode(['status' => 'error', 'message' => 'Token keamanan tidak valid. Silakan muat ulang halaman.']);
    exit;
}

$jenis = $_POST['jenis'] ?? ''; // 'pa' or 'pi'
if (!in_array($jenis, ['pa', 'pi'], true)) {
    echo json_encode(['status' => 'error', 'message' => 'Jenis peserta tidak valid.']);
    exit;
}

$rows_json = $_POST['rows'] ?? '';
if (is_string($rows_json)) {
    $rows = json_decode($rows_json, true);
} else {
    $rows = $rows_json;
}

if (!is_array($rows) || empty($rows)) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada data peserta yang valid untuk diimpor.']);
    exit;
}

$imported = 0;
$skipped = 0;

if ($jenis === 'pa') {
    foreach ($rows as $row) {
        $pangkalan = trim($row['pangkalan'] ?? '');
        $pembina   = trim($row['pembina'] ?? '');

        if ($pangkalan === '') {
            $skipped++;
            continue;
        }

        // Auto generate no_dada (ganjil: 01, 03, 05, ...)
        $max_row = db_one($koneksi, "SELECT no_dada FROM tb_peserta_pa WHERE no_dada != '' AND no_dada IS NOT NULL ORDER BY CAST(no_dada AS UNSIGNED) DESC LIMIT 1");
        $last_no = $max_row ? (int)$max_row['no_dada'] : -1;

        if ($last_no == -1) {
            $next_no = 1;
        } else {
            if ($last_no % 2 == 0) {
                $next_no = $last_no + 1;
            } else {
                $next_no = $last_no + 2;
            }
        }
        $no_dada = sprintf("%02d", $next_no);

        $stmt = db_exec($koneksi, "INSERT INTO tb_peserta_pa (no_dada, pangkalan, pembina) VALUES (?, ?, ?)", [$no_dada, $pangkalan, $pembina]);
        if ($stmt) {
            $id = $koneksi->insert_id;
            db_exec($koneksi, "INSERT INTO tb_rekap (id_pa, toleransi, tanda_pengenal, rangking, kim, scout_skill, lbb, kereta_bola, seni_budaya, bumbung, nilai_akhir_pa) VALUES (?, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')", [$id]);
            $imported++;
        } else {
            $skipped++;
        }
    }
} else { // 'pi'
    foreach ($rows as $row) {
        $pangkalan = trim($row['pangkalan'] ?? '');
        $pembina   = trim($row['pembina'] ?? '');

        if ($pangkalan === '') {
            $skipped++;
            continue;
        }

        // Auto generate no_dada (genap: 02, 04, 06, ...)
        $max_row = db_one($koneksi, "SELECT no_dada FROM tb_peserta_pi WHERE no_dada != '' AND no_dada IS NOT NULL ORDER BY CAST(no_dada AS UNSIGNED) DESC LIMIT 1");
        $last_no = $max_row ? (int)$max_row['no_dada'] : 0;

        if ($last_no == 0) {
            $next_no = 2;
        } else {
            if ($last_no % 2 != 0) {
                $next_no = $last_no + 1;
            } else {
                $next_no = $last_no + 2;
            }
        }
        $no_dada = sprintf("%02d", $next_no);

        $stmt = db_exec($koneksi, "INSERT INTO tb_peserta_pi (no_dada, pangkalan, pembina) VALUES (?, ?, ?)", [$no_dada, $pangkalan, $pembina]);
        if ($stmt) {
            $id = $koneksi->insert_id;
            db_exec($koneksi, "INSERT INTO tb_rekap_pi (id_pi, ketakwaan, toleransi, tanda_pengenal, rangking, kim, scout_skill, lbb, kereta_bola, seni_budaya, bumbung, nilai_akhir_pi) VALUES (?, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')", [$id]);
            $imported++;
        } else {
            $skipped++;
        }
    }
}

if ($imported > 0) {
    echo json_encode([
        'status' => 'success',
        'message' => "Berhasil mengimpor {$imported} data peserta." . ($skipped > 0 ? " ({$skipped} baris dilewati)" : ""),
        'imported' => $imported,
        'skipped' => $skipped
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal mengimpor data peserta. Pastikan data pangkalan terisi dengan benar.'
    ]);
}
