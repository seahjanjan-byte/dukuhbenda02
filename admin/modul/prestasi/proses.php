<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$path = "../../../assets/img/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID PRESTASI (PRS001)
    $last = db_fetch_one($conn, "SELECT id_prestasi FROM prestasi ORDER BY id_prestasi DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_prestasi'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "PRS" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "PRS001";
    }

    $id_admin = $_SESSION['admin_id'] ?? '';
    $id_guru  = $_POST['id_guru'] ?? '';
    $judul    = $_POST['judul_prestasi'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tgl      = $_POST['tgl_prestasi'] ?? '';
    $ket      = $_POST['keterangan'] ?? '';

    $gambar    = $_FILES['gambar']['name'] ?? '';
    $nama_file = "";
    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    // INSERT menyertakan id_prestasi, id_admin, dan id_guru sesuai aturan relasi
    db_execute($conn, "INSERT INTO prestasi (id_prestasi, id_admin, id_guru, judul_prestasi, kategori, tgl_prestasi, keterangan, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 'ssssssss', [$id_baru, $id_admin, $id_guru, $judul, $kategori, $tgl, $ket, $nama_file]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id       = $_POST['id'] ?? '';
    $id_guru  = $_POST['id_guru'] ?? '';
    $judul    = $_POST['judul_prestasi'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tgl      = $_POST['tgl_prestasi'] ?? '';
    $ket      = $_POST['keterangan'] ?? '';
    $gambar   = $_FILES['gambar']['name'] ?? '';

    if (!empty($gambar)) {
        $nama_baru = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        $old = db_fetch_one($conn, "SELECT gambar FROM prestasi WHERE id_prestasi = ?", 's', [$id]);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE prestasi SET id_guru = ?, judul_prestasi = ?, kategori = ?, tgl_prestasi = ?, keterangan = ?, gambar = ? WHERE id_prestasi = ?", 'sssssss', [$id_guru, $judul, $kategori, $tgl, $ket, $nama_baru, $id]);
    } else {
        db_execute($conn, "UPDATE prestasi SET id_guru = ?, judul_prestasi = ?, kategori = ?, tgl_prestasi = ?, keterangan = ? WHERE id_prestasi = ?", 'ssssss', [$id_guru, $judul, $kategori, $tgl, $ket, $id]);
    }
    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id  = $_POST['id'] ?? '';
    $old = db_fetch_one($conn, "SELECT gambar FROM prestasi WHERE id_prestasi = ?", 's', [$id]);
    remove_uploaded_file($path, $old['gambar'] ?? null);

    db_execute($conn, "DELETE FROM prestasi WHERE id_prestasi = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
