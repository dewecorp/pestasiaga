<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">TAMBAH PESERTA PUTRI</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nomor">Nomor Dada</label>
                            <input type="text" name="nomor" id="nomor" class="form-control" placeholder="Nomor Dada" required autofocus />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pangkalan">Nama Pangkalan</label>
                            <input type="text" name="pangkalan" id="pangkalan" class="form-control" placeholder="Nama Pangkalan" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pembina">Nama Pembina</label>
                            <input type="text" name="pembina" id="pembina" class="form-control" placeholder="Nama Pembina" required />
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
$no_dada   = $_POST['nomor'];
$pangkalan = $_POST['pangkalan'];
$pembina   = $_POST['pembina'];
$sql = $koneksi->query("SELECT * FROM TB_PESERTA_PI WHERE NO_DADA ='$no_dada'");
$tampil = $sql->fetch_assoc();
if ($tampil > 0) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'No Dada Sudah Pernah Diinput',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=pesertapi';
    }, 1500);

</script>
<?php
} else {
$koneksi->query("INSERT INTO tb_peserta_pi (no_dada, pangkalan, pembina) VALUES ('$no_dada', '$pangkalan', '$pembina')");
$sql = $koneksi->query("SELECT MAX(ID_PI) AS ID_MAX FROM TB_PESERTA_PI");
$data = $sql->fetch_assoc();
$id = $data['ID_MAX'];
$koneksi->query("INSERT INTO tb_rekap (id_pi) VALUES ('$id')"); ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?=$pangkalan;?>',
        text: 'Berhasil Ditambahkan',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=pesertapi';
    }, 1500);

</script>
<?php
}
}
?>
