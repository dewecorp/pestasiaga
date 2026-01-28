<?php
$sql = $koneksi->query("SELECT * FROM tb_juri");
while ($data = $sql->fetch_assoc()) {
?>
<div class="modal fade" id="modal_edit<?=$data['id_juri']?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">EDIT DATA JURI</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nama">Nama Juri</label>
                            <input type="hidden" name="id" value="<?=$data['id_juri']?>">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?=$data['nama_juri'];?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pangkalan">Pangkalan</label>
                            <select class="js-example-basic-single form-control" name="pangkalan" id="pangkalan">
                                <?php
								$query = $koneksi->query("SELECT * FROM tb_peserta_pa") or die($koneksi->error);
								while ($tampil = $query->fetch_assoc()) {
								echo "<option value='$tampil[id_pa]'";
										if ($data['id_pa'] == $tampil['id_pa']) {
										echo "selected";
															}
								echo "> $tampil[pangkalan]</option>";
								}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="taman">Koordinator Taman</label>
                            <select class="js-example-basic-single form-control" name="taman" id="taman">
                                <?php
								$query = $koneksi->query("SELECT * FROM tb_taman") or die($koneksi->error);
								while ($tampil = $query->fetch_assoc()) {
								echo "<option value='$tampil[id_taman]'";
										if ($data['id_taman'] == $tampil['id_taman']) {
										echo "selected";
															}
								echo "> $tampil[nama_taman]</option>";
								}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="hp">No. Handphone/WA</label>
                            <input type="number" name="hp" id="hp" class="form-control" value="<?=$data['no_hp'];?>" />
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
if($_POST['edit']){
$id         = $_POST['id'];
$nama 	  	= $_POST['nama'];
$pangkalan  = $_POST['pangkalan'];
$taman 	  	= $_POST['taman'];
$hp 	    = $_POST['hp'];
$koneksi->query("UPDATE tb_juri SET nama_juri='$nama', id_pa='$pangkalan', id_taman='$taman', no_hp='$hp' WHERE id_juri='$id'");
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
        document.location.href = '?page=juri';
    }, 1500);

</script>

<?php
}
}
?>
