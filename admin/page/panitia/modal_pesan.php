<?php
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {

?>
<!-- Modal -->
<div class="modal fade" id="modal_pesan<?= $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" align="center">EDIT PESAN & STATUS HOME</h5>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $data['id_panitia']; ?>">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <label for="status_home">Status Home</label>
                            <div class="form-group">
                                <div class="demo-radio-button">
                                    <input name="status_home" type="radio" id="radio_buka_<?= $data['id_panitia']; ?>" value="Buka" class="with-gap radio-col-green" <?= $data['status_home'] == 'Buka' ? 'checked' : '' ?> />
                                    <label for="radio_buka_<?= $data['id_panitia']; ?>">Buka (Kegiatan Berjalan)</label>

                                    <input name="status_home" type="radio" id="radio_tutup_<?= $data['id_panitia']; ?>" value="Tutup" class="with-gap radio-col-red" <?= $data['status_home'] == 'Tutup' ? 'checked' : '' ?> />
                                    <label for="radio_tutup_<?= $data['id_panitia']; ?>">Tutup (Kegiatan Selesai)</label>
                                </div>
                                <small class="text-danger">* Pilih status home. Jika "Tutup", maka Pesan Tutup akan ditampilkan.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <label for="info_image">Gambar Informasi Terkini</label>
                            <div class="form-group">
                                <?php if (!empty($data['info_image'])): ?>
                                    <div class="image" style="margin-bottom: 10px;">
                                        <img src="../assets/images/<?=$data['info_image']; ?>" width="200" alt="Info Image" class="img-thumbnail" />
                                    </div>
                                <?php endif; ?>
                                <div class="form-line">
                                    <input type="file" name="info_image" class="form-control">
                                    <input type="hidden" name="info_image_lama" value="<?=$data['info_image']; ?>">
                                </div>
                                <small class="text-info">* Format gambar: JPG, PNG, GIF. Biarkan kosong jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <label for="pesan_beranda">Pesan Beranda</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea name="pesan_beranda" id="ckeditor_beranda" rows="5" class="form-control ckeditor"><?= $data['pesan_beranda']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <label for="tutup_image">Gambar Pengumuman Tutup</label>
                            <div class="form-group">
                                <?php if (!empty($data['tutup_image'])): ?>
                                    <div class="image" style="margin-bottom: 10px;">
                                        <img src="../assets/images/<?=$data['tutup_image']; ?>" width="200" alt="Tutup Image" class="img-thumbnail" />
                                    </div>
                                <?php endif; ?>
                                <div class="form-line">
                                    <input type="file" name="tutup_image" class="form-control">
                                    <input type="hidden" name="tutup_image_lama" value="<?=$data['tutup_image']; ?>">
                                </div>
                                <small class="text-info">* Format gambar: JPG, PNG, GIF. Biarkan kosong jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <label for="pesan_tutup">Pesan Tutup</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea name="pesan_tutup" id="ckeditor_tutup" rows="5" class="form-control ckeditor"><?= $data['pesan_tutup']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" name="ubah_pesan" class="btn btn-success waves-effect">Simpan</button>
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
if (isset($_POST['ubah_pesan'])) {
    $id = $_POST['id'];
    $pesan_beranda = $_POST['pesan_beranda'];
    $pesan_tutup = $_POST['pesan_tutup'];
    $status_home = $_POST['status_home'];
    
    $info_image_lama = $_POST['info_image_lama'];
    $nama_image = $info_image_lama;

    if (!empty($_FILES['info_image']['name'])) {
        $sumber     = $_FILES['info_image']['tmp_name'];
        $ekstensi   = explode(".", $_FILES['info_image']['name']);
        $nama_image = "info-".round(microtime(true)).".".end($ekstensi);
        $upload     = move_uploaded_file($sumber, "../assets/images/".$nama_image);
        if ($upload) {
            if (!empty($info_image_lama) && file_exists("../assets/images/".$info_image_lama)) {
                unlink("../assets/images/".$info_image_lama);
            }
        } else {
            $nama_image = $info_image_lama;
        }
    }
    
    $tutup_image_lama = $_POST['tutup_image_lama'];
    $nama_image_tutup = $tutup_image_lama;

    if (!empty($_FILES['tutup_image']['name'])) {
        $sumber_tutup   = $_FILES['tutup_image']['tmp_name'];
        $ekstensi_tutup = explode(".", $_FILES['tutup_image']['name']);
        $nama_image_tutup = "tutup-".round(microtime(true)).".".end($ekstensi_tutup);
        $upload_tutup   = move_uploaded_file($sumber_tutup, "../assets/images/".$nama_image_tutup);
        if ($upload_tutup) {
            if (!empty($tutup_image_lama) && file_exists("../assets/images/".$tutup_image_lama)) {
                unlink("../assets/images/".$tutup_image_lama);
            }
        } else {
            $nama_image_tutup = $tutup_image_lama;
        }
    }

    $stmt = $koneksi->prepare("UPDATE tb_panitia SET pesan_beranda=?, pesan_tutup=?, status_home=?, info_image=?, tutup_image=? WHERE id_panitia=?");
    $stmt->bind_param("sssssi", $pesan_beranda, $pesan_tutup, $status_home, $nama_image, $nama_image_tutup, $id);
    
    if ($stmt->execute()) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Sukses',
        text: 'Pesan & Status Berhasil Diupdate',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=panitia';
    }, 1500);

</script>
<?php
    } else {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'Gagal',
        text: 'Terjadi kesalahan saat menyimpan data',
        showConfirmButton: true,
        timer: 3000
    }, 10);
</script>
<?php
    }
}
?>