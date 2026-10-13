<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . $base_url . "admin/login.php?pesan=gagal");
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT id_admin, username, password FROM admin WHERE username = ? LIMIT 1");
if (!$stmt) {
    header("Location: " . $base_url . "admin/login.php?pesan=gagal");
    exit();
}

mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$loginValid = false;

if ($data) {
    $storedPassword = $data['password'];
    $passwordInfo = password_get_info($storedPassword);

    if ($passwordInfo['algo'] !== 0) {
        $loginValid = password_verify($password, $storedPassword);
    } elseif (hash_equals($storedPassword, $password)) {
        $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
        $updateStmt = mysqli_prepare($conn, "UPDATE admin SET password = ? WHERE id_admin = ?");

        if ($updateStmt) {
            mysqli_stmt_bind_param($updateStmt, 'ss', $newPasswordHash, $data['id_admin']);
            $loginValid = mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        }
    }
}

if ($loginValid) {
    session_regenerate_id(true);

    $_SESSION['admin_id'] = $data['id_admin'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['status'] = "login";

    header("Location: " . $base_url . "admin/index.php");
    exit();
} else {
    header("Location: " . $base_url . "admin/login.php?pesan=gagal");
    exit();
}
