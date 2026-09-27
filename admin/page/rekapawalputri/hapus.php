<?php
csrf_verify();
$id = (int)($_GET['id'] ?? 0);
db_exec($koneksi, "DELETE FROM tb_rekap_pi WHERE id_rekap_pi = ?", [$id]);
?>
<script type="text/javascript">
window.location.href="?page=rekapawalputri";
</script>
