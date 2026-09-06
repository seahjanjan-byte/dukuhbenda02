<?php
include 'config/config.php';
include 'includes/header.php';

// Ambil ID berita dari URL dan amankan
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Ambil data berita (perbaikan nama kolom id -> id_berita)
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita = '$id' AND status = 'tampil'");
$b = mysqli_fetch_array($query);

// Jika berita tidak ditemukan, kembalikan ke beranda menggunakan base_url
if (!$b) {
    echo '<script>window.location=' . json_encode($base_url . 'index.php', JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';</script>';
    exit;
}
?>

<main class="page-shell article-page">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <nav aria-label="breadcrumb" class="mb-4 bg-light p-3 rounded-3 shadow-sm border-start border-primary border-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= htmlspecialchars($base_url . 'index.php', ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= htmlspecialchars($base_url . 'berita.php', ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none">Berita</a></li>
                    <li class="breadcrumb-item active text-truncate" aria-current="page"><?= htmlspecialchars($b['judul'], ENT_QUOTES, 'UTF-8'); ?></li>
                </ol>
            </nav>

            <h1 class="display-5 fw-bold text-dark mb-3" style="line-height: 1.2;"><?= htmlspecialchars($b['judul'], ENT_QUOTES, 'UTF-8'); ?></h1>

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 py-3 border-top border-bottom">
                <div class="d-flex align-items-center gap-4 text-muted small">
                    <span><i class="bi bi-person-circle text-primary me-2"></i> ADMINISTRATOR</span>
                    <span><i class="bi bi-calendar3 text-primary me-2"></i> <?= date('d F Y', strtotime($b['tanggal'] ?? date('Y-m-d'))); ?></span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></button>
                    <button class="btn btn-sm btn-outline-info rounded-circle"><i class="bi bi-twitter-x"></i></button>
                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="bi bi-whatsapp"></i></button>
                </div>
            </div>

            <?php if (!empty($b['gambar'])): ?>
                <div class="position-relative mb-5">
                    <div class="rounded-4 overflow-hidden shadow-lg border">
                        <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $b['gambar'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid w-100" style="max-height: 550px; object-fit: cover;" alt="<?= htmlspecialchars($b['judul'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
            <?php endif; ?>

            <div class="news-content text-justify article-body">
                <?= nl2br(htmlspecialchars($b['isi'], ENT_QUOTES, 'UTF-8')); ?>
            </div>

            <div class="mt-5 pt-4 border-top">
                <a href="<?= htmlspecialchars($base_url . 'berita.php', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm transition-all">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Berita
                </a>
            </div>

        </div>
    </div>
</div>
</main>

<?php include 'includes/footer.php'; ?>