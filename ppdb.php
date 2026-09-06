<?php
include 'config/config.php';
include 'includes/header.php';

// Cek status PPDB
$sql = mysqli_query($conn, "SELECT * FROM ppdb LIMIT 1");
$d = mysqli_fetch_array($sql);
?>

<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <?php if ($d && $d['status'] == 'buka'): ?>
        <div class="text-center mb-5 mt-4" data-aos="fade-up">
            <h2 class="fw-bold text-primary">Penerimaan Peserta Didik Baru (PPDB)</h2>
            <p class="text-muted">Selamat datang calon siswa-siswi cerdas SDN Dukuhbenda 02!</p>
            <hr class="mx-auto section-rule">
        </div>

        <div class="row justify-content-center">
            <div class="col-md-9" data-aos="zoom-in">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $d['gambar'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid" alt="Brosur PPDB">
                </div>
                <div class="alert alert-info mt-4 text-center rounded-pill border-0 shadow-sm">
                    <i class="bi bi-info-circle me-2"></i> Silakan simpan gambar di atas atau hubungi kontak kami untuk pendaftaran.
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="row justify-content-center py-5 mt-4">
            <div class="col-md-8 text-center" data-aos="fade-up">
                <div class="p-5 bg-white shadow-sm border rounded-4">
                    <div class="mb-4">
                        <i class="bi bi-clock-history text-warning display-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Layanan PPDB Sedang Tidak Aktif</h3>
                    <p class="lead text-muted mt-3">
                        Mohon maaf, saat ini periode Penerimaan Peserta Didik Baru (PPDB) SDN Dukuhbenda 02
                        <strong>telah ditutup atau belum memasuki masa pendaftaran</strong>.
                    </p>
                    <p class="text-muted small">
                        Silakan pantau terus halaman ini atau media sosial kami
                        untuk pembaruan informasi pendaftaran di masa mendatang.
                    </p>
                    <div class="mt-4">
                        <a href="<?= htmlspecialchars($base_url . 'index.php', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-primary px-4 rounded-pill fw-bold">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
</main>

<?php include 'includes/footer.php'; ?>