<div class="container content-section">
    <div class="row">
        <!-- Putra -->
        <div class="col-md-6">
            <div class="card">
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
                                <?php
                                $no = 1;
                                $sql = $koneksi->query("SELECT * FROM tb_rekap 
                                                      JOIN tb_peserta_pa ON tb_rekap.id_pa = tb_peserta_pa.id_pa 
                                                      ORDER BY CAST(nilai_akhir_pa AS UNSIGNED) DESC LIMIT 6");
                                while ($data = $sql->fetch_assoc()) {
                                    $predikat = "";
                                    $badge_color = "";
                                    switch ($no) {
                                        case 1: $predikat = "Tergiat I"; $badge_color = "label-success"; break;
                                        case 2: $predikat = "Tergiat II"; $badge_color = "label-warning"; break;
                                        case 3: $predikat = "Tergiat III"; $badge_color = "label-danger"; break;
                                        case 4: $predikat = "Harapan I"; $badge_color = "label-primary"; break;
                                        case 5: $predikat = "Harapan II"; $badge_color = "label-primary"; break;
                                        case 6: $predikat = "Harapan III"; $badge_color = "label-primary"; break;
                                    }
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['no_dada'] ?></td>
                                    <td><?= $data['pangkalan'] ?></td>
                                    <td><?= $data['nilai_akhir_pa'] ?></td>
                                    <td><span class="label <?= $badge_color ?>"><?= $predikat ?></span></td>
                                </tr>
                                <?php } ?>
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
                                <?php
                                $no = 1;
                                $sql = $koneksi->query("SELECT * FROM tb_rekap_pi 
                                                      JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi 
                                                      ORDER BY CAST(nilai_akhir_pi AS UNSIGNED) DESC LIMIT 6");
                                while ($data = $sql->fetch_assoc()) {
                                    $predikat = "";
                                    $badge_color = "";
                                    switch ($no) {
                                        case 1: $predikat = "Tergiat I"; $badge_color = "label-success"; break;
                                        case 2: $predikat = "Tergiat II"; $badge_color = "label-warning"; break;
                                        case 3: $predikat = "Tergiat III"; $badge_color = "label-danger"; break;
                                        case 4: $predikat = "Harapan I"; $badge_color = "label-primary"; break;
                                        case 5: $predikat = "Harapan II"; $badge_color = "label-primary"; break;
                                        case 6: $predikat = "Harapan III"; $badge_color = "label-primary"; break;
                                    }
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['no_dada'] ?></td>
                                    <td><?= $data['pangkalan'] ?></td>
                                    <td><?= $data['nilai_akhir_pi'] ?></td>
                                    <td><span class="label <?= $badge_color ?>"><?= $predikat ?></span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>