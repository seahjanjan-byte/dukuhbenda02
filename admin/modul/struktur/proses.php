<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

if (isset($_POST['update'])) {
    $admin_id = $_SESSION['admin_id'] ?? '';
    $gambar   = $_FILES['gambar']['name'] ?? '';
    $path     = "../../../assets/img/";

    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: ../profil/index.php?pesan=upload_gagal");
            exit();
        }

        // 1. Cari dan hapus bagan lama jika bukan default dan merupakan file valid
        $old = db_fetch_one($conn, "SELECT gambar FROM profil WHERE kategori = ?", 's', ['struktur']);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        db_execute($conn, "UPDATE profil SET gambar = ?, id_admin = ? WHERE kategori = ?", 'sss', [$nama_file, $admin_id, 'struktur']);
    }

    // Diarahkan keluar ke halaman utama profil
    header("Location: ../profil/index.php?status=success");
    exit();
} else {
    // Jika diakses tanpa submit, kembalikan ke profil
    header("Location: ../profil/index.php");
    exit();
}
