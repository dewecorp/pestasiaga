<?php
$sql = $koneksi->query("SELECT * FROM tb_taman ORDER BY nama_taman ASC");
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
            <h2>DATA TAMAN</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Taman</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $data): ?>
                        <tr>
                            <td align="center"><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($data['nama_taman']) ?></td>
                            <td><?= htmlspecialchars($data['lokasi']) ?></td>
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
    <div style="font-size:13px; font-weight:700; color:#5D4037; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
        <i class="material-icons" style="font-size:18px;">domain</i> Data Taman Kegiatan
    </div>
    <?php if (empty($rows)): ?>
        <div class="mob-card-item" style="text-align:center; color:#78909c;">Belum ada data taman.</div>
    <?php endif; ?>
    <?php foreach ($rows as $i => $data): ?>
    <div class="mob-card-item">
        <div class="mob-card-header">
            <div class="mob-card-badge"><?= $i + 1 ?></div>
            <div class="mob-card-title"><?= htmlspecialchars($data['nama_taman']) ?></div>
        </div>
        <div class="mob-card-row">
            <span class="label-text">Lokasi Pos:</span>
            <span class="value-text"><?= htmlspecialchars($data['lokasi'] ?: '-') ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>
