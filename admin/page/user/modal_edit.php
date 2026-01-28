<?php
$sql = $koneksi->query("SELECT * FROM tb_user");
while ($tampil = $sql->fetch_assoc()) {
$level = $tampil['level']; ?>
<!-- Modal -->
<div class="modal fade" id="modal_edit<?=$tampil['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">EDIT DATA USER</h5>
            </div>
            <form role="form" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?=$tampil['id']; ?>">
                    <div class="form-group" align="center">
                        <?php
                        $foto = isset($tampil['foto']) ? $tampil['foto'] : '';
                        if ($foto) {
                            echo '<img src="../assets/images/'.$foto.'" alt="Foto" style="height:80px;width:80px;object-fit:cover;border-radius:50%;">';
                        } else {
                            $initial = strtoupper(substr($tampil['nama'],0,1));
                            echo '<span style="display:inline-flex;align-items:center;justify-content:center;height:80px;width:80px;border-radius:50%;background:#e0e0e0;color:#333;font-weight:bold;font-size:28px;">'.$initial.'</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="user">Username</label>
                            <input type="text" name="user" id="user" class="form-control"
                                value="<?=$tampil['username']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pass">Password</label>
                            <input type="text" name="pass" id="pass" class="form-control"
                                value="<?=$tampil['password']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="<?=$tampil['nama']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="level">Level</label>
                            <select class="form-control" name="level" id="level">
                                <option value="">- Pilih Level -</option>
                                <option value="admin" <?php if ($level == 'admin') {
									echo "selected";
								} ?>>Admin</option>
                                <option value="user" <?php if ($level == 'user') {
									echo "selected";
								} ?>>User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="foto">Foto</label>
                            <input class="form-control" type="hidden" name="foto_lama" value="<?= isset($tampil['foto']) ? $tampil['foto'] : '' ?>">
                            <input class="form-control" type="file" name="foto">
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
if ($_POST['edit']) {
$id   = $_POST['id'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$nama = $_POST['nama'];
$level = $_POST['level'];
$cek = $koneksi->query("SHOW COLUMNS FROM tb_user LIKE 'foto'");
if ($cek->num_rows == 0) {
    $koneksi->query("ALTER TABLE tb_user ADD foto VARCHAR(255) NOT NULL DEFAULT ''");
}
$sumber = $_FILES['foto']['tmp_name'];
$sql = null;
if (!empty($sumber)) {
    $ekstensi = explode(".", $_FILES['foto']['name']);
    $nama_foto = "user-".round(microtime(true)).".".end($ekstensi);
    $upload = move_uploaded_file($sumber, "../assets/images/".$nama_foto);
    if ($upload) {
        $foto_lama = $_POST['foto_lama'];
        if (!empty($foto_lama)) {
            @unlink("../assets/images/".$foto_lama);
        }
        $sql = $koneksi->query("UPDATE tb_user SET username='$user', password='$pass', nama='$nama', level='$level', foto='$nama_foto' WHERE id='$id'");
    } else {
        $sql = $koneksi->query("UPDATE tb_user SET username='$user', password='$pass', nama='$nama', level='$level' WHERE id='$id'");
    }
} else {
    $sql = $koneksi->query("UPDATE tb_user SET username='$user', password='$pass', nama='$nama', level='$level' WHERE id='$id'");
}
if ($sql) {
?>
<script>
Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: '<?=$nama;?>',
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
?>
