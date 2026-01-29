<?php
if (isset($_POST['reset_pi'])) {
    $koneksi->query("SET FOREIGN_KEY_CHECKS = 0");
    $reset_pi = $koneksi->query("TRUNCATE TABLE tb_peserta_pi");
    $reset_rekap_pi = $koneksi->query("TRUNCATE TABLE tb_rekap_pi");
    $koneksi->query("SET FOREIGN_KEY_CHECKS = 1");

    if ($reset_pi && $reset_rekap_pi) {
        ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Sukses',
                text: 'Data peserta putri dan rekap nilai berhasil dihapus!',
                showConfirmButton: true,
                timer: 3000
            });
            window.setTimeout(function() {
                window.location.href = '?page=pesertapi';
            }, 3000);
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal mereset data: <?= $koneksi->error ?>',
                showConfirmButton: true
            });
        </script>
        <?php
    }
}
?>

<div class="modal fade" id="modal_reset_pi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">RESET DATA PESERTA PUTRI</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="material-icons" style="float: left; margin-right: 10px;">warning</i>
                    <strong>PERHATIAN!</strong><br>
                    Anda akan menghapus <b>SELURUH</b> data peserta Barung Putri.<br>
                    - Data Peserta akan hilang.<br>
                    - Data Nilai/Rekap akan hilang.<br>
                    - Nomor Dada akan direset kembali ke 02.<br>
                    <br>
                    Tindakan ini <b>TIDAK DAPAT DIBATALKAN</b>.
                </div>
            </div>
            <div class="modal-footer">
                <form method="post">
                    <button type="submit" name="reset_pi" class="btn btn-danger waves-effect">YA, RESET SEKARANG</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
                </form>
            </div>
        </div>
    </div>
</div>
