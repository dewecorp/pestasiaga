<?php
$sql = $koneksi->query("SELECT * FROM tb_taman");
while ($data = $sql->fetch_assoc()) {
?>

<div class="modal fade" id="modal_konfirmasi<?=$data['id_taman']?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center"></h5>
            </div>

            <div class="modal-body">
                <center><img src="../assets/images/warning.png" height="100px" width="100px"></center>
                <center>
                    <h3>Apakah Anda Yakin Menghapus Data?</h3>
                </center>
                <center>
                    <h5>Data Yang Terhapus Tidak Dapat Dipulihkan Kembali</h5>
                </center>

                <div class="modal-footer">
                    <a href="?page=taman&aksi=hapus&id=<?=$data['id_taman']; ?>"><button class="btn btn-primary waves-effect">Ya, Saya Yakin</button></a>
                    <a href="?page=taman"><button class="btn btn-danger waves-effect">Tidak</button></a>

                </div>
            </div>

        </div>
    </div>
</div>
<?php 
}

 ?>
