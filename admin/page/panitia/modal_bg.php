<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_bg<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">GANTI BACKGROUND</h5>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="col-lg-12">
                        <div class="form-group" align="center">
                            <div class="image">
                                <img src="../assets/images/<?=$data['bg']; ?>" width="400" height="200" alt="Background" />
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input class="form-control" type="hidden" name="bg_lama" value="<?=$data['bg']; ?>">
                            <input class="form-control" type="file" name="bg">
                            <span>
                                <font color="red"><i>*Abaikan Jika Background Tidak Diganti</i></font>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <input type="submit" name="edit" class="btn btn-success waves-effect" value="Simpan">
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
if ($_POST['edit']) {
$id         = $_POST['id'];
$sumber     = $_FILES['bg']['tmp_name'];
$ekstensi   = explode(".", $_FILES['bg']['name']);
$nama_bg    = "bg-".round(microtime(true)).".".end($ekstensi);
$upload     = move_uploaded_file($sumber, "../assets/images/".$nama_bg);
if ($upload) {
$koneksi->query("UPDATE tb_panitia SET bg='$nama_bg' WHERE id_panitia='$id'");
$bg_lama    = $_POST['bg_lama'];
unlink("../assets/images/".$bg_lama); ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Background Berhasil Diganti',
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
        text: 'Gagal Mengganti Background',
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
