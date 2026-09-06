<?php
include 'config/config.php';
include 'includes/header.php';

function get_youtube_embed($url)
{
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1] ?? '';
}
?>

<main class="page-shell">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Galeri Kegiatan</h2>
        <p class="text-muted">Dokumentasi momen berharga di SDN Dukuhbenda 02</p>
        <hr class="mx-auto section-rule gallery-rule">
    </div>

    <div class="row g-4">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
        if (mysqli_num_rows($sql) == 0) {
            echo "<div class='col-12 text-center'><p class='text-muted'>Belum ada dokumentasi tersedia.</p></div>";
        }

        while ($d = mysqli_fetch_array($sql)) {
        ?>
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-dukuhbenda02">

                    <?php if ($d['kategori'] == 'video' && $d['tipe_sumber'] == 'link_youtube'): ?>
                        <div class="ratio ratio-16x9">
                            <?php $video_id = get_youtube_embed($d['sumber']); ?>
                            <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($video_id, ENT_QUOTES, 'UTF-8'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>

                    <?php elseif ($d['tipe_sumber'] == 'upload'): ?>
                        <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $d['sumber'], ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($d['judul'], ENT_QUOTES, 'UTF-8'); ?>">

                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <div class="text-center">
                                <i class="bi bi-folder-symlink fs-1 text-primary"></i>
                                <p class="mb-0 small fw-bold">Buka di Google Drive</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge <?= $d['kategori'] == 'foto' ? 'bg-info' : 'bg-danger' ?> small">
                                <?= htmlspecialchars(strtoupper($d['kategori']), ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($d['tgl_upload'])); ?></small>
                        </div>
                        <h5 class="card-title fw-bold text-dark h6"><?= htmlspecialchars($d['judul'], ENT_QUOTES, 'UTF-8'); ?></h5>

                        <?php if ($d['tipe_sumber'] == 'link_drive'): ?>
                            <a href="<?= htmlspecialchars($d['sumber'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-sm btn-outline-primary w-100 mt-2 rounded-pill">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Drive
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</main>

<?php include 'includes/footer.php'; ?>