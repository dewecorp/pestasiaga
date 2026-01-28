<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_user WHERE id='$id'");
$data = $sql->fetch_assoc();
$koneksi->query("DELETE FROM tb_user WHERE id='$id'");
 ?>

<script type="text/javascript">
  Swal.fire({
position: 'top-center',
icon: 'success',
title: '<?=$data['nama'];?>',
text: 'Berhasil Dihapus',
showConfirmButton: true,
timer: 3000
},10);
window.setTimeout(function(){
document.location.href='?page=user';
} ,1500);

</script>