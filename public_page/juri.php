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
                            <th>Pangkalan</th>
                            <th>Koordinator Taman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM tb_juri
                        LEFT JOIN tb_taman ON tb_juri.id_taman = tb_taman.id_taman
                        LEFT JOIN tb_peserta_pa ON tb_juri.id_pa = tb_peserta_pa.id_pa");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nama_juri'] ?></td>
                            <td><?= isset($data['pangkalan']) ? $data['pangkalan'] : '-' ?></td>
                            <td><?= isset($data['nama_taman']) ? $data['nama_taman'] : '-' ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>