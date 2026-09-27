<?php
$peserta_pa_all = db_all($koneksi, "SELECT * FROM tb_peserta_pa");
foreach ($peserta_pa_all as $data) {
?>
<div class="modal fade" id="modal_edit<?= (int)$data['id_pa']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">EDIT PESERTA PUTRA</h5>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= (int)$data['id_pa']; ?>">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pangkalan">Nama Pangkalan</label>
                            <input type="text" name="pangkalan" id="pangkalan" class="form-control" placeholder="Nama Pangkalan" value="<?= e($data['pangkalan']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pembina">Nama Pembina</label>
                            <input type="text" name="pembina" id="pembina" class="form-control" placeholder="Nama Pembina" value="<?= e($data['pembina']); ?>" required>
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
<?php
if (isset($_POST['edit'])) {
    csrf_verify();
    $id        = (int)($_POST['id'] ?? 0);
    $pangkalan = trim($_POST['pangkalan'] ?? '');
    $pembina   = trim($_POST['pembina'] ?? '');
    
    $stmt = db_exec($koneksi, "UPDATE tb_peserta_pa SET pangkalan=?, pembina=? WHERE id_pa=?", [$pangkalan, $pembina, $id]);
    if ($stmt) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?= e($pangkalan); ?>',
        text: 'Berhasil Diedit',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=pesertapa';
    }, 1500);
</script>
<?php
    }
}
?>
