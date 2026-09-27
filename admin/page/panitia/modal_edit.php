<?php
$panitia_list = db_all($koneksi, "SELECT * FROM tb_panitia");
foreach ($panitia_list as $data) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_edit<?= (int)$data['id_panitia']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">EDIT DATA KEGIATAN</h5>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int)$data['id_panitia']; ?>">
                    <div class="row">
                        <div class="col-lg-3 form-control-label">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" value="<?= e($data['nama_kegiatan'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 form-control-label">
                            <label for="kwarran">Ketua Kwartir</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="kwarran" id="kwarran" class="form-control" value="<?= e($data['ka_kwarran'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 form-control-label">
                            <label for="ketua">Ketua Panitia</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="ketua" id="ketua" class="form-control" value="<?= e($data['ketua_panitia'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 form-control-label">
                            <label for="juri">Ketua Dewan Juri</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="juri" id="juri" class="form-control" value="<?= e($data['ketua_juri'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <input type="submit" name="ganti" class="btn btn-success waves-effect" value="Simpan">
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
if (isset($_POST['ganti'])) {
    csrf_verify();
    $id = (int)($_POST['id'] ?? 0);
    $nama_kegiatan = trim($_POST['nama_kegiatan'] ?? '');
    $ketua = trim($_POST['ketua'] ?? '');
    $juri = trim($_POST['juri'] ?? '');
    $kwarran = trim($_POST['kwarran'] ?? '');

    $stmt = db_exec($koneksi, "UPDATE tb_panitia SET nama_kegiatan=?, ketua_panitia=?, ketua_juri=?, ka_kwarran=? WHERE id_panitia=?", [$nama_kegiatan, $ketua, $juri, $kwarran, $id]);
    if ($stmt) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Data Giat Berhasil Diedit',
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
