<?php
// Konfigurasi Database dari variabel global $koneksi (asumsi sudah ada dari index.php)
// Pastikan folder backup ada
$backupDir = '../admin/backup_data/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// === LOGIC HANDLERS ===

// 1. BACKUP DATABASE
if (isset($_POST['backup_now'])) {
    $tables = array();
    $result = $koneksi->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    $return = "SET FOREIGN_KEY_CHECKS=0;\n";

    foreach ($tables as $table) {
        $result = $koneksi->query("SELECT * FROM " . $table);
        $num_fields = $result->field_count;

        $return .= "DROP TABLE IF EXISTS " . $table . ";";
        $row2 = $koneksi->query("SHOW CREATE TABLE " . $table)->fetch_row();
        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = $result->fetch_row()) {
                $return .= "INSERT INTO " . $table . " VALUES(";
                for ($j = 0; $j < $num_fields; $j++) {
                    if (isset($row[$j])) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }
        $return .= "\n\n\n";
    }
    $return .= "SET FOREIGN_KEY_CHECKS=1;";

    $fileName = 'backup_db_' . date('Y-m-d_H-i-s') . '.sql';
    $handle = fopen($backupDir . $fileName, 'w+');
    fwrite($handle, $return);
    fclose($handle);

    echo "<script>
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Backup Berhasil!',
            text: 'File: $fileName',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href='?page=backup';
        });
    </script>";
}

// 2. RESTORE DATABASE
if (isset($_POST['restore_now'])) {
    $filename = $_FILES['file_restore']['name'];
    $filetmp  = $_FILES['file_restore']['tmp_name'];
    $fileext  = pathinfo($filename, PATHINFO_EXTENSION);

    if ($fileext == 'sql') {
        $templine = '';
        $lines = file($filetmp);
        $error = '';
        
        // Disable foreign keys check
        $koneksi->query("SET FOREIGN_KEY_CHECKS=0");

        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                if (!$koneksi->query($templine)) {
                    $error .= 'Error executing query: ' . $koneksi->error . '<br>';
                }
                $templine = '';
            }
        }
        
        // Enable foreign keys check
        $koneksi->query("SET FOREIGN_KEY_CHECKS=1");

        if (empty($error)) {
             echo "<script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Restore Berhasil!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href='?page=backup';
                });
            </script>";
        } else {
             echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Restore Gagal',
                    text: 'Terjadi kesalahan saat restore database.',
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Format Salah',
                text: 'Harap upload file berformat .sql',
            });
        </script>";
    }
}

// 3. DELETE BACKUP
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_file') {
    $file = $_GET['file'];
    if (file_exists($backupDir . $file)) {
        unlink($backupDir . $file);
        echo "<script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'File Terhapus',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href='?page=backup';
            });
        </script>";
    }
}
?>

<div class="row clearfix">
    <!-- Kolom Backup -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-green">
                <h2>BACKUP DATABASE</h2>
            </div>
            <div class="body" align="center">
                <p>Klik tombol di bawah untuk melakukan backup database terbaru.</p>
                <form action="" method="POST">
                    <button type="submit" name="backup_now" class="btn btn-lg btn-success waves-effect">
                        <i class="material-icons">backup</i> MULAI BACKUP
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Restore -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-orange">
                <h2>RESTORE DATABASE</h2>
            </div>
            <div class="body">
                <p>Upload file <b>.sql</b> untuk merestore database.</p>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="file" name="file_restore" class="form-control" required>
                        </div>
                    </div>
                    <div align="center">
                        <button type="submit" name="restore_now" class="btn btn-warning waves-effect" onclick="return confirm('Apakah Anda yakin ingin me-restore database? Data saat ini akan tertimpa!')">
                            <i class="material-icons">restore</i> RESTORE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Backup -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>RIWAYAT FILE BACKUP</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Tanggal Backup</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (is_dir($backupDir)) {
                                $files = scandir($backupDir, SCANDIR_SORT_DESCENDING);
                                foreach ($files as $file) {
                                    if ($file != '.' && $file != '..' && pathinfo($file, PATHINFO_EXTENSION) == 'sql') {
                                        $filePath = $backupDir . $file;
                                        $fileSize = round(filesize($filePath) / 1024, 2) . ' KB';
                                        $fileTime = date("d F Y H:i:s", filemtime($filePath));
                            ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $file; ?></td>
                                            <td><?= $fileSize; ?></td>
                                            <td><?= $fileTime; ?></td>
                                            <td align="center">
                                                <a href="<?= $backupDir . $file; ?>" class="btn btn-primary btn-xs waves-effect" download>
                                                    <i class="material-icons">file_download</i> Unduh
                                                </a>
                                                <button class="btn btn-danger btn-xs waves-effect" onclick="hapusFile('<?= $file; ?>')">
                                                    <i class="material-icons">delete</i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function hapusFile(filename) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "File backup " + filename + " akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "?page=backup&aksi=hapus_file&file=" + filename;
            }
        })
    }
</script>
