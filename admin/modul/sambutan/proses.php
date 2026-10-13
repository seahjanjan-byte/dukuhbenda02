<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../upload_helper.php';
include '../../database_helper.php';

require_valid_csrf_token();

if (isset($_POST['update'])) {
    $id_admin  = $_SESSION['admin_id'] ?? '';
    $id_profil = $_POST['id'] ?? '';
    $isi       = $_POST['isi'] ?? '';
    $file      = $_FILES['gambar']['name'] ?? '';
    $tmp       = $_FILES['gambar']['tmp_name'] ?? '';
    $path      = "../../../assets/img/";

    // Cek apakah data sambutan sudah ada di database
    $data_lama = db_fetch_one($conn, "SELECT id_profil, gambar FROM profil WHERE kategori = ?", 's', ['sambutan']);
    $ada       = $data_lama !== null;

    $nama_file = $ada ? $data_lama['gambar'] : 'default.jpg';

    // Jika ada upload foto baru
    if (!empty($file)) {
        $nama_file_baru = store_uploaded_image($_FILES['gambar'], $path);
        if ($nama_file_baru === false) {
            header("Location: index.php?pesan=upload_gagal");
            exit();
        }

        // Hapus foto lama jika bukan default dan merupakan file valid
        remove_uploaded_file($path, $ada ? ($data_lama['gambar'] ?? null) : null);

        // Upload foto baru
        $nama_file = $nama_file_baru;
    }

    if ($ada) {
        // Logika UPDATE: Tetap menyertakan id_admin agar relasi terjaga
        $success = db_execute($conn, "UPDATE profil SET isi = ?, gambar = ?, id_admin = ? WHERE kategori = ?", 'ssss', [$isi, $nama_file, $id_admin, 'sambutan']);
    } else {
        // Logika INSERT: Gunakan ID String khusus
        $success = db_execute($conn, "INSERT INTO profil (id_profil, id_admin, kategori, judul, isi, gambar) VALUES (?, ?, ?, ?, ?, ?)", 'ssssss', ['PFL_SAMBUTAN', $id_admin, 'sambutan', 'Sambutan Kepala Sekolah', $isi, $nama_file]);
    }

    if ($success) {
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
