<div class="container content-section">
    <div class="card">
        <div class="header bg-purple">
            <h2>REKAP NILAI PUTRI</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Dada</th>
                            <th>Pangkalan</th>
                            <th>Ketakwaan</th>
                            <th>Toleransi</th>
                            <th>Tanda Pengenal</th>
                            <th>Rangking 1</th>
                            <th>KIM</th>
                            <th>LBB</th>
                            <th>Kereta Bola</th>
                            <th>Seni Budaya</th>
                            <th>Bumbung</th>
                            <th>Lempar Bola</th>
                            <th>Kerapian</th>
                            <th>Patriotisme</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM tb_rekap_pi 
                                              JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                                              ORDER BY tb_peserta_pi.no_dada ASC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['no_dada'] ?></td>
                            <td><?= $data['pangkalan'] ?></td>
                            <td><?= $data['ketakwaan'] ?></td>
                            <td><?= $data['toleransi'] ?></td>
                            <td><?= $data['tanda_pengenal'] ?></td>
                            <td><?= $data['rangking'] ?></td>
                            <td><?= $data['kim'] ?></td>
                            <td><?= $data['lbb'] ?></td>
                            <td><?= $data['kereta_bola'] ?></td>
                            <td><?= $data['seni_budaya'] ?></td>
                            <td><?= $data['bumbung'] ?></td>
                            <td><?= $data['lempar_bola'] ?></td>
                            <td><?= $data['kerapian'] ?></td>
                            <td><?= $data['patriotisme'] ?></td>
                            <td><strong><?= $data['nilai_akhir_pi'] ?></strong></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- JQuery DataTable Css -->
<link href="assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- JQuery DataTable Js -->
<script src="assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script>
    $(function () {
        $('.js-basic-example').DataTable({
            responsive: true
        });
    });
</script>