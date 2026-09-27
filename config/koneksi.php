<?php
// Matikan tampilan error untuk production (tetap catat ke log)
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
mysqli_report(MYSQLI_REPORT_OFF);

// Kredensial database. Ubah sesuai lingkungan produksi.
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'pestasiaga');

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
	// Jangan tampilkan detail error database ke user
	die("Koneksi database gagal.");
}

$koneksi->set_charset('utf8mb4');

// Pastikan kolom pengaturan kegiatan tersedia pada instalasi database lama.
$schema_columns = [
    'waktu' => 'DATE NULL',
    'jam' => 'VARCHAR(50) NULL',
    'tempat' => 'VARCHAR(255) NOT NULL DEFAULT ""',
    'tempat_ttd' => 'VARCHAR(255) NULL'
];
foreach ($schema_columns as $column => $definition) {
    $column_check = $koneksi->query("SHOW COLUMNS FROM tb_panitia LIKE '" . $column . "'");
    if ($column_check && $column_check->num_rows === 0) {
        $koneksi->query("ALTER TABLE tb_panitia ADD COLUMN `" . $column . "` " . $definition);
    }
}

// Deteksi base URL aplikasi relatif terhadap document root (untuk redirect yang benar)
if (!defined('BASE_URL')) {
	$appRoot = str_replace('\\', '/', dirname(__DIR__));
	$docRoot = str_replace('\\', '/', rtrim(isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '', '/\\'));
	$base = '';
	if ($docRoot !== '' && strpos($appRoot, $docRoot) === 0) {
		$base = substr($appRoot, strlen($docRoot));
	}
	define('BASE_URL', rtrim($base, '/'));
}

require_once __DIR__ . '/security.php';
