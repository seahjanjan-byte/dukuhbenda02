<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi     = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$admin_id = $_SESSION['admin_id'] ?? ''; // Relasi ke Admin
$path     = "../../../assets/img/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID SLIDER (SLD001)
    $last = db_fetch_one($conn, "SELECT id_slider FROM slider ORDER BY id_slider DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_slider'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "SLD" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "SLD001";
    }

    $judul    = $_POST['judul'] ?? '';
    $subjudul = $_POST['subjudul'] ?? '';
    $gambar   = $_FILES['gambar']['name'] ?? '';
    $tmp      = $_FILES['gambar']['tmp_name'] ?? '';

    $nama_file = "";
    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    // INSERT menyertakan id_slider dan id_admin
    db_execute($conn, "INSERT INTO slider (id_slider, id_admin, judul, subjudul, gambar) VALUES (?, ?, ?, ?, ?)", 'sssss', [$id_baru, $admin_id, $judul, $subjudul, $nama_file]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id       = $_POST['id'] ?? '';
    $judul    = $_POST['judul'] ?? '';
    $subjudul = $_POST['subjudul'] ?? '';
    $gambar   = $_FILES['gambar']['name'] ?? '';

    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        $old = db_fetch_one($conn, "SELECT gambar FROM slider WHERE id_slider = ?", 's', [$id]);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE slider SET judul = ?, subjudul = ?, gambar = ?, id_admin = ? WHERE id_slider = ?", 'sssss', [$judul, $subjudul, $nama_file, $admin_id, $id]);
    } else {
        db_execute($conn, "UPDATE slider SET judul = ?, subjudul = ?, id_admin = ? WHERE id_slider = ?", 'ssss', [$judul, $subjudul, $admin_id, $id]);
    }

    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id = $_POST['id'] ?? '';
    $d  = db_fetch_one($conn, "SELECT gambar FROM slider WHERE id_slider = ?", 's', [$id]);

    remove_uploaded_file($path, $d['gambar'] ?? null);

    db_execute($conn, "DELETE FROM slider WHERE id_slider = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
