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
            <form role="form" action="#" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?=$tampil['id']; ?>">
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
$sql = $koneksi->query("UPDATE tb_user SET username='$user', password='$pass', nama='$nama', level='$level' WHERE id='$id'");
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