<?php
$stats = []; // [pangkalan => [nilai=>0, nilai_pa=>0, nilai_pi=>0]]

// Process Putra
$sql_pa = $koneksi->query("SELECT p.pangkalan, r.* FROM tb_peserta_pa p LEFT JOIN tb_rekap r ON p.id_pa = r.id_pa");
if ($sql_pa) {
    while ($row = $sql_pa->fetch_assoc()) {
        $pangkalan = $row['pangkalan'];
        if (!isset($stats[$pangkalan])) $stats[$pangkalan] = ['nilai' => 0, 'nilai_pa' => 0, 'nilai_pi' => 0];
        $stats[$pangkalan]['nilai_pa'] += (int)$row['nilai_akhir_pa'];
        $stats[$pangkalan]['nilai'] += (int)$row['nilai_akhir_pa'];
    }
}

// Process Putri
$sql_pi = $koneksi->query("SELECT p.pangkalan, r.* FROM tb_peserta_pi p LEFT JOIN tb_rekap_pi r ON p.id_pi = r.id_pi");
if ($sql_pi) {
    while ($row = $sql_pi->fetch_assoc()) {
        $pangkalan = $row['pangkalan'];
        if (!isset($stats[$pangkalan])) $stats[$pangkalan] = ['nilai' => 0, 'nilai_pa' => 0, 'nilai_pi' => 0];
        $stats[$pangkalan]['nilai_pi'] += (int)$row['nilai_akhir_pi'];
        $stats[$pangkalan]['nilai'] += (int)$row['nilai_akhir_pi'];
    }
}

uasort($stats, function ($a, $b) {
    return $b['nilai'] - $a['nilai'];
});

function get_juara_umum_info($no) {
    switch ($no) {
        case 1: return ['Juara Umum I',   'label-success', '#ffd700', '🥇'];
        case 2: return ['Juara Umum II',  'label-success', '#c0c0c0', '🥈'];
        case 3: return ['Juara Umum III', 'label-success', '#cd7f32', '🥉'];
        case 4: return ['Harapan I',      'label-warning', '#1976d2', '🏅'];
        case 5: return ['Harapan II',     'label-warning', '#1976d2', '🏅'];
        case 6: return ['Harapan III',    'label-warning', '#1976d2', '🏅'];
        default: return ['', '', '#cfd8dc', ''];
    }
}
?>
<!-- TAMPILAN DESKTOP: TABEL STANDAR -->
<div class="container content-section desktop-table-view">
    <div class="card">
        <style>
            .table thead th {
                text-align: center !important;
                vertical-align: middle !important;
            }
        </style>
        <div class="header bg-purple" style="display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
            <h2 style="margin: 0;">JUARA UMUM</h2>
            <div style="display: flex; gap: 6px;">
                <a href="laporan/juara_excel.php" target="_blank" onclick="window.open(this.href); return false;"
                   class="btn btn-success btn-sm" style="border-radius: 8px; display: inline-flex; align-items: center; gap: 5px; font-weight: 700;">
                    <i class="material-icons" style="font-size: 16px;">grid_on</i> Excel
                </a>
                <a href="laporan/juara_pdf.php" target="_blank" onclick="window.open(this.href); return false;"
                   class="btn btn-danger btn-sm" style="border-radius: 8px; display: inline-flex; align-items: center; gap: 5px; font-weight: 700;">
                    <i class="material-icons" style="font-size: 16px;">picture_as_pdf</i> PDF
                </a>
            </div>
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
                        foreach ($stats as $pangkalan => $data):
                            [$predikat, $badge_color] = get_juara_umum_info($no);
                        ?>
                        <tr>
                            <td align="center"><?= $no ?></td>
                            <td><?= htmlspecialchars($pangkalan) ?></td>
                            <td align="center"><?= $data['nilai_pa'] ?></td>
                            <td align="center"><?= $data['nilai_pi'] ?></td>
                            <td align="center"><strong><?= $data['nilai'] ?></strong></td>
                            <td align="center">
                                <?php if ($predikat != ""): ?>
                                <span class="label <?= $badge_color ?>"><?= $predikat ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TAMPILAN MOBILE: KARTU INDAH TANPA GESER KANAN KIRI -->
<div class="container mobile-card-view" style="padding-top: 15px;">
    <div style="font-size:13px; font-weight:700; color:#5D4037; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
        <i class="material-icons" style="font-size:18px;">emoji_events</i> Klasemen Juara Umum
    </div>
    <div style="display: flex; gap: 8px; margin-bottom: 12px;">
        <a href="laporan/juara_excel.php" onclick="window.open(this.href); return false;"
           class="btn btn-success btn-sm" style="flex: 1; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 700; font-size: 12.5px;">
            <i class="material-icons" style="font-size: 17px;">grid_on</i> Excel
        </a>
        <a href="laporan/juara_pdf.php" onclick="window.open(this.href); return false;"
           class="btn btn-danger btn-sm" style="flex: 1; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 700; font-size: 12.5px;">
            <i class="material-icons" style="font-size: 17px;">picture_as_pdf</i> PDF
        </a>
    </div>

    <?php
    $no = 1;
    foreach ($stats as $pangkalan => $data):
        [$predikat, $badge_color, $color, $emo] = get_juara_umum_info($no);
        $is_podium = $no <= 3;
    ?>
    <div class="mob-card-item" style="border-left: 5px solid <?= $color ?>; <?= $is_podium ? 'background: linear-gradient(to right, #fffef5, #ffffff);' : '' ?>">
        <div class="mob-card-header">
            <div class="mob-card-badge" style="background:<?= $color ?>; color:<?= $no <= 2 ? '#333' : '#fff' ?>; font-size:<?= $is_podium ? '18px' : '13px' ?>;">
                <?= $emo ?: $no ?>
            </div>
            <div style="flex:1;">
                <div class="mob-card-title"><?= htmlspecialchars($pangkalan) ?></div>
                <?php if ($predikat != ""): ?>
                <span class="label <?= $badge_color ?>" style="display:inline-block; font-size:10px; margin-top:2px;"><?= $predikat ?></span>
                <?php endif; ?>
            </div>
            <div style="text-align:right;">
                <div style="font-size:22px; font-weight:800; color:#5D4037; line-height:1;"><?= $data['nilai'] ?></div>
                <div style="font-size:10px; color:#78909c; text-transform:uppercase; margin-top:2px;">Total Nilai</div>
            </div>
        </div>
        <div style="display:flex; justify-content:space-between; font-size:12px; padding:0 2px; color:#546e7a;">
            <span>Nilai PA: <b style="color:#1565c0;"><?= $data['nilai_pa'] ?></b></span>
            <span>Nilai PI: <b style="color:#c2185b;"><?= $data['nilai_pi'] ?></b></span>
        </div>
    </div>
    <?php $no++; endforeach; ?>
</div>
