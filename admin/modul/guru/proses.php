<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$path = "../../../assets/img/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID GURU (GRUxxx)
    $last = db_fetch_one($conn, "SELECT id_guru FROM guru ORDER BY id_guru DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_guru'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "GRU" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "GRU001";
    }

    $id_admin = $_SESSION['admin_id'];
    $nama     = $_POST['nama'] ?? '';
    $jabatan  = $_POST['jabatan'] ?? '';
    $foto     = $_FILES['foto']['name'] ?? '';

    $nama_file = "";
    if (!empty($foto)) {
        $nama_file = store_uploaded_image($_FILES['foto'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    db_execute($conn, "INSERT INTO guru (id_guru, id_admin, nama, jabatan, foto)
                      VALUES (?, ?, ?, ?, ?)", 'sssss', [$id_baru, $id_admin, $nama, $jabatan, $nama_file]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id      = $_POST['id'] ?? '';
    $nama    = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $foto    = $_FILES['foto']['name'] ?? '';

    if (!empty($foto)) {
        $nama_baru = store_uploaded_image($_FILES['foto'], $path);
        if ($nama_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        $old = db_fetch_one($conn, "SELECT foto FROM guru WHERE id_guru = ?", 's', [$id]);
        remove_uploaded_file($path, $old['foto'] ?? null);

        db_execute($conn, "UPDATE guru SET nama = ?, jabatan = ?, foto = ? WHERE id_guru = ?", 'ssss', [$nama, $jabatan, $nama_baru, $id]);
    } else {
        db_execute($conn, "UPDATE guru SET nama = ?, jabatan = ? WHERE id_guru = ?", 'sss', [$nama, $jabatan, $id]);
    }

    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id  = $_POST['id'] ?? '';
    $old = db_fetch_one($conn, "SELECT foto FROM guru WHERE id_guru = ?", 's', [$id]);

    remove_uploaded_file($path, $old['foto'] ?? null);

    db_execute($conn, "DELETE FROM guru WHERE id_guru = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
