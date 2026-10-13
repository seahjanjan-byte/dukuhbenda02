<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$path = "../../../assets/img/";

if ($aksi == 'tambah') {
    // LOGIKA GENERATE ID GALERI (GLR001)
    $last = db_fetch_one($conn, "SELECT id_galeri FROM galeri ORDER BY id_galeri DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_galeri'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "GLR" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "GLR001";
    }

    $id_admin = $_SESSION['admin_id'];
    $judul    = $_POST['judul'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tipe     = $_POST['tipe_sumber'] ?? '';
    $sumber   = "";

    if ($tipe === 'upload' && $kategori !== 'foto') {
        header("Location: index.php?pesan=upload_gagal");
        exit();
    }
    if ($tipe === 'link_youtube' && $kategori !== 'video') {
        header("Location: index.php?pesan=upload_gagal");
        exit();
    }

    if ($tipe === 'upload' && !empty($_FILES['file_sumber']['name'])) {
        $sumber = store_uploaded_image($_FILES['file_sumber'], $path);
        if ($sumber === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    } elseif ($tipe !== 'upload') {
        $sumber = $_POST['url_sumber'] ?? '';
    } else {
        header("Location: index.php?pesan=upload_gagal");
        exit();
    }

    db_execute($conn, "INSERT INTO galeri (id_galeri, id_admin, judul, kategori, tipe_sumber, sumber) VALUES (?, ?, ?, ?, ?, ?)", 'ssssss', [$id_baru, $id_admin, $judul, $kategori, $tipe, $sumber]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id        = $_POST['id'] ?? '';
    $judul     = $_POST['judul'] ?? '';
    $kategori  = $_POST['kategori'] ?? '';
    $tipe      = $_POST['tipe_sumber'] ?? '';
    $url_baru  = $_POST['url_sumber'] ?? '';
    $file_baru = $_FILES['file_sumber']['name'] ?? '';

    $old = db_fetch_one($conn, "SELECT * FROM galeri WHERE id_galeri = ?", 's', [$id]);

    if ($tipe === 'upload' && $kategori !== 'foto') {
        header("Location: index.php?pesan=upload_gagal");
        exit();
    }
    if ($tipe === 'link_youtube' && $kategori !== 'video') {
        header("Location: index.php?pesan=upload_gagal");
        exit();
    }

    // Opsi 1: Pengguna mengunggah berkas gambar baru
    if ($tipe === 'upload' && !empty($file_baru)) {
        $nama_sumber = store_uploaded_image($_FILES['file_sumber'], $path);
        if ($nama_sumber === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        if (!empty($old['sumber']) && $old['tipe_sumber'] == 'upload' && is_file($path . $old['sumber'])) {
            remove_uploaded_file($path, $old['sumber']);
        }
        db_execute($conn, "UPDATE galeri SET judul = ?, kategori = ?, tipe_sumber = ?, sumber = ? WHERE id_galeri = ?", 'sssss', [$judul, $kategori, 'upload', $nama_sumber, $id]);

        // Opsi 2: Pengguna memasukkan Link/URL baru (misal Youtube)
    } elseif ($tipe !== 'upload' && !empty($url_baru)) {
        if (!empty($old['sumber']) && $old['tipe_sumber'] == 'upload' && is_file($path . $old['sumber'])) {
            remove_uploaded_file($path, $old['sumber']);
        }
        db_execute($conn, "UPDATE galeri SET judul = ?, kategori = ?, tipe_sumber = ?, sumber = ? WHERE id_galeri = ?", 'sssss', [$judul, $kategori, $tipe, $url_baru, $id]);

        // Opsi 3: Hanya mengubah Judul saja
    } elseif ($tipe === 'upload' && ($old['tipe_sumber'] ?? '') === 'upload') {
        db_execute($conn, "UPDATE galeri SET judul = ?, kategori = ?, tipe_sumber = ? WHERE id_galeri = ?", 'ssss', [$judul, $kategori, $tipe, $id]);
    } elseif ($tipe !== 'upload' && ($old['tipe_sumber'] ?? '') !== 'upload') {
        db_execute($conn, "UPDATE galeri SET judul = ?, kategori = ?, tipe_sumber = ? WHERE id_galeri = ?", 'ssss', [$judul, $kategori, $tipe, $id]);
    } else {
        header("Location: index.php?pesan=upload_gagal");
        exit();
    }

    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id = $_POST['id'] ?? '';
    $d  = db_fetch_one($conn, "SELECT * FROM galeri WHERE id_galeri = ?", 's', [$id]);

    // Memastikan sumber tidak kosong, bertipe upload, dan benar-benar file valid sebelum unlink
    if (!empty($d['sumber']) && $d['tipe_sumber'] == 'upload' && is_file($path . $d['sumber'])) {
        remove_uploaded_file($path, $d['sumber']);
    }

    db_execute($conn, "DELETE FROM galeri WHERE id_galeri = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
