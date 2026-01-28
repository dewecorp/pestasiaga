<?php
// Logic for calculating Juara Umum

// Helper function for mapping
if(!function_exists('map_column_taman_public')) {
    function map_column_taman_public($nama) {
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
        if (strpos($nama, 'kerapian') !== false) return 'kerapian';
        if (strpos($nama, 'patriotisme') !== false) return 'patriotisme';

        $nama = str_replace([' putra', ' putri'], '', $nama);
        return str_replace(' ', '_', $nama);
    }
}

// 1. Get existing columns in tables to avoid errors
$existing_cols_pa = [];
$q_show_pa = $koneksi->query("SHOW COLUMNS FROM tb_rekap");
if ($q_show_pa) {
    while($r = $q_show_pa->fetch_assoc()) $existing_cols_pa[] = $r['Field'];
}

$existing_cols_pi = [];
$q_show_pi = $koneksi->query("SHOW COLUMNS FROM tb_rekap_pi");
if ($q_show_pi) {
    while($r = $q_show_pi->fetch_assoc()) $existing_cols_pi[] = $r['Field'];
}

// 2. Get active Taman columns for Putra
$cols_pa = [];
$q_pa = $koneksi->query("SELECT nama_taman FROM tb_taman WHERE nama_taman LIKE '%PUTRA%'");
if ($q_pa) {
    while($row = $q_pa->fetch_assoc()) {
        $col = map_column_taman_public($row['nama_taman']);
        if(in_array($col, $existing_cols_pa) && !in_array($col, $cols_pa)) {
            $cols_pa[] = $col;
        }
    }
}

// 3. Get active Taman columns for Putri
$cols_pi = [];
$q_pi = $koneksi->query("SELECT nama_taman FROM tb_taman WHERE nama_taman LIKE '%PUTRI%'");
if ($q_pi) {
    while($row = $q_pi->fetch_assoc()) {
        $col = map_column_taman_public($row['nama_taman']);
        if(in_array($col, $existing_cols_pi) && !in_array($col, $cols_pi)) {
            $cols_pi[] = $col;
        }
    }
}

// 4. Calculate Stats per Pangkalan
$stats = []; // [pangkalan => [emas=>0, perak=>0, perunggu=>0, nilai=>0]]

// Process Putra
$sql_pa = $koneksi->query("SELECT p.pangkalan, r.* FROM tb_peserta_pa p LEFT JOIN tb_rekap r ON p.id_pa = r.id_pa");
if ($sql_pa) {
    while($row = $sql_pa->fetch_assoc()) {
        $pangkalan = $row['pangkalan'];
        if(!isset($stats[$pangkalan])) $stats[$pangkalan] = ['nilai'=>0, 'nilai_pa'=>0, 'nilai_pi'=>0];
        
        // Add total score
        $stats[$pangkalan]['nilai_pa'] += (int)$row['nilai_akhir_pa'];
        $stats[$pangkalan]['nilai'] += (int)$row['nilai_akhir_pa'];
    }
}

// Process Putri
$sql_pi = $koneksi->query("SELECT p.pangkalan, r.* FROM tb_peserta_pi p LEFT JOIN tb_rekap_pi r ON p.id_pi = r.id_pi");
if ($sql_pi) {
    while($row = $sql_pi->fetch_assoc()) {
        $pangkalan = $row['pangkalan'];
        if(!isset($stats[$pangkalan])) $stats[$pangkalan] = ['nilai'=>0, 'nilai_pa'=>0, 'nilai_pi'=>0];
        
        // Add total score
        $stats[$pangkalan]['nilai_pi'] += (int)$row['nilai_akhir_pi'];
        $stats[$pangkalan]['nilai'] += (int)$row['nilai_akhir_pi'];
    }
}

// 5. Sorting (Total Score DESC)
uasort($stats, function($a, $b) {
    return $b['nilai'] - $a['nilai'];
});
?>

<div class="container content-section">
    <div class="card">
        <div class="header bg-purple">
            <h2>JUARA UMUM</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Pangkalan</th>
                            <th>Total Nilai Putra</th>
                            <th>Total Nilai Putri</th>
                            <th>Total Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach($stats as $pangkalan => $data) {
                            $predikat = "";
                            $badge_color = "";
                            
                            switch ($no) {
                                case 1: $predikat = "Juara Umum I"; $badge_color = "label-success"; break;
                                case 2: $predikat = "Juara Umum II"; $badge_color = "label-success"; break;
                                case 3: $predikat = "Juara Umum III"; $badge_color = "label-success"; break;
                                case 4: $predikat = "Harapan I"; $badge_color = "label-warning"; break;
                                case 5: $predikat = "Harapan II"; $badge_color = "label-warning"; break;
                                case 6: $predikat = "Harapan III"; $badge_color = "label-warning"; break;
                            }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $pangkalan ?></td>
                            <td><?= $data['nilai_pa'] ?></td>
                            <td><?= $data['nilai_pi'] ?></td>
                            <td><?= $data['nilai'] ?></td>
                            <td>
                                <?php if ($predikat != ""): ?>
                                <span class="label <?= $badge_color ?>"><?= $predikat ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>