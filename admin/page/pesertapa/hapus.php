<?php
csrf_verify();
$id = (int)($_GET['id'] ?? 0);
$data = db_one($koneksi, "SELECT * FROM tb_peserta_pa WHERE id_pa = ?", [$id]);
if ($data) {
    db_exec($koneksi, "DELETE FROM tb_rekap WHERE id_pa = ?", [$id]);
    db_exec($koneksi, "DELETE FROM tb_peserta_pa WHERE id_pa = ?", [$id]);
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
    document.location.href = '?page=pesertapa';
   }, 1500);
</script>
