<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi     = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$path     = "../../../assets/img/";
$id_admin = $_SESSION['admin_id'] ?? '';

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID PPDB (PDB001)
    $last = db_fetch_one($conn, "SELECT id_ppdb FROM ppdb ORDER BY id_ppdb DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_ppdb'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "PDB" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "PDB001";
    }

    $status = $_POST['status'] ?? '';
    $gambar = $_FILES['gambar']['name'] ?? '';

    $nama_file = "";
    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    db_execute($conn, "INSERT INTO ppdb (id_ppdb, id_admin, gambar, status) VALUES (?, ?, ?, ?)", 'ssss', [$id_baru, $id_admin, $nama_file, $status]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id     = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    $gambar = $_FILES['gambar']['name'] ?? '';

    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        $old = db_fetch_one($conn, "SELECT gambar FROM ppdb WHERE id_ppdb = ?", 's', [$id]);

        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE ppdb SET gambar = ?, status = ?, id_admin = ? WHERE id_ppdb = ?", 'ssss', [$nama_file, $status, $id_admin, $id]);
    } else {
        db_execute($conn, "UPDATE ppdb SET status = ?, id_admin = ? WHERE id_ppdb = ?", 'sss', [$status, $id_admin, $id]);
    }
    header("Location: index.php");
    exit();
} elseif ($aksi == 'status') {
    $id  = $_POST['id'] ?? '';
    $set = $_POST['set'] ?? '';

    db_execute($conn, "UPDATE ppdb SET status = ?, id_admin = ? WHERE id_ppdb = ?", 'sss', [$set, $id_admin, $id]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id    = $_POST['id'] ?? '';
    $old   = db_fetch_one($conn, "SELECT gambar FROM ppdb WHERE id_ppdb = ?", 's', [$id]);

    remove_uploaded_file($path, $old['gambar'] ?? null);

    db_execute($conn, "DELETE FROM ppdb WHERE id_ppdb = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
