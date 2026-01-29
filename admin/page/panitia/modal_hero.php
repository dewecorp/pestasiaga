<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_hero<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">GANTI HERO IMAGE</h5>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="col-lg-12">
                        <div class="form-group" align="center">
                            <div class="image">
                                <?php if (!empty($data['hero_image'])): ?>
                                    <img src="../assets/images/<?=$data['hero_image']; ?>" width="400" height="200" alt="Hero Image" />
                                <?php else: ?>
                                    <p>Belum ada hero image</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input class="form-control" type="hidden" name="hero_lama" value="<?=$data['hero_image']; ?>">
                            <input class="form-control" type="file" name="hero_image">
                            <span>
                                <font color="red"><i>*Abaikan Jika Hero Image Tidak Diganti</i></font>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <input type="submit" name="edit_hero" class="btn btn-success waves-effect" value="Simpan">
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
if (isset($_POST['edit_hero'])) {
    $id         = mysqli_real_escape_string($koneksi, $_POST['id']);
    $sumber     = $_FILES['hero_image']['tmp_name'];
    $original_name = $_FILES['hero_image']['name'];
    $ekstensi   = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    
    if (!in_array($ekstensi, $allowed_ext)) {
        echo "<script>Swal.fire('Error', 'Format file tidak diizinkan. Gunakan JPG, JPEG, atau PNG.', 'error');</script>";
    } else {
        $nama_hero  = "hero-".round(microtime(true)).".".$ekstensi;
        $upload     = move_uploaded_file($sumber, "../assets/images/".$nama_hero);
        if ($upload) {
            $koneksi->query("UPDATE tb_panitia SET hero_image='$nama_hero' WHERE id_panitia='$id'");
        $hero_lama  = $_POST['hero_lama'];
        if (!empty($hero_lama) && file_exists("../assets/images/".$hero_lama)) {
            unlink("../assets/images/".$hero_lama);
        }
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Hero Image Berhasil Diganti',
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
        text: 'Gagal Mengganti Hero Image',
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