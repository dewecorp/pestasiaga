<?php
if (isset($_POST['edit'])) {
    csrf_verify();
    $id     = (int)($_POST['id'] ?? 0);
    $taman  = trim($_POST['taman'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');
    
    $stmt = db_exec($koneksi, "UPDATE tb_taman SET nama_taman=?, lokasi=? WHERE id_taman=?", [$taman, $lokasi, $id]);
    if ($stmt) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?= e($taman); ?>',
        text: 'Berhasil Diedit',
        showConfirmButton: true,
        timer: 3000
    });
    window.setTimeout(function() {
        document.location.href = '?page=taman';
    }, 1500);
</script>
<?php
    }
}

$taman_all = db_all($koneksi, "SELECT * FROM tb_taman");
foreach ($taman_all as $tampil) {
?>
<div class="modal fade" id="modal_edit<?= (int)$tampil['id_taman']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">EDIT DATA TAMAN</h5>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="hidden" name="id" value="<?= (int)$tampil['id_taman']; ?>">
                            <label for="taman">Nama Taman</label>
                            <input type="text" name="taman" id="taman" value="<?= e($tampil['nama_taman']); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" value="<?= e($tampil['lokasi']); ?>" class="form-control" required>
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
}
?>
