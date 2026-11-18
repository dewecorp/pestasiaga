<?php
$sql = $koneksi->query("SELECT j.*, t.nama_taman,
    COALESCE(NULLIF(j.pangkalan, ''), p.pangkalan, '-') AS pangkalan_instansi
FROM tb_juri j
LEFT JOIN tb_taman t ON j.id_taman = t.id_taman
LEFT JOIN tb_peserta_pa p ON j.id_pa = p.id_pa
ORDER BY j.id_juri ASC");
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
            <h2>DEWAN JURI</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Juri</th>
                            <th>Pangkalan / Instansi</th>
                            <th>Koordinator Taman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $data): ?>
                        <tr>
                            <td align="center"><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($data['nama_juri']) ?></td>
                            <td><?= htmlspecialchars($data['pangkalan_instansi']) ?></td>
                            <td><?= htmlspecialchars($data['nama_taman'] ?? '-') ?></td>
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
        <i class="material-icons" style="font-size:18px;">gavel</i> Daftar Dewan Juri
    </div>
    <?php if (empty($rows)): ?>
        <div class="mob-card-item" style="text-align:center; color:#78909c;">Belum ada data dewan juri.</div>
    <?php endif; ?>
    <?php foreach ($rows as $i => $data): ?>
    <div class="mob-card-item">
        <div class="mob-card-header">
            <div class="mob-card-badge" style="background:#f59e0b;"><?= $i + 1 ?></div>
            <div class="mob-card-title"><?= htmlspecialchars($data['nama_juri']) ?></div>
        </div>
        <div class="mob-card-row">
            <span class="label-text">Instansi / Pangkalan:</span>
            <span class="value-text"><?= htmlspecialchars($data['pangkalan_instansi']) ?></span>
        </div>
        <div class="mob-card-row">
            <span class="label-text">Tugas Taman:</span>
            <span class="value-text" style="color:#2e7d32; font-weight:700;"><?= htmlspecialchars($data['nama_taman'] ?? '-') ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>
