<?php
$id = @$_GET['id'];
$koneksi->query("DELETE FROM tb_juri WHERE id_juri='$id'");
?>

<script type="text/javascript">
Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: 'Sukses',
    text: 'Data Berhasil Dihapus',
    showConfirmButton: true,
    timer: 3000
}, 10);
window.setTimeout(function() {
    document.location.href = '?page=juri';
}, 1500);
</script>