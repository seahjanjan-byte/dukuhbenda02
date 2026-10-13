<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../database_helper.php';

require_valid_csrf_token();

if (isset($_POST['update'])) {
    $admin_id = $_SESSION['admin_id'] ?? '';
    $id       = $_POST['id'] ?? '';
    $isi      = $_POST['isi'] ?? '';

    // PERBAIKAN: Mengubah klausa WHERE menjadi id_profil='$id' (atau kategori='tentang')
    // dan memperbarui id_admin sesuai admin yang sedang melakukan update
    $success = db_execute($conn, "UPDATE profil SET isi = ?, id_admin = ? WHERE id_profil = ?", 'sss', [$isi, $admin_id, $id]);

    if ($success) {
        header("Location: ../profil/index.php?status=success");
        exit();
    } else {
        // Jika ada error database
        echo "Error Database: " . mysqli_error($conn);
    }
} else {
    // Jika diakses tanpa submit form, kembalikan ke profil
    header("Location: ../profil/index.php");
    exit();
}
