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
                    <!-- <div class="form-group">
                        <div class="form-line">
                            <label for="nomor">Nomor Dada</label>
                            <input type="text" name="nomor" id="nomor" class="form-control" placeholder="Nomor Dada" required autofocus />
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="form-line">
                            <label for="pangkalan">Nama Pangkalan</label>
                            <input type="text" name="pangkalan" id="pangkalan" class="form-control" placeholder="Nama Pangkalan" required autofocus />
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
    // Generate No Dada Otomatis (Genap: 02, 04, 06...)
    // Ambil nomor dada tertinggi yang valid (tidak kosong)
    $sql_max = $koneksi->query("SELECT no_dada FROM tb_peserta_pi WHERE no_dada != '' AND no_dada IS NOT NULL ORDER BY CAST(no_dada AS UNSIGNED) DESC LIMIT 1");
    $max_row = $sql_max->fetch_assoc();
    $last_no = $max_row ? (int)$max_row['no_dada'] : 0;

    if ($last_no == 0) {
        $next_no = 2;
    } else {
        if ($last_no % 2 != 0) {
            // If last was odd (error/manual input ganjil), add 1 to make it even
            $next_no = $last_no + 1;
        } else {
            // If last was even, add 2
            $next_no = $last_no + 2;
        }
    }
    $no_dada = sprintf("%02d", $next_no);

    $pangkalan = $_POST['pangkalan'];
    $pembina = $_POST['pembina'];

    $koneksi->query("INSERT INTO tb_peserta_pi (no_dada, pangkalan, pembina) VALUES ('$no_dada', '$pangkalan', '$pembina')");
    $sql = $koneksi->query("SELECT MAX(ID_PI) AS ID_MAX FROM tb_peserta_pi");
    $data = $sql->fetch_assoc();
    $id = $data['ID_MAX'];
    // Fix: Insert default values for NOT NULL columns in tb_rekap_pi to prevent fatal errors
    $insert_rekap = $koneksi->query("INSERT INTO tb_rekap_pi (id_pi, ketakwaan, toleransi, tanda_pengenal, rangking, kim, scout_skill, lbb, kereta_bola, seni_budaya, bumbung, nilai_akhir_pi) VALUES ('$id', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')");
    
    if (!$insert_rekap) {
        echo "Error creating rekap: " . $koneksi->error;
        exit;
    }
    ?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?=$pangkalan;?>',
        text: 'Berhasil Ditambahkan dengan No. Dada <?=$no_dada?>',
        showConfirmButton: true,
        timer: 3000
    }, 10);
    window.setTimeout(function() {
        document.location.href = '?page=pesertapi';
    }, 1500);

</script>
<?php
}
?>