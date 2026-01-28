<?php
// $id = @$_GET['id'];
// $sql = $koneksi->query("SELECT * FROM tb_rekap WHERE id_rekap='$id'");
if (isset($_GET['id'])) {
$id = $_GET['id'];
// $sql = $koneksi->query("SELECT * FROM tb_rekap");
// while ($data = $sql->fetch_assoc()) {
}
?>
<div class="modal fade" id="modal_input<?=$data['id_rekap']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="width:90%; height: 90%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="largeModalLabel" align="center">INPUT NILAI TAMAN BARUNG PUTRA</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" name="formD" id="formD">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Ketakwaan</th>
                                    <th>Toleransi</th>
                                    <th>Tanda Pengenal</th>
                                    <th>Rangking 1</th>
                                    <th>KIM</th>
                                    <th>Scout Skills</th>
                                    <th>LBB</th>
                                    <th>Kereta Bola</th>
                                    <th>Seni Budaya</th>
                                    <th>Bumbung Peduli</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
								$no = 1;
								$sql = $koneksi->query("SELECT * FROM tb_rekap WHERE id_rekap = '$id'");
								while ($data = $sql->fetch_assoc()) {
								$nilai_ketakwaan = $data['ketakwaan'];
								$nilai_toleransi = $data['toleransi'];
								$nilai_tanda_pengenal = $data['tanda_pengenal'];
								$nilai_rangking = $data['rangking'];
								$nilai_kim = $data['kim'];
								$nilai_scout_skill = $data['scout_skill'];
								$nilai_lbb = $data['lbb'];
								$nilai_kereta_bola = $data['kereta_bola'];
								$nilai_seni_budaya = $data['seni_budaya'];
								$nilai_bumbung = $data['bumbung'];
								$nilai_akhir_pa = $data['nilai_akhir_pa']; ?>
                                <tr>
                                    <td align="center">
                                        <input type="text" maxlength="3" min="0" max="100" class="form-control" name="ketakwaan" id="ketakwaan" onkeyup="OnChange(this.value)" style="width: 60px" value="<?= $nilai_ketakwaan ?>" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="toleransi" id="toleransi" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_toleransi ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="tanda_pengenal" id="tanda_pengenal" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_tanda_pengenal ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="rangking" id="rangking" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_rangking ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="kim" id="kim" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_kim ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="scout_skill" id="scout_skill" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_scout_skill ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="lbb" id="lbb" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_lbb ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="kereta_bola" id="kereta_bola" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_kereta_bola ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="seni_budaya" id="seni_budaya" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_seni_budaya ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" maxlength="3" class="form-control" name="bumbung" id="bumbung" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width: 60px" value="<?= $nilai_bumbung ?>">
                                    </td>
                                    <td align="center">
                                        <input type="text" class="form-control" name="txtDisplay" id="txtDisplay" style="width: 60px" value="0" readonly>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" name="id" value="<?= $id ?>" />
                                        <button type="submit" name="simpanNilai" class="btn btn-success btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="Simpan Nilai"><i class="fa fa-save"></i></button>
                                    </td>
                                </tr>
                                <?php
								}
								?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['simpanNilai'])) {
$ketakwaan = $_POST['ketakwaan'];
$toleransi = $_POST['toleransi'];
$tanda_pengenal = $_POST['tanda_pengenal'];
$rangking = $_POST['rangking'];
$kim = $_POST['kim'];
$scout_skill = $_POST['scout_skill'];
$lbb = $_POST['lbb'];
$kereta_bola = $_POST['kereta_bola'];
$seni_budaya = $_POST['seni_budaya'];
$bumbung = $_POST['bumbung'];
$total = $_POST['txtDisplay'];
$id = $_POST['id'];
$koneksi->query(
"UPDATE TB_REKAP
SET KETAKWAAN = '$ketakwaan',
TOLERANSI = '$toleransi',
TANDA_PENGENAL = '$tanda_pengenal',
RANGKING = '$rangking',
KIM = '$kim',
SCOUT_SKILL = '$scout_skill',
LBB = '$lbb',
KERETA_BOLA = '$kereta_bola',
SENI_BUDAYA = '$seni_budaya',
BUMBUNG = '$bumbung',
NILAI_AKHIR_PA = '$total'
WHERE ID_REKAP = '$id'
"
); ?>
<script>
    alert('Sukses, Input Nilai Berhasil');
    window.location.href = "?page=rekapawalputra";

</script>
<?php
}
?>
<script type="text/javascript" language="Javascript">
    // NILAI KETAKWAAN
    var ketakwaan = document.formD.ketakwaan.value;
    document.formD.txtDisplay.value = ketakwaan;
    // NILAI TOLERANS
    var toleransi = document.formD.toleransi.value;
    document.formD.txtDisplay.value = toleransi;
    // NILAI TANDA_PENGENAL
    var tanda_pengenal = document.formD.tanda_pengenal.value;
    document.formD.txtDisplay.value = tanda_pengenal;
    // NILAI RANGKING
    var rangking = document.formD.rangking.value;
    document.formD.txtDisplay.value = rangking;
    // NILAI KIM
    var kim = document.formD.kim.value;
    document.formD.txtDisplay.value = kim;
    // NILAI SCOUT SKILL
    var scout_skill = document.formD.scout_skill.value;
    document.formD.txtDisplay.value = scout_skill;
    // NILAI LBB
    var lbb = document.formD.lbb.value;
    document.formD.txtDisplay.value = lbb;
    // NILAI KERETA BOLA
    var kereta_bola = document.formD.kereta_bola.value;
    document.formD.txtDisplay.value = kereta_bola;
    // NILAI SENI BUDAYA
    var seni_budaya = document.formD.seni_budaya.value;
    document.formD.txtDisplay.value = seni_budaya;
    // NILAI BUMBUNG
    var bumbung = document.formD.bumbung.value;
    document.formD.txtDisplay.value = bumbung;

    function OnChange(value) {
        var ketakwaan = document.formD.ketakwaan.value;
        var toleransi = document.formD.toleransi.value;
        var tanda_pengenal = document.formD.tanda_pengenal.value;
        var rangking = document.formD.rangking.value;
        var kim = document.formD.kim.value;
        var scout_skill = document.formD.scout_skill.value;
        var lbb = document.formD.lbb.value;
        var kereta_bola = document.formD.kereta_bola.value;
        var seni_budaya = document.formD.seni_budaya.value;
        var bumbung = document.formD.bumbung.value;
        var total = parseInt(ketakwaan * 1) + parseInt(toleransi * 1) + parseInt(tanda_pengenal * 1) + parseInt(rangking * 1) + parseInt(kim * 1) + parseInt(scout_skill * 1) + parseInt(lbb * 1) + parseInt(kereta_bola * 1) + parseInt(seni_budaya * 1) + parseInt(bumbung * 1);
        document.formD.txtDisplay.value = total;
    }

    function hanyaAngka(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }

</script>
