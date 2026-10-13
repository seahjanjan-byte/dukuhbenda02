<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$path = "../../../assets/img/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID FASILITAS (FSL001)
    $last = db_fetch_one($conn, "SELECT id_fasilitas FROM fasilitas ORDER BY id_fasilitas DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_fasilitas'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "FSL" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "FSL001";
    }

    $id_admin = $_SESSION['admin_id']; // Relasi ke Admin
    $nama = $_POST['nama_fasilitas'] ?? '';
    $desk = $_POST['deskripsi'] ?? '';
    $gambar = $_FILES['gambar']['name'] ?? '';

    $nama_file = '';
    if ($gambar !== '') {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    // INSERT menyertakan id_fasilitas dan id_admin
    db_execute($conn, "INSERT INTO fasilitas (id_fasilitas, id_admin, nama_fasilitas, deskripsi, gambar)
                      VALUES (?, ?, ?, ?, ?)", 'sssss', [$id_baru, $id_admin, $nama, $desk, $nama_file]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama_fasilitas'] ?? '';
    $desk = $_POST['deskripsi'] ?? '';
    $gambar = $_FILES['gambar']['name'] ?? '';

    if ($gambar != "") {
        $nama_baru = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        // REVISI: Menggunakan id_fasilitas
        $old = db_fetch_one($conn, "SELECT gambar FROM fasilitas WHERE id_fasilitas = ?", 's', [$id]);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE fasilitas SET nama_fasilitas = ?, deskripsi = ?, gambar = ? WHERE id_fasilitas = ?", 'ssss', [$nama, $desk, $nama_baru, $id]);
    } else {
        db_execute($conn, "UPDATE fasilitas SET nama_fasilitas = ?, deskripsi = ? WHERE id_fasilitas = ?", 'sss', [$nama, $desk, $id]);
    }
    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id = $_POST['id'] ?? '';
    $old = db_fetch_one($conn, "SELECT gambar FROM fasilitas WHERE id_fasilitas = ?", 's', [$id]);
    remove_uploaded_file($path, $old['gambar'] ?? null);

    db_execute($conn, "DELETE FROM fasilitas WHERE id_fasilitas = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
