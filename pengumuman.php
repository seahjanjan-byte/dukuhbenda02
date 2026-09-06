<?php
include 'config/config.php';
include 'includes/header.php';
?>

<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="text-center mb-5 mt-4" data-aos="fade-up">
        <h2 class="fw-bold text-dark">Daftar Pengumuman Resmi</h2>
        <p class="text-muted">Informasi terbaru mengenai kegiatan dan pengumuman SDN Dukuhbenda 02</p>
        <hr class="mx-auto section-rule">
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM pengumuman WHERE status='aktif' ORDER BY tanggal DESC");

            if (mysqli_num_rows($sql) > 0):
                while ($d = mysqli_fetch_array($sql)):
            ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden card-dukuhbenda" data-aos="fade-up">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start mb-3">
                                <div class="mb-3 mb-md-0">
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 mb-2 rounded-pill">
                                        <i class="bi bi-calendar3 me-2"></i> <?= date('d F Y', strtotime($d['tanggal'])); ?>
                                    </span>
                                    <h3 class="fw-bold text-dark h4 mb-0"><?= htmlspecialchars($d['judul'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                </div>

                                <?php if (!empty($d['dokumen'])): ?>
                                    <a href="<?= htmlspecialchars($base_url . 'assets/doc/' . $d['dokumen'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm">
                                        <i class="bi bi-file-earmark-pdf me-2"></i> Lihat Lampiran
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="text-secondary mb-0" style="line-height: 1.8; text-align: justify;">
                                <?= nl2br(htmlspecialchars($d['isi'], ENT_QUOTES, 'UTF-8')); ?>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <div class="text-center py-5">
                    <i class="bi bi-megaphone display-1 text-light"></i>
                    <p class="mt-3 text-muted">Belum ada pengumuman yang dipublikasikan saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</main>

<?php include 'includes/footer.php'; ?>