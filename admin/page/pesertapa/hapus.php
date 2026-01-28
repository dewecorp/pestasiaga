<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_peserta_pa WHERE id_pa='$id'");
$data = $sql->fetch_assoc();
$koneksi->query("DELETE FROM tb_peserta_pa WHERE id_pa='$id'");
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
document.location.href='?page=pesertapa';
} ,1500);
 
 </script>
