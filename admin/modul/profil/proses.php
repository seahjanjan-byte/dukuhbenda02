<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

$aksi     = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$admin_id = $_SESSION['admin_id'] ?? '';
$path     = "../../../assets/img/";

if ($aksi == 'tambah') {
    // Generate ID
    $last = db_fetch_one($conn, "SELECT id_profil FROM profil ORDER BY id_profil DESC LIMIT 1");
    if ($last) {
        $last_id = $last['id_profil'];
        $num = (int)substr($last_id, 3) + 1;
        $id_baru = "PFL" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_baru = "PFL001";
    }

    $kategori = $_POST['kategori'] ?? '';
    $judul    = ucfirst($kategori);

    // Ambil isi berdasarkan jenis input dan lakukan sanitasi
    if ($kategori == 'visi' || $kategori == 'misi') {
        $poin_clean = array_map('trim', array_filter($_POST['poin'] ?? []));
        $isi = implode("[BREAK]", $poin_clean);
    } else {
        $isi = $_POST['isi_biasa'] ?? '';
    }

    // Gambar (Hanya diproses jika ada file diunggah)
    $nama_file = NULL;
    if (!empty($_FILES['gambar']['name'])) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }
    }

    // Insert ke Database
    db_execute($conn, "INSERT INTO profil (id_profil, id_admin, kategori, judul, isi, gambar) VALUES (?, ?, ?, ?, ?, ?)", 'ssssss', [$id_baru, $admin_id, $kategori, $judul, $isi, $nama_file]);
    header("Location: index.php");
    exit();
} elseif ($aksi == 'edit') {
    $id       = $_POST['id'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $gambar   = $_FILES['gambar']['name'] ?? '';

    // Olah isi sesuai kategori
    if ($kategori == 'visi' || $kategori == 'misi') {
        $poin_clean = array_map('trim', array_filter($_POST['poin'] ?? []));
        $isi = implode("[BREAK]", $poin_clean);
    } else {
        $isi = $_POST['isi_biasa'] ?? '';
    }

    if (!empty($gambar)) {
        $nama_baru = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        // Hapus gambar lama jika ada
        $old = db_fetch_one($conn, "SELECT gambar FROM profil WHERE id_profil = ?", 's', [$id]);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE profil SET isi = ?, gambar = ?, id_admin = ? WHERE id_profil = ?", 'ssss', [$isi, $nama_baru, $admin_id, $id]);
    } else {
        db_execute($conn, "UPDATE profil SET isi = ?, id_admin = ? WHERE id_profil = ?", 'sss', [$isi, $admin_id, $id]);
    }

    header("Location: index.php");
    exit();
} elseif ($aksi == 'hapus') {
    $id  = $_GET['id'] ?? '';
    $old = db_fetch_one($conn, "SELECT gambar FROM profil WHERE id_profil = ?", 's', [$id]);

    remove_uploaded_file($path, $old['gambar'] ?? null);

    db_execute($conn, "DELETE FROM profil WHERE id_profil = ?", 's', [$id]);
    header("Location: index.php");
    exit();
}
