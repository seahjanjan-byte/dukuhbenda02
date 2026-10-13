<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$path = "../../../assets/img/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID BERITA (BRT001)
    $last = db_fetch_one($conn, "SELECT id_berita FROM berita ORDER BY id_berita DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_berita'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "BRT" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "BRT001";
    }

    $id_admin = $_SESSION['admin_id'];
    $judul    = $_POST['judul'] ?? '';
    $isi      = $_POST['isi'] ?? '';
    $foto     = $_FILES['gambar']['name'] ?? '';

    if ($foto != "") {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    } else {
        $nama_file = "";
    }

    db_execute($conn, "INSERT INTO berita (id_berita, id_admin, judul, isi, gambar, status)
                      VALUES (?, ?, ?, ?, ?, ?)", 'ssssss', [$id_baru, $id_admin, $judul, $isi, $nama_file, 'tampil']);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id    = $_POST['id'] ?? '';
    $judul = $_POST['judul'] ?? '';
    $isi   = $_POST['isi'] ?? '';
    $foto  = $_FILES['gambar']['name'] ?? '';

    if ($foto != "") {
        $nama_baru = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        $old = db_fetch_one($conn, "SELECT gambar FROM berita WHERE id_berita = ?", 's', [$id]);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE berita SET judul = ?, isi = ?, gambar = ? WHERE id_berita = ?", 'ssss', [$judul, $isi, $nama_baru, $id]);
    } else {
        db_execute($conn, "UPDATE berita SET judul = ?, isi = ? WHERE id_berita = ?", 'sss', [$judul, $isi, $id]);
    }
    header("Location: index.php");
    exit();
} elseif ($aksi == 'status') {
    // REVISI: Perbaikan fitur Status (Arsipkan/Tampilkan)
    $id  = $_POST['id'] ?? '';
    $set = $_POST['set'] ?? '';

    // Gunakan id_berita sesuai struktur revisi
    db_execute($conn, "UPDATE berita SET status = ? WHERE id_berita = ?", 'ss', [$set, $id]);

    // Redirect kembali ke index dan hentikan eksekusi skrip
    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id = $_POST['id'] ?? '';
    $old = db_fetch_one($conn, "SELECT gambar FROM berita WHERE id_berita = ?", 's', [$id]);
    remove_uploaded_file($path, $old['gambar'] ?? null);

    db_execute($conn, "DELETE FROM berita WHERE id_berita = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
