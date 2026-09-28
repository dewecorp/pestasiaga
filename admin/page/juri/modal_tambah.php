<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">TAMBAH DATA JURI</h5>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nama">Nama Juri</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Juri" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: bold; margin-bottom: 8px; display: block;">Asal / Utusan</label>
                        <div style="display: flex; gap: 20px;">
                            <label style="font-weight: normal; cursor: pointer;">
                                <input type="radio" name="jenis_asal" value="pangkalan" id="jenis_pangkalan_add" checked class="with-gap radio-col-green" onchange="toggleAsalAdd()">
                                <span>Pangkalan (Peserta)</span>
                            </label>
                            <label style="font-weight: normal; cursor: pointer;">
                                <input type="radio" name="jenis_asal" value="instansi" id="jenis_instansi_add" class="with-gap radio-col-green" onchange="toggleAsalAdd()">
                                <span>Instansi / Lainnya</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group form-float" id="container_pangkalan_add">
                        <div class="form-line">
                            <label for="pangkalan_select_add">Pilih Pangkalan</label>
                            <select name="pangkalan_select" id="pangkalan_select_add" class="form-control show-tick">
                                <option value="">- Pilih Pangkalan -</option>
                                <?php
                                $list_pa = db_all($koneksi, "SELECT id_pa, pangkalan FROM tb_peserta_pa ORDER BY pangkalan ASC");
                                foreach ($list_pa as $d) {
                                    echo '<option value="pa_' . (int)$d['id_pa'] . '|' . e($d['pangkalan']) . '">' . e($d['pangkalan']) . ' (Putra)</option>';
                                }
                                $list_pi = db_all($koneksi, "SELECT id_pi, pangkalan FROM tb_peserta_pi ORDER BY pangkalan ASC");
                                foreach ($list_pi as $d) {
                                    echo '<option value="pi_' . (int)$d['id_pi'] . '|' . e($d['pangkalan']) . '">' . e($d['pangkalan']) . ' (Putri)</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-float" id="container_instansi_add" style="display: none;">
                        <div class="form-line">
                            <label for="instansi_input_add">Nama Instansi / Lembaga</label>
                            <input type="text" name="instansi_input" id="instansi_input_add" class="form-control" placeholder="Contoh: Kwarcab Jepara, Polsek Kedung, DKK">
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="taman">Koordinator Taman</label>
                            <select name="taman" id="taman" class="form-control show-tick" required>
                                <option value="">- Pilih Taman -</option>
                                <?php
                                $taman_list = db_all($koneksi, "SELECT * FROM tb_taman ORDER BY nama_taman ASC");
                                foreach ($taman_list as $data) {
                                    echo '<option value="' . (int)$data['id_taman'] . '"> ' . e($data['nama_taman']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="hp">No. Handphone/WA</label>
                            <input type="text" name="hp" id="hp" class="form-control" placeholder="No. Handphone/WA" required>
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

<script>
function toggleAsalAdd() {
    var isPangkalan = document.getElementById('jenis_pangkalan_add').checked;
    var cPangkalan = document.getElementById('container_pangkalan_add');
    var cInstansi = document.getElementById('container_instansi_add');
    var selectPangkalan = document.getElementById('pangkalan_select_add');
    var inputInstansi = document.getElementById('instansi_input_add');

    if (isPangkalan) {
        cPangkalan.style.display = 'block';
        cInstansi.style.display = 'none';
        selectPangkalan.required = true;
        inputInstansi.required = false;
    } else {
        cPangkalan.style.display = 'none';
        cInstansi.style.display = 'block';
        selectPangkalan.required = false;
        inputInstansi.required = true;
    }
}
document.addEventListener('DOMContentLoaded', function() {
    toggleAsalAdd();
});
</script>

<?php
if (isset($_POST['simpan'])) {
    csrf_verify();
    $nama       = trim($_POST['nama'] ?? '');
    $taman      = (int)($_POST['taman'] ?? 0);
    $hp         = trim($_POST['hp'] ?? '');
    $jenis_asal = $_POST['jenis_asal'] ?? 'pangkalan';

    $id_pa = 0;
    $pangkalan_text = '';

    if ($jenis_asal === 'pangkalan') {
        $pangkalan_raw = $_POST['pangkalan_select'] ?? '';
        if (!empty($pangkalan_raw)) {
            $parts = explode('|', $pangkalan_raw, 2);
            $prefix_id = $parts[0] ?? '';
            $pangkalan_text = $parts[1] ?? '';

            if (strpos($prefix_id, 'pa_') === 0) {
                $id_pa = (int)substr($prefix_id, 3);
            }
        }
    } else {
        $pangkalan_text = trim($_POST['instansi_input'] ?? '');
        $id_pa = 0;
    }

    $stmt = db_exec($koneksi, "INSERT INTO tb_juri (nama_juri, pangkalan, id_pa, id_taman, no_hp) VALUES (?, ?, ?, ?, ?)", [$nama, $pangkalan_text, $id_pa, $taman, $hp]);
    if ($stmt) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?= e($nama); ?>',
        text: 'Berhasil Ditambahkan',
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
