<?php
$juri_list = db_all($koneksi, "SELECT * FROM tb_juri ORDER BY id_juri ASC");
$peserta_pa_all = db_all($koneksi, "SELECT * FROM tb_peserta_pa ORDER BY pangkalan ASC");
$peserta_pi_all = db_all($koneksi, "SELECT * FROM tb_peserta_pi ORDER BY pangkalan ASC");
$taman_all = db_all($koneksi, "SELECT * FROM tb_taman ORDER BY nama_taman ASC");

// Build a lookup map of pangkalan names from peserta
$pangkalan_names = [];
foreach ($peserta_pa_all as $p) {
    $pangkalan_names[strtolower(trim($p['pangkalan']))] = true;
}
foreach ($peserta_pi_all as $p) {
    $pangkalan_names[strtolower(trim($p['pangkalan']))] = true;
}

foreach ($juri_list as $data) {
    $juri_id = (int)$data['id_juri'];
    $current_pangkalan_text = trim($data['pangkalan'] ?? '');
    
    // Determine if current entry is pangkalan or instansi
    $is_pangkalan = ($data['id_pa'] > 0 || isset($pangkalan_names[strtolower($current_pangkalan_text)]));
?>
<div class="modal fade" id="modal_edit<?= $juri_id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="largeModalLabel" align="center">EDIT DATA JURI</h5>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="nama_edit_<?= $juri_id; ?>">Nama Juri</label>
                            <input type="hidden" name="id" value="<?= $juri_id; ?>">
                            <input type="text" name="nama" id="nama_edit_<?= $juri_id; ?>" class="form-control" value="<?= e($data['nama_juri']); ?>" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: bold; margin-bottom: 8px; display: block;">Asal / Utusan</label>
                        <div style="display: flex; gap: 20px;">
                            <label style="font-weight: normal; cursor: pointer;">
                                <input type="radio" name="jenis_asal" value="pangkalan" id="jenis_pangkalan_edit_<?= $juri_id; ?>" <?= $is_pangkalan ? 'checked' : '' ?> class="with-gap radio-col-green" onchange="toggleAsalEdit(<?= $juri_id; ?>)">
                                <span>Pangkalan (Peserta)</span>
                            </label>
                            <label style="font-weight: normal; cursor: pointer;">
                                <input type="radio" name="jenis_asal" value="instansi" id="jenis_instansi_edit_<?= $juri_id; ?>" <?= !$is_pangkalan ? 'checked' : '' ?> class="with-gap radio-col-green" onchange="toggleAsalEdit(<?= $juri_id; ?>)">
                                <span>Instansi / Lainnya</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="container_pangkalan_edit_<?= $juri_id; ?>" style="<?= $is_pangkalan ? '' : 'display: none;' ?>">
                        <div class="form-line">
                            <label for="pangkalan_select_edit_<?= $juri_id; ?>">Pilih Pangkalan</label>
                            <select name="pangkalan_select" id="pangkalan_select_edit_<?= $juri_id; ?>" class="form-control">
                                <option value="">- Pilih Pangkalan -</option>
                                <?php
                                foreach ($peserta_pa_all as $tampil) {
                                    $val = 'pa_' . (int)$tampil['id_pa'] . '|' . e($tampil['pangkalan']);
                                    $selected = ($data['id_pa'] == $tampil['id_pa'] || strtolower($current_pangkalan_text) == strtolower(trim($tampil['pangkalan']))) ? 'selected' : '';
                                    echo "<option value='" . $val . "' $selected>" . e($tampil['pangkalan']) . " (Putra)</option>";
                                }
                                foreach ($peserta_pi_all as $tampil) {
                                    $val = 'pi_' . (int)$tampil['id_pi'] . '|' . e($tampil['pangkalan']);
                                    $selected = (strtolower($current_pangkalan_text) == strtolower(trim($tampil['pangkalan']))) ? 'selected' : '';
                                    echo "<option value='" . $val . "' $selected>" . e($tampil['pangkalan']) . " (Putri)</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="container_instansi_edit_<?= $juri_id; ?>" style="<?= !$is_pangkalan ? '' : 'display: none;' ?>">
                        <div class="form-line">
                            <label for="instansi_input_edit_<?= $juri_id; ?>">Nama Instansi / Lembaga</label>
                            <input type="text" name="instansi_input" id="instansi_input_edit_<?= $juri_id; ?>" class="form-control" value="<?= e($current_pangkalan_text); ?>" placeholder="Contoh: Kwarcab Jepara, Polsek Kedung, DKK">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label for="taman_edit_<?= $juri_id; ?>">Koordinator Taman</label>
                            <select class="form-control" name="taman" id="taman_edit_<?= $juri_id; ?>" required>
                                <?php
                                foreach ($taman_all as $tampil) {
                                    $selected = ($data['id_taman'] == $tampil['id_taman']) ? 'selected' : '';
                                    echo "<option value='" . (int)$tampil['id_taman'] . "' $selected>" . e($tampil['nama_taman']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="hp_edit_<?= $juri_id; ?>">No. Handphone/WA</label>
                            <input type="text" name="hp" id="hp_edit_<?= $juri_id; ?>" class="form-control" value="<?= e($data['no_hp']); ?>" required />
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
}
?>

<script>
function toggleAsalEdit(juriId) {
    var isPangkalan = document.getElementById('jenis_pangkalan_edit_' + juriId).checked;
    var cPangkalan = document.getElementById('container_pangkalan_edit_' + juriId);
    var cInstansi = document.getElementById('container_instansi_edit_' + juriId);

    if (isPangkalan) {
        cPangkalan.style.display = 'block';
        cInstansi.style.display = 'none';
    } else {
        cPangkalan.style.display = 'none';
        cInstansi.style.display = 'block';
    }
}
</script>

<?php
if (isset($_POST['edit'])) {
    csrf_verify();
    $id         = (int)($_POST['id'] ?? 0);
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

    $stmt = db_exec($koneksi, "UPDATE tb_juri SET nama_juri=?, pangkalan=?, id_pa=?, id_taman=?, no_hp=? WHERE id_juri=?", [$nama, $pangkalan_text, $id_pa, $taman, $hp, $id]);
    if ($stmt) {
?>
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<?= e($nama); ?>',
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
