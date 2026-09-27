<?php
$sql = $koneksi->query("SELECT * FROM tb_user");
while ($tampil = $sql->fetch_assoc()) {
    $level = $tampil['level'];
?>
<!-- Modal -->
<div class="modal fade" id="modal_edit<?= (int)$tampil['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">EDIT DATA USER</h5>
            </div>
            <form role="form" action="#" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= (int)$tampil['id']; ?>">
                    <div class="form-group" align="center">
                        <?php
                        $foto = isset($tampil['foto']) ? safe_basename($tampil['foto']) : '';
                        if ($foto && file_exists("../assets/images/" . $foto)) {
                            echo '<img src="../assets/images/' . e($foto) . '" alt="Foto" style="height:80px;width:80px;object-fit:cover;border-radius:50%;">';
                        } else {
                            $initial = strtoupper(substr($tampil['nama'], 0, 1));
                            echo '<span style="display:inline-flex;align-items:center;justify-content:center;height:80px;width:80px;border-radius:50%;background:#e0e0e0;color:#333;font-weight:bold;font-size:28px;">' . e($initial) . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="user">Username</label>
                            <input type="text" name="user" id="user" class="form-control" value="<?= e($tampil['username']); ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pass">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Biarkan kosong jika tidak diubah" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= e($tampil['nama']); ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="level">Level</label>
                            <select class="form-control" name="level" id="level" required>
                                <option value="">- Pilih Level -</option>
                                <option value="admin" <?= ($level == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?= ($level == 'user') ? 'selected' : ''; ?>>User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="foto">Foto</label>
                            <input class="form-control" type="hidden" name="foto_lama" value="<?= e($tampil['foto'] ?? ''); ?>">
                            <input class="form-control" type="file" name="foto" accept="image/*">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <input type="submit" name="edit" class="btn btn-success waves-effect" value="Edit">
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
if (isset($_POST['edit'])) {
    csrf_verify();
    $id    = (int)($_POST['id'] ?? 0);
    $user  = trim($_POST['user'] ?? '');
    $pass  = $_POST['pass'] ?? '';
    $nama  = trim($_POST['nama'] ?? '');
    $level = $_POST['level'] ?? 'user';
    
    if (!in_array($level, ['admin', 'user'], true)) {
        $level = 'user';
    }
    
    $existing = db_one($koneksi, "SELECT * FROM tb_user WHERE id = ?", [$id]);
    if ($existing) {
        // Handle password update
        if ($pass !== '') {
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        } else {
            $pass_hash = $existing['password'];
        }
        
        $nama_foto = $existing['foto'] ?? '';
        if (!empty($_FILES['foto']['name'])) {
            $uploaded = safe_upload($_FILES['foto'], '../assets/images/', 'user');
            if ($uploaded) {
                if (!empty($nama_foto)) {
                    $old_file = safe_basename($nama_foto);
                    if (file_exists("../assets/images/" . $old_file)) {
                        @unlink("../assets/images/" . $old_file);
                    }
                }
                $nama_foto = $uploaded;
            }
        }
        
        $stmt = db_exec($koneksi, "UPDATE tb_user SET username=?, password=?, nama=?, level=?, foto=? WHERE id=?", [$user, $pass_hash, $nama, $level, $nama_foto, $id]);
        if ($stmt) {
?>
<script>
Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: '<?= e($nama); ?>',
    text: 'Berhasil Diedit',
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
}
?>
