<?php
csrf_verify();
$id = (int)($_GET['id'] ?? 0);
$data = db_one($koneksi, "SELECT * FROM tb_taman WHERE id_taman = ?", [$id]);
if ($data) {
    db_exec($koneksi, "DELETE FROM tb_taman WHERE id_taman = ?", [$id]);
}
?>
<script type="text/javascript">
Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: '<?= e($data['nama_taman'] ?? ''); ?>',
    text: 'Berhasil Dihapus',
    showConfirmButton: true,
    timer: 3000
}, 10);
window.setTimeout(function(){
    document.location.href = '?page=taman';
}, 1500);
</script>
