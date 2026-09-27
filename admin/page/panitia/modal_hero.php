<?php
$panitia_list = db_all($koneksi, "SELECT * FROM tb_panitia");
foreach ($panitia_list as $data) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_hero<?= (int)$data['id_panitia']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int)$data['id_panitia']; ?>">
                    <div class="col-lg-12">
                        <div class="form-group" align="center">
                            <div class="image">
                                <?php if (!empty($data['hero_image'])): ?>
                                    <img src="../assets/images/<?= e(safe_basename($data['hero_image'])); ?>" width="400" height="200" alt="Hero Image" />
                                <?php else: ?>
                                    <p>Belum ada hero image</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input class="form-control" type="hidden" name="hero_lama" value="<?= e($data['hero_image']); ?>">
                            <input class="form-control" type="file" name="hero_image" accept="image/*">
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
    csrf_verify();
    $id = (int)($_POST['id'] ?? 0);
    
    if (empty($_FILES['hero_image']['name'])) {
        ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Data Berhasil Disimpan',
        showConfirmButton: true,
        timer: 3000
    });
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);
</script>
<?php
    } else {
        $uploaded = safe_upload($_FILES['hero_image'], '../assets/images/', 'hero');
        if ($uploaded) {
            $hero_lama = $_POST['hero_lama'] ?? '';
            if (!empty($hero_lama)) {
                $old_file = safe_basename($hero_lama);
                if (file_exists("../assets/images/" . $old_file)) {
                    @unlink("../assets/images/" . $old_file);
                }
            }
            db_exec($koneksi, "UPDATE tb_panitia SET hero_image=? WHERE id_panitia=?", [$uploaded, $id]);
            ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Hero Image Berhasil Diganti',
        showConfirmButton: true,
        timer: 3000
    });
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);
</script>
<?php
        } else {
            ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'Mohon Maaf',
        text: 'Format file tidak diizinkan. Gunakan JPG, JPEG, PNG, atau GIF.',
        showConfirmButton: true,
        timer: 3000
    });
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);
</script>
<?php
        }
    }
}
?>
