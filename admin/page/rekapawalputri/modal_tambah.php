<div class="modal fade" id="rekapModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="width:90%; height: 90%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="largeModalLabel" align="center">INPUT NILAI TAMAN BARUNG PUTRI</h4>
            </div>
            <form action="" method="post" name="autoSum" id="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th style="width: 5px;">Nomor Dada</th>
                                    <th style="width: 10px;">Nama Pangkalan</th>
                                    <th>Ketakwaan</th>
                                    <th>Toleransi</th>
                                    <th>Tanda Pengenal</th>
                                    <th>Rangking 1</th>
                                    <th>KIM</th>
                                    <th>Scout Skills</th>
                                    <th>LBB</th>
                                    <th>Kereta Bola</th>
                                    <th>Seni Budaya</th>
                                    <th>Bumbung Peduli</th>
                                    <th>Nilai Akhir</th>


                                </tr>
                            </thead>

                            <tbody>
                                <?php
									$no = 1;
									$sql = $koneksi->query("SELECT * FROM tb_rekap_pi
											 RIGHT JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi ORDER BY no_dada ASC");
									while($data = $sql->fetch_assoc()) {	
										$nilai_akhir = $data['ketakwaan']+$data['toleransi']+$data['tanda_pengenal']+$data['rangking']+$data['kim']+$data['scout_skill']+$data['lbb']+$data['kereta_bola']+$data['seni_budaya']+$data['bumbung'];                                                                 
								?>
                                <tr>
                                    <td><?=$no++.".";?></td>
                                    <td><?=$data['no_dada'];?></td>
                                    <td style="width: 30px"><?=$data['pangkalan'];?></td>
                                    <td>
                                        <input type="text" class="form-control" name="ketakwaan" id="ketakwaan" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td style="width: 30px">
                                        <input type="text" class="form-control" name="toleransi" id="toleransi" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td style="width: 30px">
                                        <input type="text" class="form-control" name="pengenal" id="pengenal" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td style="width: 30px">
                                        <input type="text" class="form-control" name="rangking" id="rangking" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td style="width: 30px">
                                        <input type="text" class="form-control" name="kim" id="kim" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td style="width: 30px">
                                        <input type="text" class="form-control" name="scout" id="scout" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="lbb" id="lbb" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="kereta" id="kereta" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="seni" id="seni" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="bumbung" id="bumbung" onkeyup="sum();" style="width: 60px">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="nilai" id="nilai" style="width: 60px" value="" disabled>
                                    </td>


                                </tr>

                                <?php 

									}
								
								?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="simpan" class="btn btn-success waves-effect" value="Simpan">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                </div>
            </form>
            <?php

				$ketakwaan = @$_POST['ketakwaan'];
				$toleransi = @$_POST['toleransi'];
				$pengenal = @$_POST['pengenal'];
				$rangking = @$_POST['rangking'];
				$kim = @$_POST['kim'];
				$scout = @$_POST['scout'];
				$lbb = @$_POST['lbb'];
				$kereta = @$_POST['kereta'];
				$seni = @$_POST['seni'];
				$bumbung = @$_POST['bumbung'];
				$nilai = @$_POST['nilai'];
							

				$simpan = @$_POST['simpan'];

				if ($simpan) {
				$koneksi->query("INSERT INTO  tb_rekap_pi (ketakwaan, toleransi, tanda_pengenal, rangking, kim, scout_skill, lbb, kereta_bola, seni_budaya, bumbung, nilai_akhir_pi) VALUES ('$ketakwaan', '$toleransi', '$pengenal', '$rangking', '$kim', '$scout', '$lbb', '$kereta', '$seni', '$bumbung', '$nilai')"); 

			?>

            <script>
                alert('Data Nilai Berhasil Ditambahkan');
                window.location.href = "?page=rekapawalputri";

            </script>

            <?php
				}

			?>
        </div>
    </div>
</div>
