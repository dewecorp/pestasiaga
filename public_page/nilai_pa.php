<?php
// Ambil data taman untuk Putra
$sql_taman = $koneksi->query("SELECT * FROM tb_taman WHERE nama_taman LIKE '%PUTRA%' ORDER BY id_taman ASC");
$data_taman = [];
while ($t = $sql_taman->fetch_assoc()) {
    $data_taman[] = $t;
}

if (!function_exists('map_col_public')) {
    function map_col_public($nama) {
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
}

$total_peserta_sql = $koneksi->query("SELECT COUNT(*) as total FROM tb_peserta_pa");
$total_peserta = $total_peserta_sql->fetch_assoc()['total'];

$total_taman = count($data_taman);
$total_sel = $total_peserta * $total_taman;

$terisi = 0;
$sql_rekap = $koneksi->query("SELECT * FROM tb_rekap");
while ($r = $sql_rekap->fetch_assoc()) {
    foreach ($data_taman as $t) {
        $col = map_col_public($t['nama_taman']);
        if (isset($r[$col]) && $r[$col] !== "" && $r[$col] !== null) {
            $terisi++;
        }
    }
}

$persentase = ($total_sel > 0) ? ($terisi / $total_sel) * 100 : 0;
$persentase = round($persentase, 2);

$col_names = [
    'ketakwaan' => 'Ketakwaan',
    'toleransi' => 'Toleransi',
    'tanda_pengenal' => 'Tanda Pengenal',
    'rangking' => 'Rangking 1',
    'kim' => 'KIM',
    'scout_skill' => 'Scout Skill',
    'lbb' => 'LBB',
    'kereta_bola' => 'Kereta Bola',
    'seni_budaya' => 'Seni Budaya',
    'bumbung' => 'Bumbung',
    'lempar_bola' => 'Lempar Bola',
    'kerapian' => 'Kerapian',
    'patriotisme' => 'Patriotisme'
];

$sql = $koneksi->query("SELECT * FROM tb_rekap 
                      JOIN tb_peserta_pa ON tb_rekap.id_pa = tb_peserta_pa.id_pa 
                      ORDER BY CAST(tb_peserta_pa.no_dada AS UNSIGNED) ASC, tb_peserta_pa.no_dada ASC");
$rows = [];
while ($r = $sql->fetch_assoc()) $rows[] = $r;
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
        <div class="header bg-purple">
            <h2>REKAP NILAI PUTRA</h2>
        </div>
        <div class="body">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12">
                    <b>Progres Nilai Masuk: <?= $persentase ?>% (<?= $terisi ?> / <?= $total_sel ?>)</b>
                    <div class="progress" style="height: 20px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persentase ?>%; line-height: 20px;">
                            <?= $persentase ?>%
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Dada</th>
                            <th>Pangkalan</th>
                            <?php foreach ($col_names as $col => $lbl): ?>
                            <th><?= $lbl ?></th>
                            <?php endforeach; ?>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $data): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $data['no_dada'] ?></td>
                            <td><?= $data['pangkalan'] ?></td>
                            <?php foreach ($col_names as $col => $lbl): ?>
                            <td><?= $data[$col] ?? '-' ?></td>
                            <?php endforeach; ?>
                            <td><strong><?= $data['nilai_akhir_pa'] ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TAMPILAN MOBILE: KARTU INDAH TANPA GESER KANAN KIRI -->
<div class="container mobile-card-view" style="padding-top: 15px;">
    <!-- Progress Info -->
    <div class="mob-card-item" style="border-left:4px solid #10b981; margin-bottom:14px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
            <span style="font-size:12px; font-weight:700; color:#2e7d32; text-transform:uppercase;">
                <i class="material-icons" style="font-size:16px; vertical-align:middle;">donut_large</i> Progres Nilai PA
            </span>
            <span style="font-size:14px; font-weight:800; color:#2e7d32;"><?= $persentase ?>%</span>
        </div>
        <div class="progress" style="height:10px; margin-bottom:4px; border-radius:6px; background:#e2e8f0;">
            <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $persentase ?>%; border-radius:6px;"></div>
        </div>
        <div style="font-size:11px; color:#78909c; text-align:right;">Terisi <?= $terisi ?> dari <?= $total_sel ?> item</div>
    </div>

    <!-- Search Box Mobile -->
    <div style="margin-bottom: 12px; position: relative;">
        <i class="material-icons" style="position: absolute; left: 12px; top: 10px; font-size: 20px; color: #94a3b8;">search</i>
        <input type="text" id="searchNilaiPa" class="form-control" placeholder="Cari nama pangkalan atau no dada..." 
               style="height: 42px; padding-left: 40px; padding-right: 36px; border-radius: 12px; border: 1px solid #cbd5e1; box-shadow: 0 2px 6px rgba(0,0,0,0.03); font-size: 13px;"
               onkeyup="filterCards('searchNilaiPa', 'mob-card-pa')">
        <button type="button" id="btnClearSearchPa" onclick="clearCards('searchNilaiPa', 'mob-card-pa')" 
                style="position: absolute; right: 8px; top: 8px; border: none; background: transparent; color: #94a3b8; width: 26px; height: 26px; display: none; align-items: center; justify-content: center; cursor: pointer;">
            <i class="material-icons" style="font-size: 18px;">close</i>
        </button>
    </div>
    <div id="searchNilaiPa-nodata" style="display: none; text-align: center; padding: 25px 15px; color: #94a3b8; font-size: 13px;">
        <i class="material-icons" style="font-size: 36px; display: block; margin-bottom: 6px; color: #cbd5e1;">search_off</i>
        Data barung tidak ditemukan.
    </div>

    <div style="font-size:13px; font-weight:700; color:#1565c0; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
        <i class="material-icons" style="font-size:18px;">bar_chart</i> Rekap Nilai Barung Putra
    </div>

    <?php if (empty($rows)): ?>
        <div class="mob-card-item" style="text-align:center; color:#78909c;">Belum ada data nilai putra.</div>
    <?php endif; ?>

    <?php foreach ($rows as $i => $data): ?>
    <div class="mob-card-item mob-card-pa" style="border-left: 4px solid #1976d2;" data-search="<?= htmlspecialchars(strtolower($data['pangkalan'].' '.$data['no_dada'])) ?>">
        <div class="mob-card-header">
            <div class="mob-card-badge" style="background:#1976d2; font-size:11px; padding:0 4px;">
                #<?= htmlspecialchars($data['no_dada']) ?>
            </div>
            <div class="mob-card-title"><?= htmlspecialchars($data['pangkalan']) ?></div>
        </div>

        <!-- Rincian Nilai Per Taman (Grid 2 Kolom) -->
        <div class="mob-chips-grid">
            <?php foreach ($col_names as $col => $lbl): ?>
            <?php if (isset($data[$col]) && $data[$col] !== ''): ?>
            <div class="mob-chip">
                <div class="chip-name"><?= $lbl ?></div>
                <div class="chip-val"><?= $data[$col] ?></div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Total Nilai Akhir -->
        <div class="mob-final-score" style="background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%);">
            <span class="score-title">Nilai Akhir Barung</span>
            <span class="score-val"><?= $data['nilai_akhir_pa'] ?: '0' ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<link href="assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<script src="assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script>
    $(function () {
        if ($('.js-basic-example').length > 0) {
            $('.js-basic-example').DataTable({
                responsive: true
            });
        }
    });

    function filterCards(inputId, cardClass) {
        var inputEl = document.getElementById(inputId);
        var query = inputEl.value.toLowerCase().trim();
        var cards = document.getElementsByClassName(cardClass);
        var wrap = inputEl.parentElement;
        var clearBtn = wrap ? wrap.querySelector('button') : null;
        if (clearBtn) {
            clearBtn.style.display = query.length > 0 ? 'inline-flex' : 'none';
        }
        var found = 0;
        for (var i = 0; i < cards.length; i++) {
            var term = cards[i].getAttribute('data-search') || cards[i].innerText.toLowerCase();
            if (term.indexOf(query) > -1) {
                cards[i].style.display = '';
                found++;
            } else {
                cards[i].style.display = 'none';
            }
        }
        var noData = document.getElementById(inputId + '-nodata');
        if (noData) {
            noData.style.display = (found === 0) ? 'block' : 'none';
        }
    }
    function clearCards(inputId, cardClass) {
        var inp = document.getElementById(inputId);
        if (inp) {
            inp.value = '';
            filterCards(inputId, cardClass);
            inp.focus();
        }
    }
</script>
