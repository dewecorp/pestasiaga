<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_denah<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">GANTI DENAH LOKASI</h5>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="col-lg-12">
                        <div class="form-group" align="center">
                            <div class="image">
                                <?php if (!empty($data['denah_lokasi'])): ?>
                                    <img src="../assets/images/<?=$data['denah_lokasi']; ?>" width="400" height="200" alt="Denah Lokasi" />
                                <?php else: ?>
                                    <p>Belum ada denah lokasi</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input class="form-control" type="hidden" name="denah_lama" value="<?=$data['denah_lokasi']; ?>">
                            <input class="form-control" type="file" name="denah_lokasi">
                            <span>
                                <font color="red"><i>*Abaikan Jika Denah Lokasi Tidak Diganti</i></font>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <input type="submit" name="edit_denah" class="btn btn-success waves-effect" value="Simpan">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<?php
if (isset($_POST['edit_denah'])) {
    $id         = $_POST['id'];
    $sumber     = $_FILES['denah_lokasi']['tmp_name'];
    $ekstensi   = explode(".", $_FILES['denah_lokasi']['name']);
    $nama_denah = "denah-".round(microtime(true)).".".end($ekstensi);
    $upload     = move_uploaded_file($sumber, "../assets/images/".$nama_denah);
    if ($upload) {
        $koneksi->query("UPDATE tb_panitia SET denah_lokasi='$nama_denah' WHERE id_panitia='$id'");
        $denah_lama = $_POST['denah_lama'];
        if (!empty($denah_lama) && file_exists("../assets/images/".$denah_lama)) {
            unlink("../assets/images/".$denah_lama);
        }
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Denah Lokasi Berhasil Diganti',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);

</script>
<?php
    } else {
?>
<script type="text/javascript">
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'Mohon Maaf',
        text: 'Gagal Mengganti Denah Lokasi',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);

</script>
<?php
    }
}
?>