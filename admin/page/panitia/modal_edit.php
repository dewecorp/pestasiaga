<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {
?>
<!-- Modal -->
<div class="modal fade" id="modal_edit<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="row">
                        <div class="col-lg-3 form-control-label">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" value="<?= isset($data['nama_kegiatan']) ? $data['nama_kegiatan'] : '' ?>">
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
                                    <input type="text" name="kwarran" id=" kwarran" class="form-control" value="<?= $data['ka_kwarran']; ?>">
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
                                    <input type="text" name="ketua" id=" ketua" class="form-control" value="<?= $data['ketua_panitia']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 form-control-label">
                            <label for="juri">Ketua Dwan Juri</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="juri" id="juri" class="form-control" value="<?= $data['ketua_juri']; ?>">
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
if ($_POST['ganti']) {
$id = $_POST['id'];
$nama_kegiatan = $_POST['nama_kegiatan'];
$ketua = $_POST['ketua'];
$juri = $_POST['juri'];
$kwarran = $_POST['kwarran'];
$cek = $koneksi->query("SHOW COLUMNS FROM tb_panitia LIKE 'nama_kegiatan'");
if ($cek->num_rows == 0) {
$koneksi->query("ALTER TABLE tb_panitia ADD nama_kegiatan VARCHAR(255) NOT NULL DEFAULT ''");
}
$koneksi->query("UPDATE tb_panitia SET nama_kegiatan='$nama_kegiatan', ketua_panitia='$ketua', ketua_juri='$juri', ka_kwarran='$kwarran' WHERE id_panitia='$id'"); ?>
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
?>
