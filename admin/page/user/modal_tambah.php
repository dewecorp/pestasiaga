<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">INPUT DATA USER</h5>
            </div>

            <form action="#" method="POST">
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
                            <input type="text" name="pass" id="pass" class="form-control" placeholder="Password" required />
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
if (@$_POST['simpan']) {
    $user  = @$_POST['user'];
    $pass  = @$_POST['pass'];
    $nama  = @$_POST['nama'];
    $level = @$_POST['level'];
    $sql = $koneksi->query("INSERT INTO tb_user (username, password, nama, level) VALUES ('$user', '$pass', '$nama', '$level')");
    if ($sql) {
        ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?=$nama; ?> ',
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
