<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {

?>
<!-- Modal -->
<div class="modal fade" id="modal_pesan<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">EDIT PESAN BERANDA</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="row">
                        <div class="col-lg-2 form-control-label">
                            <label for="pesan_beranda">Pesan</label>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea name="pesan_beranda" rows="5" cols="50" class="form-control"><?= $data['pesan_beranda']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" name="ubah_pesan" class="btn btn-success  btn-sm waves-effect">Simpan</button>
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
if (isset($_POST['ubah_pesan'])) {
$id = $_POST['id'];
$pesan_beranda = $_POST['pesan_beranda'];
$koneksi->query("UPDATE tb_panitia SET pesan_beranda='$pesan_beranda' WHERE id_panitia='$id'"); ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Pesan Beranda Berhasil Diedit',
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