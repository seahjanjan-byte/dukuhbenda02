<?php
// Path absolut agar link tidak pecah di level folder mana pun
include_once __DIR__ . '/../config/config.php';
$base_url_admin = rtrim($base_url, '/') . '/admin/';
?>

<link rel="stylesheet" href="<?= htmlspecialchars($base_url . 'assets/css/style.css', ENT_QUOTES, 'UTF-8'); ?>">

<div class="sidebar-dukuhbenda02 d-flex flex-column p-3">
    <div class="text-center mb-4 py-4">
        <h4 class="fw-bold text-white" style="letter-spacing: 2px;">SDN Dukuhbenda 02</h4>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= $base_url_admin; ?>index.php" class="nav-link py-2">
                <i class="bi bi-grid-1x2 me-3"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/berita/index.php" class="nav-link py-2">
                <i class="bi bi-newspaper me-3"></i> Kelola Berita
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/guru/index.php" class="nav-link py-2">
                <i class="bi bi-people me-3"></i> Data Guru
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/prestasi/index.php" class="nav-link py-2">
                <i class="bi bi-trophy me-3"></i> Prestasi
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/galeri/index.php" class="nav-link py-2">
                <i class="bi bi-images me-3"></i> Galeri Foto
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/fasilitas/index.php" class="nav-link py-2">
                <i class="bi bi-building me-3"></i> Kelola Fasilitas
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/ppdb/index.php" class="nav-link py-2">
                <i class="bi bi-mortarboard me-3"></i> Update PPDB
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/profil/index.php" class="nav-link py-2">
                <i class="bi bi-info-circle me-3"></i> Profil Sekolah
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/slider/index.php" class="nav-link py-2">
                <i class="bi bi-sliders me-3"></i> Kelola Slider
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/pesan/index.php" class="nav-link py-2">
                <i class="bi bi-envelope me-3"></i> Pesan Masuk
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/sambutan/index.php" class="nav-link py-2">
                <i class="bi bi-person me-3"></i> Sambutan Kepsek
            </a>
        </li>
        <li>
            <a href="<?= $base_url_admin; ?>modul/pengumuman/index.php" class="nav-link py-2">
                <i class="bi bi-megaphone me-3"></i> Kelola Pengumuman
            </a>
        </li>
    </ul>

    <div class="mt-auto ps-2 pb-4 border-top pt-3">
        <a href="<?= $base_url_admin; ?>logout.php" class="text-white text-decoration-none fw-bold opacity-75">
            <i class="bi bi-box-arrow-left me-2"></i> Keluar
        </a>
    </div>
</div>