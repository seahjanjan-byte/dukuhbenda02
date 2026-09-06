<?php
include 'config/config.php';
include 'includes/header.php';
?>
<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="text-center mb-5 mt-4" data-aos="fade-up">
        <h2 class="fw-bold">Berita & Kegiatan</h2>
        <p class="text-muted">Informasi terbaru seputar aktivitas SDN DukuhBenda 02</p>
        <hr class="mx-auto section-rule">
    </div>
    <div class="row g-4">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM berita WHERE status='tampil' ORDER BY id_berita DESC");
        if (mysqli_num_rows($sql) > 0):
            while ($b = mysqli_fetch_array($sql)):
        ?>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-dukuhbenda02">
                        <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $b['gambar'], ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" style="height: 220px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3"><?= htmlspecialchars($b['judul'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="text-secondary small mb-4" style="line-height: 1.6;">
                                <?= htmlspecialchars(substr(strip_tags($b['isi']), 0, 120), ENT_QUOTES, 'UTF-8'); ?>...
                            </p>
                            <a href="<?= htmlspecialchars($base_url . 'berita_view.php?id=' . rawurlencode($b['id_berita']), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
        else:
            ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada berita yang diterbitkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</main>
<?php include 'includes/footer.php'; ?>