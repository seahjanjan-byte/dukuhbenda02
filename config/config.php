<?php
// 1. Konfigurasi Database
// Nilai ini bisa di-override dari environment hosting agar aman saat pindah server.
$host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'localhost';
$user = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? 'root';
$pass = getenv('DB_PASS') ?: $_ENV['DB_PASS'] ?? '';
$db   = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'sdn-dukuhbenda02';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 2. Pengaturan Waktu (WIB)
date_default_timezone_set('Asia/Jakarta');

// 3. Logika Base URL Otomatis
// Prioritaskan APP_BASE_URL jika diatur oleh hosting, lalu fallback ke deteksi otomatis.
$base_url = getenv('APP_BASE_URL') ?: $_ENV['APP_BASE_URL'] ?? '';

if ($base_url === '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host_url = $_SERVER['HTTP_HOST'] ?? 'localhost';

    $document_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $current_dir = rtrim(str_replace('\\', '/', __DIR__), '/');

    $project_folder = '/';

    if ($document_root !== '' && strpos($current_dir, $document_root) === 0) {
        $relative_path = str_replace($document_root, '', $current_dir);
        $project_folder = preg_replace('#/config$#', '', $relative_path);
        $project_folder = ($project_folder === '' || $project_folder === '/') ? '/' : rtrim($project_folder, '/') . '/';
    } else {
        $script_name = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        $script_dir = rtrim(str_replace('\\', '/', dirname($script_name)), '/');
        $project_folder = ($script_dir === '' || $script_dir === '/') ? '/' : $script_dir . '/';
    }

    $base_url = $protocol . $host_url . $project_folder;
}

$base_url = rtrim($base_url, '/') . '/';
