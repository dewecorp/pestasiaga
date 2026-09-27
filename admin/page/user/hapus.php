<?php
csrf_verify();
$id = (int)($_GET['id'] ?? 0);
$data = db_one($koneksi, "SELECT * FROM tb_user WHERE id = ?", [$id]);

if ($data) {
    if (!empty($data['foto'])) {
        $foto_file = safe_basename($data['foto']);
        if (file_exists("../assets/images/" . $foto_file)) {
            @unlink("../assets/images/" . $foto_file);
        }
    }
    db_exec($koneksi, "DELETE FROM tb_user WHERE id = ?", [$id]);
}
?>

<script type="text/javascript">
  Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: '<?= e($data['nama'] ?? ''); ?>',
    text: 'Berhasil Dihapus',
    showConfirmButton: true,
    timer: 3000
  }, 10);
  window.setTimeout(function(){
    document.location.href = '?page=user';
  }, 1500);
</script>
