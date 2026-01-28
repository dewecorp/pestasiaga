<?php
include "../../config/koneksi.php";

header('Content-Type: application/json');

$type = isset($_POST['type']) ? $_POST['type'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$peserta_id = isset($_POST['peserta_id']) ? $_POST['peserta_id'] : '';
$values = isset($_POST['values']) ? $_POST['values'] : [];

if (empty($type)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing Type']);
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

// Handle creation of new record if ID is missing
$new_id = null;
if (empty($id) || $id == 'undefined') {
    if (empty($peserta_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing ID and Peserta ID']);
        exit;
    }
    
    // Check if record already exists for this peserta
    $check_sql = "SELECT $id_col FROM $table WHERE $fk_col = '" . $koneksi->real_escape_string($peserta_id) . "'";
    $check = $koneksi->query($check_sql);
    
    if ($check && $check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $id = $row[$id_col];
        // We found an existing ID, so we treat it as an update to that ID.
        // We act as if we found a new ID so the frontend updates its data-id attribute.
        $new_id = $id; 
    } else {
        // Insert new record
        $insert_sql = "INSERT INTO $table ($fk_col) VALUES ('" . $koneksi->real_escape_string($peserta_id) . "')";
        if ($koneksi->query($insert_sql)) {
            $id = $koneksi->insert_id;
            $new_id = $id;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create new record: ' . $koneksi->error]);
            exit;
        }
    }
}

// Helper function for mapping (Must match the one in rekap pages)
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

// 1. Update the individual columns
$updates = [];
if (!empty($values)) {
    foreach ($values as $col => $val) {
        if ((int)$val > 100) {
            echo json_encode(['status' => 'error', 'message' => 'Nilai maksimal adalah 100']);
            exit;
        }
        // Sanitize input
        $val = $koneksi->real_escape_string($val);
        $updates[] = "$col = '$val'";
    }

    if (!empty($updates)) {
        $update_sql = "UPDATE $table SET " . implode(', ', $updates) . " WHERE $id_col = '$id'";
        if (!$koneksi->query($update_sql)) {
            echo json_encode(['status' => 'error', 'message' => $koneksi->error]);
            exit;
        }
    }
}

// 2. Recalculate Total
// Get all score columns from tb_taman
$taman_sql = $koneksi->query("SELECT nama_taman FROM tb_taman");
$score_cols = [];
if ($taman_sql) {
    while ($t = $taman_sql->fetch_assoc()) {
        $col = map_column_taman($t['nama_taman']);
        // Avoid duplicates if multiple taman map to same column (unlikely but safe)
        if (!in_array($col, $score_cols)) {
            $score_cols[] = $col;
        }
    }
}

// Fetch current values
$row_sql = $koneksi->query("SELECT * FROM $table WHERE $id_col = '$id'");
if ($row_sql) {
    $row = $row_sql->fetch_assoc();
    
    $total = 0;
    foreach ($score_cols as $col) {
        // Check if column exists in row to avoid errors
        if (isset($row[$col])) {
            $total += (int)$row[$col];
        }
    }
    
    // 3. Update Total
    $update_total_sql = "UPDATE $table SET $final_col = '$total' WHERE $id_col = '$id'";
    if ($koneksi->query($update_total_sql)) {
        $response = ['status' => 'success', 'total' => $total];
        if ($new_id !== null) {
            $response['new_id'] = $new_id;
        }
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => $koneksi->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch updated row']);
}
?>
