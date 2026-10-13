<?php
include '../../../config/config.php';
include '../../cek_session.php';
include '../../database_helper.php';

require_valid_csrf_token();

if (isset($_POST['update'])) {
    $admin_id = $_SESSION['admin_id'] ?? '';

    // 1. OLAH DAN SANITASI ARRAY VISI
    $raw_visi = is_array($_POST['visi'] ?? null) ? array_filter($_POST['visi']) : [];
    $clean_visi = array_map('trim', $raw_visi);
    $visi = implode("[BREAK]", $clean_visi);

    // 2. OLAH DAN SANITASI ARRAY MISI
    $raw_misi = is_array($_POST['misi'] ?? null) ? array_filter($_POST['misi']) : [];
    $clean_misi = array_map('trim', $raw_misi);
    $misi = implode("[BREAK]", $clean_misi);

    // 3. PROSES DATA VISI
    $cek_v = db_fetch_one($conn, "SELECT id_profil FROM profil WHERE kategori = ?", 's', ['visi']);
    if ($cek_v) {
        // Jika sudah ada, update isi dan admin pengelola
        db_execute($conn, "UPDATE profil SET isi = ?, id_admin = ? WHERE kategori = ?", 'sss', [$visi, $admin_id, 'visi']);
    } else {
        // Jika belum ada, buat baris baru dengan ID String
        db_execute($conn, "INSERT INTO profil (id_profil, id_admin, kategori, judul, isi) VALUES (?, ?, ?, ?, ?)", 'sssss', ['PFL_VISI', $admin_id, 'visi', 'Visi Sekolah', $visi]);
    }

    // 4. PROSES DATA MISI
    $cek_m = db_fetch_one($conn, "SELECT id_profil FROM profil WHERE kategori = ?", 's', ['misi']);
    if ($cek_m) {
        // Jika sudah ada, update
        db_execute($conn, "UPDATE profil SET isi = ?, id_admin = ? WHERE kategori = ?", 'sss', [$misi, $admin_id, 'misi']);
    } else {
        // Jika belum ada, buat baris baru
        db_execute($conn, "INSERT INTO profil (id_profil, id_admin, kategori, judul, isi) VALUES (?, ?, ?, ?, ?)", 'sssss', ['PFL_MISI', $admin_id, 'misi', 'Misi Sekolah', $misi]);
    }

    header("Location: ../profil/index.php?status=success");
    exit();
} else {
    header("Location: ../profil/index.php");
    exit();
}
