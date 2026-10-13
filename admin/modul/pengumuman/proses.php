<?php
require_once '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$folder_doc = "../../../assets/doc/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID PENGUMUMAN (PGM001)
    $last = db_fetch_one($conn, "SELECT id_pengumuman FROM pengumuman ORDER BY id_pengumuman DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_pengumuman'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "PGM" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "PGM001";
    }

    $id_admin = $_SESSION['admin_id'];
    $judul    = $_POST['judul'] ?? '';
    $isi      = $_POST['isi'] ?? '';
    $tanggal  = $_POST['tanggal'] ?? '';
    $status   = $_POST['status'] ?? '';
    $dokumen  = $_FILES['dokumen']['name'] ?? '';

    $nama_file = "";
    if (!empty($dokumen)) {
        $nama_file = store_uploaded_file($_FILES['dokumen'], $folder_doc, [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ]);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    db_execute($conn, "INSERT INTO pengumuman (id_pengumuman, id_admin, judul, isi, dokumen, tanggal, status) VALUES (?, ?, ?, ?, ?, ?, ?)", 'sssssss', [$id_baru, $id_admin, $judul, $isi, $nama_file, $tanggal, $status]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id      = $_POST['id'] ?? '';
    $judul   = $_POST['judul'] ?? '';
    $isi     = $_POST['isi'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
    $status  = $_POST['status'] ?? '';
    $file    = $_FILES['dokumen']['name'] ?? '';

    if (!empty($file)) {
        $nama_baru = store_uploaded_file($_FILES['dokumen'], $folder_doc, [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ]);
        if ($nama_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        $cek = db_fetch_one($conn, "SELECT dokumen FROM pengumuman WHERE id_pengumuman = ?", 's', [$id]);
        remove_uploaded_file($folder_doc, $cek['dokumen'] ?? null);

        db_execute($conn, "UPDATE pengumuman SET judul = ?, isi = ?, dokumen = ?, tanggal = ?, status = ? WHERE id_pengumuman = ?", 'ssssss', [$judul, $isi, $nama_baru, $tanggal, $status, $id]);
    } else {
        db_execute($conn, "UPDATE pengumuman SET judul = ?, isi = ?, tanggal = ?, status = ? WHERE id_pengumuman = ?", 'sssss', [$judul, $isi, $tanggal, $status, $id]);
    }

    header("Location: index.php");
    exit();
} elseif ($aksi == 'status') {
    $id  = $_POST['id'] ?? '';
    $set = $_POST['set'] ?? '';
    db_execute($conn, "UPDATE pengumuman SET status = ? WHERE id_pengumuman = ?", 'ss', [$set, $id]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id  = $_POST['id'] ?? '';
    $cek = db_fetch_one($conn, "SELECT dokumen FROM pengumuman WHERE id_pengumuman = ?", 's', [$id]);
    remove_uploaded_file($folder_doc, $cek['dokumen'] ?? null);

    db_execute($conn, "DELETE FROM pengumuman WHERE id_pengumuman = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
