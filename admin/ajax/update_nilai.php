<?php
include "../../config/koneksi.php";

header('Content-Type: application/json');

// Ensure user is authenticated as admin
if (empty($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$type = isset($_POST['type']) ? $_POST['type'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$peserta_id = isset($_POST['peserta_id']) ? $_POST['peserta_id'] : '';
$values = (isset($_POST['values']) && is_array($_POST['values'])) ? $_POST['values'] : [];

if (empty($type) || !in_array($type, ['putra', 'putri'], true)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Type']);
    exit;
}

if ($type == 'putra') {
    $table = 'tb_rekap';
    $id_col = 'id_rekap';
    $fk_col = 'id_pa';
    $final_col = 'nilai_akhir_pa';
} else {
    $table = 'tb_rekap_pi';
    $id_col = 'id_rekap_pi';
    $fk_col = 'id_pi';
    $final_col = 'nilai_akhir_pi';
}

// Whitelist of valid score columns for security
$allowed_columns = [
    'ketakwaan', 'toleransi', 'tanda_pengenal', 'rangking', 'kim',
    'scout_skill', 'lbb', 'kereta_bola', 'lempar_bola', 'seni_budaya',
    'bumbung', 'kerapian', 'patriotisme'
];

// Handle creation of new record if ID is missing
$new_id = null;
if (empty($id) || $id == 'undefined') {
    if (empty($peserta_id) || !is_numeric($peserta_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing ID and Peserta ID']);
        exit;
    }
    
    // Check if record already exists for this peserta
    $row = db_one($koneksi, "SELECT $id_col FROM $table WHERE $fk_col = ?", [(int)$peserta_id]);
    
    if ($row) {
        $id = $row[$id_col];
        $new_id = $id; 
    } else {
        // Insert new record
        if ($type == 'putra') {
            $insert_sql = "INSERT INTO tb_rekap (id_pa, toleransi, tanda_pengenal, rangking, kim, scout_skill, lbb, kereta_bola, seni_budaya, bumbung, nilai_akhir_pa) 
                           VALUES (?, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
        } else {
            $insert_sql = "INSERT INTO tb_rekap_pi (id_pi, ketakwaan, toleransi, tanda_pengenal, rangking, kim, scout_skill, lbb, kereta_bola, seni_budaya, bumbung, nilai_akhir_pi) 
                           VALUES (?, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
        }

        $stmt = db_exec($koneksi, $insert_sql, [(int)$peserta_id]);
        if ($stmt) {
            $id = $koneksi->insert_id;
            $new_id = $id;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create new record']);
            exit;
        }
    }
}

// Helper function for mapping
function map_column_taman($nama) {
    $nama = strtolower(trim($nama));
    
    if (strpos($nama, 'scout') !== false) return 'scout_skill';
    if (strpos($nama, 'kim') !== false) return 'kim';
    if (strpos($nama, 'bumbung') !== false) return 'bumbung';
    if (strpos($nama, 'ketakwaan') !== false) return 'ketakwaan';
    if (strpos($nama, 'toleransi') !== false) return 'toleransi';
    if (strpos($nama, 'tanda') !== false) return 'tanda_pengenal';
    if (strpos($nama, 'ranking') !== false || strpos($nama, 'rangking') !== false) return 'rangking';
    if (strpos($nama, 'lbb') !== false) return 'lbb';
    if (strpos($nama, 'seni') !== false) return 'seni_budaya';
    if (strpos($nama, 'lempar') !== false) return 'lempar_bola';
    if (strpos($nama, 'kereta') !== false) return 'kereta_bola';
    
    $nama = str_replace([' putra', ' putri'], '', $nama);
    return str_replace(' ', '_', $nama);
}

// 1. Update individual columns
if (!empty($values)) {
    $updates = [];
    $params = [];
    foreach ($values as $col => $val) {
        // Validate column name against whitelist
        if (!in_array($col, $allowed_columns, true)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid column name']);
            exit;
        }
        $val_int = (int)$val;
        if ($val_int < 0 || $val_int > 100) {
            echo json_encode(['status' => 'error', 'message' => 'Nilai maksimal adalah 100']);
            exit;
        }
        $updates[] = "$col = ?";
        $params[] = $val_int;
    }

    if (!empty($updates)) {
        $params[] = (int)$id;
        $update_sql = "UPDATE $table SET " . implode(', ', $updates) . " WHERE $id_col = ?";
        if (!db_exec($koneksi, $update_sql, $params)) {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
            exit;
        }
    }
}

// 2. Recalculate Total
$search_term = strtoupper($type); // 'PUTRA' or 'PUTRI'
$taman_rows = db_all($koneksi, "SELECT nama_taman FROM tb_taman WHERE nama_taman LIKE ?", ['%' . $search_term . '%']);
$score_cols = [];
foreach ($taman_rows as $t) {
    $col = map_column_taman($t['nama_taman']);
    if (!in_array($col, $score_cols, true)) {
        $score_cols[] = $col;
    }
}

// Fetch current values
$row = db_one($koneksi, "SELECT * FROM $table WHERE $id_col = ?", [(int)$id]);
if ($row) {
    $total = 0;
    foreach ($score_cols as $col) {
        if (isset($row[$col])) {
            $total += (int)$row[$col];
        }
    }
    
    // 3. Update Total
    if (db_exec($koneksi, "UPDATE $table SET $final_col = ? WHERE $id_col = ?", [$total, (int)$id])) {
        $response = ['status' => 'success', 'total' => $total];
        if ($new_id !== null) {
            $response['new_id'] = $new_id;
        }
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update total']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch updated row']);
}
