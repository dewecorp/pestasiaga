<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_peserta_pi WHERE id_pi='$id'");
$data = $sql->fetch_assoc();
$koneksi->query("delete from tb_peserta_pi where id_pi='$id'");
 ?>

 <script type="text/javascript">
   Swal.fire({
position: 'top-center',
icon: 'success',
title: 'Sukses',
text: '<?=$data['pangkalan'];?> Berhasil Dihapus',
showConfirmButton: true,
timer: 3000
},10);
window.setTimeout(function(){
document.location.href='?page=pesertapi';
} ,1500);
 </script>
