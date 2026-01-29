<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_logo<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">GANTI LOGO</h5>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="col-lg-12">
                        <div class="form-group" align="center">
                            <div class="image">
                                <img src="../assets/images/<?=$data['logo']; ?>" width="200" height="200" alt="Logo" />
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input class="form-control" type="hidden" name="logo_lama" value="<?=$data['logo']; ?>">
                            <input class="form-control" type="file" name="logo">
                            <span>
                                <font color="red"><i>*Abaikan Jika Logo Tidak Diganti</i></font>
                            </span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <input type="submit" name="simpan" class="btn btn-success waves-effect" value="Simpan">
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
if (isset($_POST['simpan'])) {
$id = mysqli_real_escape_string($koneksi, $_POST['id']);
$sumber = $_FILES['logo']['tmp_name'];
$original_name = $_FILES['logo']['name'];
$ekstensi = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
$allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

if (!in_array($ekstensi, $allowed_ext)) {
    echo "<script>Swal.fire('Error', 'Format file tidak diizinkan. Gunakan JPG, JPEG, atau PNG.', 'error');</script>";
} else {
    $nama_logo = "logo-".round(microtime(true)).".".$ekstensi;
    $upload = move_uploaded_file($sumber, "../assets/images/".$nama_logo);
    if ($upload) {
        $koneksi->query("UPDATE tb_panitia SET logo='$nama_logo' WHERE id_panitia='$id'");
        $logo_lama = $_POST['logo_lama'];
        if (file_exists("../assets/images/".$logo_lama)) {
            unlink("../assets/images/".$logo_lama); 
        } ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Logo Berhasil Diganti',
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
        text: 'Gagal Mengganti Logo',
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
}
?>
