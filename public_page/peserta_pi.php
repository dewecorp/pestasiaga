<div class="container content-section">
    <div class="card">
        <style>
            .table thead th {
                text-align: center !important;
                vertical-align: middle !important;
            }
        </style>
        <div class="header bg-purple">
            <h2>PESERTA BARUNG PUTRI</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nomor Dada</th>
                            <th>Nama Pangkalan</th>
                            <th>Nama Pembina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM tb_peserta_pi ORDER BY no_dada ASC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['no_dada'] ?></td>
                            <td><?= $data['pangkalan'] ?></td>
                            <td><?= $data['pembina'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>