<?php
csrf_verify();
$id = (int)($_GET['id'] ?? 0);
$data = db_one($koneksi, "SELECT * FROM tb_peserta_pi WHERE id_pi = ?", [$id]);
if ($data) {
    db_exec($koneksi, "DELETE FROM tb_rekap_pi WHERE id_pi = ?", [$id]);
    db_exec($koneksi, "DELETE FROM tb_peserta_pi WHERE id_pi = ?", [$id]);
}
?>

<script type="text/javascript">
   Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: 'Sukses',
    text: '<?= e($data['pangkalan'] ?? ''); ?> Berhasil Dihapus',
    showConfirmButton: true,
    timer: 3000
   }, 10);
   window.setTimeout(function(){
    document.location.href = '?page=pesertapi';
   }, 1500);
</script>
