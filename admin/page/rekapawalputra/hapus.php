<?php
csrf_verify();
$id = (int)($_GET['id'] ?? 0);
db_exec($koneksi, "DELETE FROM tb_rekap WHERE id_rekap = ?", [$id]);
?>
<script type="text/javascript">
window.location.href="?page=rekapawalputra";
</script>
