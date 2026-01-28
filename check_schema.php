<?php
include "config/koneksi.php";

echo "Schema tb_peserta_pa:\n";
$res = $koneksi->query('DESCRIBE tb_peserta_pa');
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\nLast 5 rows tb_peserta_pa:\n";
$res2 = $koneksi->query('SELECT * FROM tb_peserta_pa ORDER BY id_pa DESC LIMIT 5');
while($row = $res2->fetch_assoc()) {
    print_r($row);
}
?>