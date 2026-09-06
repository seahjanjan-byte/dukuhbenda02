<?php
include 'config/config.php';
include 'includes/header.php';
?>

<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="text-center mb-5 mt-3" data-aos="fade-up">
        <h2 class="fw-bold">Tenaga Pengajar</h2>
        <p class="text-muted">Guru dan Staff pendidik SDN Dukuhbenda 02</p>
        <hr class="mx-auto section-rule">
    </div>

    <div class="row g-4">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM guru ORDER BY id_guru DESC");
        while ($g = mysqli_fetch_array($sql)): ?>
            <div class="col-md-3 text-center" data-aos="zoom-in">
                <div class="p-4 bg-white shadow-sm rounded-4 border-top border-primary border-4 h-100 transition-all">
                    <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $g['foto'], ENT_QUOTES, 'UTF-8'); ?>" class="rounded-circle mb-3 border" style="width: 120px; height: 120px; object-fit: cover;">
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($g['nama'], ENT_QUOTES, 'UTF-8'); ?></h6>
                    <span class="badge bg-light text-primary rounded-pill"><?= htmlspecialchars($g['jabatan'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</main>

<?php include 'includes/footer.php'; ?>