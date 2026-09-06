<?php
include 'config/config.php';
include 'includes/header.php';

// Amankan input kategori
$kat = isset($_GET['kat']) ? mysqli_real_escape_string($conn, $_GET['kat']) : '';

// LOGIKA KHUSUS: Jika user mengklik Visi atau Misi, kita tampilkan dalam satu halaman "Visi & Misi"
if ($kat == 'visi' || $kat == 'misi' || $kat == 'visi-misi') {
    // Ambil data Visi
    $qv = mysqli_query($conn, "SELECT * FROM profil WHERE kategori = 'visi'");
    $dv = mysqli_fetch_array($qv);

    // Ambil data Misi
    $qm = mysqli_query($conn, "SELECT * FROM profil WHERE kategori = 'misi'");
    $dm = mysqli_fetch_array($qm);

    $judul = "Visi dan Misi Sekolah";
    $is_vm = true;
} else {
    // Query untuk kategori standar (Tentang, Sejarah, Struktur)
    $query = mysqli_query($conn, "SELECT * FROM profil WHERE kategori = '$kat'");
    $d = mysqli_fetch_array($query);

    // Jika data tidak ditemukan, kembalikan ke beranda
    if (!$d) {
        echo '<script>window.location=' . json_encode($base_url . 'index.php', JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';</script>';
        exit;
    }
    $judul = $d['judul'];
    $is_vm = false;
}
?>

<main class="page-shell article-page">
<div class="container py-5 mt-5 pt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="fw-bold text-dark text-uppercase"><?= htmlspecialchars($judul, ENT_QUOTES, 'UTF-8'); ?></h2>
                <hr class="mx-auto section-rule">
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white" data-aos="fade-up">

                <?php if ($is_vm): ?>
                    <div class="mb-5">
                        <h4 class="fw-bold text-primary mb-4"><i class="bi bi-eye-fill me-2"></i> VISI</h4>
                        <div class="ps-3 border-start border-primary border-4">
                            <ul class="fs-5 list-unstyled">
                                <?php
                                $visis = explode("[BREAK]", $dv['isi'] ?? '');
                                foreach ($visis as $v) {
                                    if (!empty(trim($v))) echo "<li class='mb-2'><i class='bi bi-check2-circle text-primary me-2'></i> " . htmlspecialchars($v, ENT_QUOTES, 'UTF-8') . "</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <h4 class="fw-bold text-primary mb-4"><i class="bi bi-rocket-takeoff-fill me-2"></i> MISI</h4>
                        <div class="ps-3 border-start border-primary border-4">
                            <ol class="fs-5 lh-lg">
                                <?php
                                $misis = explode("[BREAK]", $dm['isi'] ?? '');
                                foreach ($misis as $m) {
                                    if (!empty(trim($m))) echo "<li class='mb-3'>" . htmlspecialchars($m, ENT_QUOTES, 'UTF-8') . "</li>";
                                }
                                ?>
                            </ol>
                        </div>
                    </div>

                <?php else: ?>
                    <?php if (!empty($d['gambar'])): ?>
                        <div class="text-center mb-5">
                            <img src="<?= htmlspecialchars($base_url . 'assets/img/' . $d['gambar'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="img-fluid rounded-4 shadow-sm border border-5 border-white"
                                alt="<?= htmlspecialchars($judul, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="content-text article-body">
                        <?= nl2br(htmlspecialchars($d['isi'], ENT_QUOTES, 'UTF-8')); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="text-center mt-5">
                <a href="<?= htmlspecialchars($base_url . 'index.php', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-primary px-5 rounded-pill fw-bold">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
</main>

<?php include 'includes/footer.php'; ?>