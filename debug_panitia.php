<?php
include "config/koneksi.php";
$sql = $koneksi->query("SELECT * FROM tb_panitia");
echo "Count: " . $sql->num_rows . "\n";
while ($row = $sql->fetch_assoc()) {
    print_r($row);
}
?>