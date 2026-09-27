<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">TAMBAH DATA JURI</h5>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nama">Nama Juri</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Juri" required autofocus>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="pangkalan">Pangkalan</label>
                            <select name="pangkalan" id="pangkalan" class="js-example-basic-single form-control show-tick" required>
                                <option value="">- Pilih Pangkalan -</option>
                                <?php
                                $peserta_list = db_all($koneksi, "SELECT * FROM tb_peserta_pa ORDER BY pangkalan ASC");
                                foreach ($peserta_list as $data) {
                                    echo '<option value="' . (int)$data['id_pa'] . '"> ' . e($data['pangkalan']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="taman">Koordinator Taman</label>
                            <select name="taman" id="taman" class="js-example-basic-single form-control show-tick" required>
                                <option value="">- Pilih Taman -</option>
                                <?php
                                $taman_list = db_all($koneksi, "SELECT * FROM tb_taman ORDER BY nama_taman ASC");
                                foreach ($taman_list as $data) {
                                    echo '<option value="' . (int)$data['id_taman'] . '"> ' . e($data['nama_taman']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="hp">No. Handphone/WA</label>
                            <input type="text" name="hp" id="hp" class="form-control" placeholder="No. Handphone/WA" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="simpan" class="btn btn-success waves-effect" value="Simpan">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_POST['simpan'])) {
    csrf_verify();
    $nama 	   = trim($_POST['nama'] ?? '');
    $pangkalan = (int)($_POST['pangkalan'] ?? 0);
    $taman 	   = (int)($_POST['taman'] ?? 0);
    $hp 	   = trim($_POST['hp'] ?? '');
    
    $stmt = db_exec($koneksi, "INSERT INTO tb_juri (nama_juri, id_pa, id_taman, no_hp) VALUES (?, ?, ?, ?)", [$nama, $pangkalan, $taman, $hp]);
    if ($stmt) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?= e($nama); ?>',
        text: 'Berhasil Ditambahkan',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=juri';
    }, 1500);
</script>
<?php
    }
}
?>
