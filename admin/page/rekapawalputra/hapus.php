<?php
$id = @$_GET['id'];
$koneksi->query("DELETE FROM tb_rekap WHERE id_rekap='$id'");
?>
<script type="text/javascript">
window.location.href="?page=rekapawalputra";
</script>