<?php
include 'config/config.php';
include 'includes/header.php';
?>

<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold text-dark">Fasilitas Sekolah</h2>
        <p class="text-muted">Sarana dan prasarana pendukung kegiatan belajar mengajar di SDN dukuhbenda02</p>
        <hr class="mx-auto section-rule">
    </div>

    <div class="row g-4">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC");

        if (mysqli_num_rows($sql) > 0):
            $delay = 100;
            while ($f = mysqli_fetch_array($sql)):
        ?>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= htmlspecialchars((string) $delay, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition-all">
                        <div class="position-relative">
                            <?php
                            // Menggunakan base_url untuk gambar fasilitas
                            $gambar = (!empty($f['gambar']) && file_exists("assets/img/" . $f['gambar']))
                                ? $base_url . "assets/img/" . $f['gambar']
                                : $base_url . "assets/img/default-fasilitas.jpg";
                            ?>
                            <img src="<?= htmlspecialchars($gambar, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" style="height: 240px; object-fit: cover;" alt="<?= htmlspecialchars($f['nama_fasilitas'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="card-img-overlay d-flex align-items-end p-0">
                                <div class="w-100 p-3 facility-overlay">
                                    <h5 class="text-white fw-bold mb-0"><?= htmlspecialchars($f['nama_fasilitas'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <p class="text-secondary small mb-0" style="line-height: 1.6; text-align: justify;">
                                <?= nl2br(htmlspecialchars($f['deskripsi'], ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
                $delay += 100;
            endwhile;
        else:
            ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-building display-1 text-light"></i>
                <p class="text-muted mt-3">Data fasilitas belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</main>

<?php include 'includes/footer.php'; ?>