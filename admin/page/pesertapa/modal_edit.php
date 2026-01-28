<?php
$sql = $koneksi->query("SELECT * FROM tb_peserta_pa");
while ($data = $sql->fetch_assoc()) {
?>
<div class="modal fade" id="modal_edit<?=$data['id_pa'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">EDIT PESERTA PUTRA</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nomor">Nomor Dada</label>
                            <input type="hidden" name="id" value="<?=$data['id_pa'] ?>">
                            <input type="text" name="nomor" id="nomor" class="form-control" placeholder="Nomor Dada" value="<?=$data['no_dada'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pangkalan">Nama Pangkalan</label>
                            <input type="text" name="pangkalan" id="pangkalan" class="form-control" placeholder="Nama Pangkalan" value="<?=$data['pangkalan'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pembina">Nama Pembina</label>
                            <input type="text" name="pembina" id="pembina" class="form-control" placeholder="Nama Pembina" value="<?=$data['pembina'] ?>">
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
$id        = @$_POST['id'];
$no_dada   = @$_POST['nomor'];
$pangkalan = @$_POST['pangkalan'];
$pembina   = @$_POST['pembina'];
$edit   = @$_POST['edit'];
if ($edit) {
$koneksi->query("UPDATE tb_peserta_pa SET no_dada='$no_dada', pangkalan='$pangkalan', pembina='$pembina' WHERE id_pa='$id'");

?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?=$pangkalan;?>',
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
