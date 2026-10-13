<?php
// 1. Sertakan config agar base_url tersedia di semua halaman
include_once 'config/config.php';

// 2. Deteksi halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);
$is_home = ($current_page == 'index.php');

// 3. Gunakan navbar solid agar navigasi selalu terbaca sejak halaman dibuka
$nav_class = 'scrolled';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SDN Dukuhbenda 02 - Cerdas & Berkarakter</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= htmlspecialchars($base_url . 'assets/css/style.css', ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="shortcut icon" href="<?= htmlspecialchars($base_url . 'assets/img/logoo.png', ENT_QUOTES, 'UTF-8'); ?>">
</head>

<body class="<?= htmlspecialchars(($is_home) ? 'home-page' : '', ENT_QUOTES, 'UTF-8'); ?>">

  <?php if ($is_home): ?>
    <div class="page-hero-shell">
    <?php endif; ?>

    <nav class="navbar navbar-expand-lg <?= htmlspecialchars($nav_class, ENT_QUOTES, 'UTF-8'); ?>" id="mainNav">
      <div class="container">
        <a class="navbar-brand fw-bold fs-3 d-flex align-items-center" href="<?= htmlspecialchars($base_url . 'index.php', ENT_QUOTES, 'UTF-8'); ?>">
          <img src="<?= htmlspecialchars($base_url . 'assets/img/logoo.png', ENT_QUOTES, 'UTF-8'); ?>" alt="Logo" width="50" height="50" class="me-2">
          SDN Dukuhbenda 02
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'index.php', ENT_QUOTES, 'UTF-8'); ?>">Beranda</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Profil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profil_view.php?kat=tentang">Tentang Sekolah</a></li>
                <li><a class="dropdown-item" href="profil_view.php?kat=visi">Visi & Misi</a></li>
                <li><a class="dropdown-item" href="profil_view.php?kat=sejarah">Sejarah Sekolah</a></li>
                <li><a class="dropdown-item" href="profil_view.php?kat=struktur">Struktur Organisasi</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'guru.php', ENT_QUOTES, 'UTF-8'); ?>">Guru</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'berita.php', ENT_QUOTES, 'UTF-8'); ?>">Berita</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'prestasi.php', ENT_QUOTES, 'UTF-8'); ?>">Prestasi</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'fasilitas.php', ENT_QUOTES, 'UTF-8'); ?>">Fasilitas</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'pengumuman.php', ENT_QUOTES, 'UTF-8'); ?>">Pengumuman</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base_url . 'index.php#hubungi-kami', ENT_QUOTES, 'UTF-8'); ?>">Hubungi Kami</a></li>
            <li class="nav-item">
              <a class="nav-link fw-bold text-primary" href="<?= htmlspecialchars($base_url . 'ppdb.php', ENT_QUOTES, 'UTF-8'); ?>">PPDB</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>