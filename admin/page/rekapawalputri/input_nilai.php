<?php
// $id = @$_GET['id'];
// $sql = $koneksi->query("SELECT * FROM tb_rekap WHERE id_rekap='$id'");
if (isset($_GET['id'])) {
$id = $_GET['id'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Input Nilai Putra</title>
        <link rel="stylesheet" href="">
    </head>
    <body>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-green">
                        <h2>
                        INPUT NILAI BARUNG PUTRI
                        </h2>
                    </div>
                    <div class="body">
                        <div class="pull-right">
                            <a href="?page=rekapawalputri" class="btn btn-primary waves-effect"><i class="fa fa-chevron-right"></i> Kembali</a>
                        </div>
                        <br><br><br>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sql = $koneksi->query("SELECT * FROM tb_rekap_pi WHERE id_rekap_pi = '$id'");
                                        // $sql = $koneksi->query("SELECT * FROM tb_rekap_pi a, tb_peserta_pi b
                                        //                          WHERE a.id_pi = b.id_pi
                                        //                     ORDER BY b.no_dada ASC");
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
                                        $nilai_akhir_pi = $data['nilai_akhir_pi']; ?>
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
                                                <input type="text" class="form-control" name="txtDisplay" id="txtDisplay" style="width: 60px" value="" readonly>
                                            </td>
                                            <td align="center">
                                                <input type="hidden" name="id" value="<?= $id ?>" />
                                                <button type="submit" name="simpanNilai" class="btn btn-success btn-sm waves-effect" data-toggle="tooltip" data-placement="bottom" title="Simpan Nilai"><i class="fa fa-save"></i></button>
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
    </body>
</html>
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
"UPDATE TB_REKAP_PI
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
NILAI_AKHIR_PI = '$total'
WHERE ID_REKAP_PI = '$id'
"
); ?>
<script>
alert('Sukses, Input Nilai Berhasil');
window.location.href = "?page=rekapawalputri";
</script>
<?php
}
?>
<script type="text/javascript" language="Javascript">
// NILAI KETAKWAAN
var ketakwaan = document.formD.ketakwaan.value;
document.formD.txtDisplay.value = ketakwaan;
// NILAI TOLERANSI
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