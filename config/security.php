<?php
/**
 * Central security helpers.
 * Include AFTER config/koneksi.php.
 */

if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'secure'   => $secure,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/** Escape output for HTML context. */
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Get (or create) the per-session CSRF token. */
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Hidden input field for a form. */
function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** URL-safe token query string, e.g. for GET deletes. */
function csrf_query()
{
    return 'csrf_token=' . urlencode(csrf_token());
}

/** Validate a token (POST or GET). Dies on failure. */
function csrf_verify($token = null)
{
    $token = $token !== null ? $token : ($_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '');
    if (empty($_SESSION['csrf_token']) || !is_string($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die('Permintaan tidak valid (CSRF token salah).');
    }
}

/** Require a logged-in session, optionally with a specific level. */
function require_login($level = null)
{
    if (empty($_SESSION['level'])) {
        header('Location: ' . (defined('BASE_URL') ? BASE_URL : '') . '/auth/login.php');
        exit;
    }
    if ($level !== null && $_SESSION['level'] !== $level) {
        http_response_code(403);
        die('Akses ditolak.');
    }
}

/** Require admin level. */
function require_admin()
{
    require_login('admin');
}

/**
 * Run a prepared statement.
 * Returns mysqli_stmt on success, false on failure.
 * For SELECT, caller fetches from the returned stmt.
 */
function db_exec($koneksi, $sql, $params = [])
{
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        return false;
    }
    if (!empty($params)) {
        $types = '';
        foreach ($params as $p) {
            if (is_int($p)) {
                $types .= 'i';
            } elseif (is_float($p)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        $stmt->bind_param($types, ...$params);
    }
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }
    return $stmt;
}

/** Fetch a single row as associative array. */
function db_one($koneksi, $sql, $params = [])
{
    $stmt = db_exec($koneksi, $sql, $params);
    if (!$stmt) {
        return null;
    }
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    $stmt->close();
    return $row;
}

/** Fetch all rows as associative array. */
function db_all($koneksi, $sql, $params = [])
{
    $rows = [];
    $stmt = db_exec($koneksi, $sql, $params);
    if (!$stmt) {
        return $rows;
    }
    $res = $stmt->get_result();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    $stmt->close();
    return $rows;
}

/** Strip directory components to prevent path traversal. */
function safe_basename($name)
{
    return basename(str_replace('\\', '/', (string)$name));
}

/**
 * Validate and store an uploaded image.
 * Returns the generated filename on success, or null on failure.
 */
function safe_upload($file, $destDir, $prefix, $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'])
{
    if (empty($file) || !isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt, true)) {
        return null;
    }
    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        return null;
    }
    $destDir = rtrim($destDir, '/\\') . DIRECTORY_SEPARATOR;
    if (!is_dir($destDir) && !mkdir($destDir, 0755, true) && !is_dir($destDir)) {
        return null;
    }
    $name = $prefix . '-' . bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $destDir . $name)) {
        return null;
    }
    return $name;
}
