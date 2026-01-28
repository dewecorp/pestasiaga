<?php
$sql = $koneksi->query("SELECT * FROM tb_taman");
while ($tampil = $sql->fetch_assoc()) {
?>
<div class="modal fade" id="modal_edit<?=$tampil['id_taman']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">EDIT DATA TAMAN</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="hidden" name="id" value="<?=$tampil['id_taman']; ?>">
                            <label for="taman">Nama Taman</label>
                            <input type="text" name="taman" id="taman" value="<?=$tampil['nama_taman']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" value="<?=$tampil['lokasi']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="edit" class="btn btn-success waves-effect" value="Edit">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if ($_POST['edit']) {
$id    = $_POST['id'];
$taman = $_POST['taman'];
$lokasi = $_POST['lokasi'];
$koneksi->query("UPDATE tb_taman SET nama_taman='$taman', lokasi='$lokasi' WHERE id_taman='$id'"); ?>

<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?=$taman; ?>',
        text: 'Berhasil Diedit',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=taman';
    }, 1500);

</script>

<?php
}
}
?>
