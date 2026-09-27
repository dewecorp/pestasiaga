<?php
$panitia_list = db_all($koneksi, "SELECT * FROM tb_panitia");
foreach ($panitia_list as $data) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_logo<?= (int)$data['id_panitia']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">GANTI LOGO</h5>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= (int)$data['id_panitia']; ?>">
                    <div class="col-lg-12">
                        <div class="form-group" align="center">
                            <div class="image">
                                <img src="../assets/images/<?= e(safe_basename($data['logo'])); ?>" width="200" height="200" alt="Logo" />
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input class="form-control" type="hidden" name="logo_lama" value="<?= e($data['logo']); ?>">
                            <input class="form-control" type="file" name="logo" accept="image/*">
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
    csrf_verify();
    $id = (int)($_POST['id'] ?? 0);
    
    if (empty($_FILES['logo']['name'])) {
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
        $uploaded = safe_upload($_FILES['logo'], '../assets/images/', 'logo');
        if ($uploaded) {
            $logo_lama = $_POST['logo_lama'] ?? '';
            if (!empty($logo_lama)) {
                $old_file = safe_basename($logo_lama);
                if (file_exists("../assets/images/" . $old_file)) {
                    @unlink("../assets/images/" . $old_file);
                }
            }
            db_exec($koneksi, "UPDATE tb_panitia SET logo=? WHERE id_panitia=?", [$uploaded, $id]);
            ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Logo Berhasil Diganti',
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
