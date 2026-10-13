<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

if (isset($_POST['update'])) {
    $admin_id = $_SESSION['admin_id'] ?? '';
    $isi      = $_POST['isi'] ?? '';
    $gambar   = $_FILES['gambar']['name'] ?? '';
    $tmp      = $_FILES['gambar']['tmp_name'] ?? '';
    $path     = "../../../assets/img/";

    if (!empty($gambar)) {
        $nama_file = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file === false) {
            header("Location: ../profil/index.php?pesan=upload_gagal");
            exit();
        }

        // 1. Cari dan hapus gambar lama
        $old = db_fetch_one($conn, "SELECT gambar FROM profil WHERE kategori = ?", 's', ['sejarah']);
        remove_uploaded_file($path, $old['gambar'] ?? null);

        // 2. Upload gambar baru
        $success = db_execute($conn, "UPDATE profil SET isi = ?, gambar = ?, id_admin = ? WHERE kategori = ?", 'ssss', [$isi, $nama_file, $admin_id, 'sejarah']);
    } else {
        $success = db_execute($conn, "UPDATE profil SET isi = ?, id_admin = ? WHERE kategori = ?", 'sss', [$isi, $admin_id, 'sejarah']);
    }

    if ($success) {
        header("Location: ../profil/index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
