<?php
$id = @$_GET['id'];
$koneksi->query("DELETE FROM tb_rekap_pi WHERE id_rekap_pi='$id'");
?>
<script type="text/javascript">
window.location.href="?page=rekapawalputri";
</script>