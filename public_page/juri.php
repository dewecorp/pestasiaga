<div class="container content-section">
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
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT j.*, t.nama_taman,
                            COALESCE(NULLIF(j.pangkalan, ''), p.pangkalan, '-') AS pangkalan_instansi
                        FROM tb_juri j
                        LEFT JOIN tb_taman t ON j.id_taman = t.id_taman
                        LEFT JOIN tb_peserta_pa p ON j.id_pa = p.id_pa
                        ORDER BY j.id_juri ASC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= e($data['nama_juri']) ?></td>
                            <td><?= e($data['pangkalan_instansi']) ?></td>
                            <td><?= e($data['nama_taman'] ?? '-') ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
