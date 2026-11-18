<?php
function get_predikat_info($no) {
    switch ($no) {
        case 1: return ['Tergiat I',   'label-success', '#ffd700', '🥇'];
        case 2: return ['Tergiat II',  'label-warning', '#c0c0c0', '🥈'];
        case 3: return ['Tergiat III', 'label-danger',  '#cd7f32', '🥉'];
        case 4: return ['Harapan I',   'label-primary', '#1976d2', '🏅'];
        case 5: return ['Harapan II',  'label-primary', '#1976d2', '🏅'];
        case 6: return ['Harapan III', 'label-primary', '#1976d2', '🏅'];
        default: return ['', '', '', ''];
    }
}

$sql_pa = $koneksi->query("SELECT * FROM tb_rekap 
                        JOIN tb_peserta_pa ON tb_rekap.id_pa = tb_peserta_pa.id_pa 
                        ORDER BY CAST(nilai_akhir_pa AS UNSIGNED) DESC LIMIT 6");
$rows_pa = [];
while ($r = $sql_pa->fetch_assoc()) $rows_pa[] = $r;

$sql_pi = $koneksi->query("SELECT * FROM tb_rekap_pi 
                        JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                        ORDER BY CAST(nilai_akhir_pi AS UNSIGNED) DESC LIMIT 6");
$rows_pi = [];
while ($r = $sql_pi->fetch_assoc()) $rows_pi[] = $r;
?>
<!-- TAMPILAN DESKTOP: TABEL STANDAR -->
<div class="container content-section desktop-table-view">
    <div class="row">
        <!-- Putra -->
        <div class="col-md-6">
            <div class="card">
                <style>
                    .table thead th {
                        text-align: center !important;
                        vertical-align: middle !important;
                    }
                </style>
                <div class="header bg-purple">
                    <h2>BARUNG BERPRESTASI PUTRA</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Dada</th>
                                    <th>Pangkalan</th>
                                    <th>Nilai</th>
                                    <th>Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows_pa as $i => $data):
                                    [$predikat, $badge_color] = get_predikat_info($i + 1);
                                ?>
                                <tr>
                                    <td align="center"><?= $i + 1 ?></td>
                                    <td align="center"><?= $data['no_dada'] ?></td>
                                    <td><?= $data['pangkalan'] ?></td>
                                    <td align="center"><strong><?= $data['nilai_akhir_pa'] ?></strong></td>
                                    <td align="center"><span class="label <?= $badge_color ?>"><?= $predikat ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Putri -->
        <div class="col-md-6">
            <div class="card">
                <div class="header bg-purple">
                    <h2>BARUNG BERPRESTASI PUTRI</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Dada</th>
                                    <th>Pangkalan</th>
                                    <th>Nilai</th>
                                    <th>Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows_pi as $i => $data):
                                    [$predikat, $badge_color] = get_predikat_info($i + 1);
                                ?>
                                <tr>
                                    <td align="center"><?= $i + 1 ?></td>
                                    <td align="center"><?= $data['no_dada'] ?></td>
                                    <td><?= $data['pangkalan'] ?></td>
                                    <td align="center"><strong><?= $data['nilai_akhir_pi'] ?></strong></td>
                                    <td align="center"><span class="label <?= $badge_color ?>"><?= $predikat ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TAMPILAN MOBILE: KARTU INDAH TANPA GESER KANAN KIRI -->
<div class="container mobile-card-view" style="padding-top: 15px;">
    <!-- Bagian Putra -->
    <div style="font-size:13px; font-weight:700; color:#1565c0; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
        <i class="material-icons" style="font-size:18px;">military_tech</i> Barung Berprestasi Putra
    </div>
    <?php foreach ($rows_pa as $i => $data):
        [$predikat, $badge_color, $color, $emo] = get_predikat_info($i + 1);
    ?>
    <div class="mob-card-item" style="border-left: 5px solid <?= $color ?>;">
        <div class="mob-card-header">
            <div class="mob-card-badge" style="background:<?= $color ?>; color:<?= $i < 2 ? '#333' : '#fff' ?>; font-size:16px;">
                <?= $emo ?>
            </div>
            <div style="flex:1;">
                <div class="mob-card-title"><?= htmlspecialchars($data['pangkalan']) ?></div>
                <div style="font-size:11px; color:#78909c;">No Dada: #<?= htmlspecialchars($data['no_dada']) ?></div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:20px; font-weight:800; color:#1565c0; line-height:1;"><?= $data['nilai_akhir_pa'] ?></div>
                <span class="label <?= $badge_color ?>" style="display:inline-block; margin-top:4px;"><?= $predikat ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Bagian Putri -->
    <div style="font-size:13px; font-weight:700; color:#c2185b; text-transform:uppercase; letter-spacing:0.8px; margin-top:20px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
        <i class="material-icons" style="font-size:18px;">military_tech</i> Barung Berprestasi Putri
    </div>
    <?php foreach ($rows_pi as $i => $data):
        [$predikat, $badge_color, $color, $emo] = get_predikat_info($i + 1);
    ?>
    <div class="mob-card-item" style="border-left: 5px solid <?= $color ?>;">
        <div class="mob-card-header">
            <div class="mob-card-badge" style="background:<?= $color ?>; color:<?= $i < 2 ? '#333' : '#fff' ?>; font-size:16px;">
                <?= $emo ?>
            </div>
            <div style="flex:1;">
                <div class="mob-card-title"><?= htmlspecialchars($data['pangkalan']) ?></div>
                <div style="font-size:11px; color:#78909c;">No Dada: #<?= htmlspecialchars($data['no_dada']) ?></div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:20px; font-weight:800; color:#c2185b; line-height:1;"><?= $data['nilai_akhir_pi'] ?></div>
                <span class="label <?= $badge_color ?>" style="display:inline-block; margin-top:4px;"><?= $predikat ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
