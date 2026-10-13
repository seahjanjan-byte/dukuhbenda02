<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi     = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$admin_id = $_SESSION['admin_id'] ?? '';

if ($aksi == 'pin') {
    $id  = $_POST['id'] ?? '';
    $set = $_POST['set'] ?? '';

    // is_pinned menggunakan VARCHAR '0' atau '1'
    db_execute($conn, "UPDATE pesan SET is_pinned = ?, id_admin_pembaca = ? WHERE id_pesan = ?", 'iss', [$set, $admin_id, $id]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'status') {
    $id  = $_POST['id'] ?? '';
    $set = $_POST['set'] ?? '';

    db_execute($conn, "UPDATE pesan SET status = ?, is_pinned = 0, id_admin_pembaca = ? WHERE id_pesan = ?", 'sss', [$set, $admin_id, $id]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id = $_POST['id'] ?? '';

    db_execute($conn, "DELETE FROM pesan WHERE id_pesan = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
