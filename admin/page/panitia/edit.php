<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_panitia WHERE id_panitia='$id'");
$data = $sql->fetch_assoc();
?>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        EDIT DATA KEGIATAN
                    </h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-6 col-sm-offset-3">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="nama_kegiatan">Nama Kegiatan</label>
                                        <input type="hidden" name="id" value="<?=$data['id_panitia'];?>">
                                        <input type="text" name="nama_kegiatan" value="<?= isset($data['nama_kegiatan']) ? $data['nama_kegiatan'] : '' ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="ketua">Ketua Panitia</label>
                                        <input type="text" name="ketua" value="<?=$data['ketua_panitia']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="juri">Ketua Dewan Juri</label>
                                        <input type="text" name="juri" value="<?=$data['ketua_juri']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="kwarran">Ketua Kwartir</label>
                                        <input type="text" name="kwarran" value="<?=$data['ka_kwarran']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="image">
                                        <img src="assets/images/<?=$data['logo']; ?>" width="100" height="100" alt="Logo" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="logo_lama" value="<?=$data['logo']; ?>">
                                    <input class="form-control" type="file" name="logo">
                                    <span>
                                        <font color="red"><i>*Abaikan Jika Logo Tidak Diganti</i></font>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="edit" class="btn btn-success waves-effect" value="Simpan">
                                    <a href="?page=panitia" class="btn btn-danger waves-effect">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($_POST['edit']) {
    $ketua = $_POST['ketua'];
    $juri = $_POST['juri'];
    $kwarran = $_POST['kwarran'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $cek = $koneksi->query("SHOW COLUMNS FROM tb_panitia LIKE 'nama_kegiatan'");
    if ($cek->num_rows == 0) {
    $koneksi->query("ALTER TABLE tb_panitia ADD nama_kegiatan VARCHAR(255) NOT NULL DEFAULT ''");
    }
    $sumber = $_FILES['logo']['tmp_name'];
    $ekstensi = explode(".", $_FILES['logo']['name']);
    $nama_logo = "logo-".round(microtime(true)).".".end($ekstensi);
    $upload = move_uploaded_file($sumber, "assets/images/".$nama_logo);
    if ($upload) {
    $koneksi->query("UPDATE tb_panitia SET nama_kegiatan='$nama_kegiatan', logo='$nama_logo' WHERE id_panitia='$id'");
    $logo_lama = $_POST['logo_lama'];
    unlink("assets/images/".$logo_lama); ?>
    <script>
        alert('Data Giat Berhasil Diedit');
        window.location.href = "?page=panitia";

    </script>
    <?php
    } else {
    if ($sumber == "") {
    $koneksi->query("UPDATE tb_panitia SET nama_kegiatan='$nama_kegiatan', ketua_panitia='$ketua', ketua_juri='$juri', ka_kwarran='$kwarran' WHERE id_panitia='$id'"); ?>
    <script>
        alert('Data Giat Berhasil Diedit');
        window.location.href = "?page=panitia";

    </script>
    <?php
    } else {
    ?>
    <script type="text/javascript">
        alert("Gagal Mengganti Logo");

    </script>
    <?php
    }
    }
    }
    ?>
