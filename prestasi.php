<?php
include 'config/config.php';
include 'includes/header.php';

// Ambil kategori dari URL jika ada
$cat = isset($_GET['cat']) ? $_GET['cat'] : 'semua';
?>

<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="text-center mb-5 mt-4" data-aos="fade-up">
        <h2 class="fw-bold">Prestasi Sekolah</h2>
        <p class="text-muted">Kebanggaan dan pencapaian siswa-siswi SDN Dukuhbenda 02</p>
        <hr class="mx-auto section-rule">
    </div>

    <div class="d-flex justify-content-center gap-2 mb-5" data-aos="fade-up">
        <a href="<?= htmlspecialchars($base_url . 'prestasi.php?cat=semua', ENT_QUOTES, 'UTF-8'); ?>" class="btn <?= ($cat == 'semua') ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4">Semua</a>
        <a href="<?= htmlspecialchars($base_url . 'prestasi.php?cat=akademik', ENT_QUOTES, 'UTF-8'); ?>" class="btn <?= ($cat == 'akademik') ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4">Akademik</a>
        <a href="<?= htmlspecialchars($base_url . 'prestasi.php?cat=non-akademik', ENT_QUOTES, 'UTF-8'); ?>" class="btn <?= ($cat == 'non-akademik') ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4">Non-Akademik</a>
    </div>

    <div class="row g-4">
        <?php
        $query = "SELECT * FROM prestasi";
        if ($cat != 'semua') {
            $query .= " WHERE kategori = '$cat'";
        }
        $query .= " ORDER BY tgl_prestasi DESC";

        $sql = mysqli_query($conn, $query);
        if (mysqli_num_rows($sql) > 0):
            while ($d = mysqli_fetch_array($sql)):
        ?>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-dukuhbenda02">
                        <div class="position-relative">
                            <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $d['gambar'], ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                                <?= htmlspecialchars(strtoupper($d['kategori']), ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <small class="text-muted d-block mb-2"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($d['tgl_prestasi'])); ?></small>
                            <h5 class="fw-bold text-dark mb-3"><?= htmlspecialchars($d['judul_prestasi'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.6;"><?= nl2br(htmlspecialchars($d['keterangan'], ENT_QUOTES, 'UTF-8')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-trophy display-1 text-light"></i>
                <p class="text-muted mt-3">Belum ada data prestasi untuk kategori ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</main>

<?php include 'includes/footer.php'; ?>