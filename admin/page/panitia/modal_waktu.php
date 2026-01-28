<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {

?>
<!-- Modal -->
<div class="modal fade" id="modal_waktu<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">EDIT WAKTU DAN TEMPAT KEGIATAN</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="row">
                        <div class="col-lg-2 form-control-label">
                            <label for="tgl">Tanggal</label>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" name="waktu" class="form-control" value="<?=$data['waktu']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 form-control-label">
                            <label for="tempat">Lokasi Kegiatan</label>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea name="tempat" rows="2" cols="50" class="form-control"><?= $data['tempat']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 form-control-label">
                            <label for="tempat_ttd">Tempat TTD</label>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="tempat_ttd" class="form-control" value="<?=$data['tempat_ttd']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" name="ubah" class="btn btn-success  btn-sm waves-effect">Simpan</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}
?>
<?php
if (isset($_POST['ubah'])) {
$id = $_POST['id'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$tempat_ttd = $_POST['tempat_ttd'];
$koneksi->query("UPDATE tb_panitia SET waktu='$waktu', tempat='$tempat', tempat_ttd='$tempat_ttd' WHERE id_panitia='$id'"); ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Waktu Giat Berhasil Diedit',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);

</script>
<?php
}
?>
