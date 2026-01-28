<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_taman WHERE id_taman='$id'");
$data = $sql->fetch_assoc();
$koneksi->query("DELETE FROM tb_taman WHERE id_taman='$id'");

?>
<script type="text/javascript">
Swal.fire({
position: 'top-center',
icon: 'success',
title: '<?=$data['nama_taman']?>',
text: 'Berhasil Dihapus',
showConfirmButton: true,
timer: 3000
},10);
window.setTimeout(function(){
document.location.href='?page=taman';
} ,1500);

</script>