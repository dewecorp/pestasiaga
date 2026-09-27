<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">INPUT DATA USER</h5>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="user">Username</label>
                            <input type="text" name="user" id="user" class="form-control" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pass">Password</label>
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="level">Level</label>
                            <select class="form-control show-tick" name="level" id="level" required>
                                <option value="">- Pilih Level -</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="foto">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" />
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
if (isset($_POST['simpan'])) {
    csrf_verify();
    $user  = trim($_POST['user'] ?? '');
    $pass  = $_POST['pass'] ?? '';
    $nama  = trim($_POST['nama'] ?? '');
    $level = $_POST['level'] ?? '';
    
    if (!in_array($level, ['admin', 'user'], true)) {
        $level = 'user';
    }
    
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    
    $cek = $koneksi->query("SHOW COLUMNS FROM tb_user LIKE 'foto'");
    if ($cek && $cek->num_rows == 0) {
        $koneksi->query("ALTER TABLE tb_user ADD foto VARCHAR(255) NOT NULL DEFAULT ''");
    }
    
    $nama_foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $uploaded = safe_upload($_FILES['foto'], '../assets/images/', 'user');
        if ($uploaded) {
            $nama_foto = $uploaded;
        }
    }
    
    $stmt = db_exec($koneksi, "INSERT INTO tb_user (username, password, nama, level, foto) VALUES (?, ?, ?, ?, ?)", [$user, $pass_hash, $nama, $level, $nama_foto]);
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
        document.location.href = '?page=user';
    }, 1500);
</script>
<?php
    }
}
?>
