<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">TAMBAH DATA JURI</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nama">Nama Juri</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Juri" required autofocus>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="pangkalan">Pangkalan</label>
                            <select name="pangkalan" id="pangkalan" class="js-example-basic-single form-control show-tick" required>
                                <option value="">- Pilih Pangkalan -</option>
                                <?php
								$sql = $koneksi->query("SELECT * FROM tb_peserta_pa ORDER BY pangkalan ASC");
								while ($data = $sql->fetch_assoc()) {
								echo '<option value="'.$data['id_pa'].'"> '.$data['pangkalan'].'</option>';
								}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="taman">Koordinator Taman</label>
                            <select name="taman" id="taman" class="js-example-basic-single form-control show-tick" required>
                                <option value="">- Pilih Taman -</option>
                                <?php
								$sql = $koneksi->query("SELECT * FROM tb_taman ORDER BY nama_taman ASC");
								while ($data = $sql->fetch_assoc()) {
								echo '<option value="'.$data['id_taman'].'"> '.$data['nama_taman'].'</option>';
								}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="hp">No. Handphone/WA</label>
                            <input type="number" name="hp" id="hp" class="form-control" placeholder="No. Handphone/WA" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="simpan" class="btn btn-success waves-effect" value="Simpan">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if (@$_POST['simpan']) {
$nama 	   = @$_POST['nama'];
$pangkalan = @$_POST['pangkalan'];
$taman 	   = @$_POST['taman'];
$hp 	   = @$_POST['hp'];
$sql = $koneksi->query("INSERT INTO tb_juri (nama_juri, id_pa, id_taman, no_hp) VALUES ('$nama', '$pangkalan', '$taman', '$hp')"); ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?=$nama; ?>',
        text: 'Berhasil Ditambahkan',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=juri';
    }, 1500);

</script>
<?php
}
?>
