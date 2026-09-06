<?php
include 'config/config.php';
include 'includes/header.php';
// JANGAN sertakan cek_session.php di sini karena ini halaman publik
?>

<section class="hero-section editorial-hero" aria-label="Banner utama sekolah">
    <div class="container py-5">
        <div class="row align-items-center g-4 g-xl-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="hero-editorial-copy">
                    <span class="eyebrow">Sekolah dasar yang bertumbuh bersama</span>
                    <h1 class="display-3 fw-bold text-navy mb-4">Ruang belajar untuk masa depan yang berkarakter.</h1>
                    <p class="lead text-secondary mb-4">Menyemai rasa ingin tahu, membangun kepercayaan diri, dan merayakan setiap langkah kecil siswa SDN Dukuhbenda 02.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#berita-terbaru" class="btn btn-amber rounded-pill px-4 py-3 fw-semibold">Jelajahi kegiatan <i class="bi bi-arrow-down ms-2"></i></a>
                        <a href="<?= htmlspecialchars($base_url . 'ppdb.php', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-sage rounded-pill px-4 py-3 fw-semibold">Informasi PPDB</a>
                    </div>
                    <div class="hero-editorial-note mt-5"><i class="bi bi-quote me-2"></i>Belajar hari ini, memberi arti untuk esok.</div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div id="heroCarousel" class="carousel slide carousel-fade editorial-carousel" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="4500">
                    <div class="carousel-inner">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM slider");
            $active = "active";
            while ($s = mysqli_fetch_array($sql)):
            ?>
                <div class="carousel-item <?= htmlspecialchars($active, ENT_QUOTES, 'UTF-8'); ?> hero-slide" style="background: url('<?= htmlspecialchars($base_url . 'assets/img/' . $s['gambar'], ENT_QUOTES, 'UTF-8'); ?>') center/cover no-repeat;">
                    <div class="hero-overlay text-white"></div>
                    <div class="hero-content position-relative d-flex align-items-end h-100">
                        <div class="hero-copy" data-aos="fade-up">
                            <span class="hero-kicker"><i class="bi bi-stars me-2"></i>SDN Dukuhbenda 02</span>
                            <h2 class="display-5 fw-bold mb-2"><?= htmlspecialchars($s['judul'], ENT_QUOTES, 'UTF-8'); ?></h2>
                            <p class="fs-5 opacity-85 mb-0"><?= htmlspecialchars($s['subjudul'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                </div>
            <?php $active = "";
            endwhile; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="Slide sebelumnya"><span class="carousel-control-prev-icon"></span></button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="Slide berikutnya"><span class="carousel-control-next-icon"></span></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section py-5 bg-white">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="ps-lg-4">
                    <?php
                    $query_sk = mysqli_query($conn, "SELECT * FROM profil WHERE kategori='sambutan' LIMIT 1");
                    $sk = mysqli_fetch_array($query_sk);
                    ?>
                    <span class="eyebrow">Pesan pimpinan</span>
                    <h2 class="display-6 fw-bold text-navy mb-4">Sambutan Kepala Sekolah</h2>
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="rounded-4 overflow-hidden shadow-sm border-0 bg-sage-light welcome-image">
                                <?php
                                $foto_path = "assets/img/" . ($sk['gambar'] ?? '');
                                $foto = (!empty($sk['gambar']) && file_exists($foto_path)) ? $base_url . $foto_path : $base_url . "assets/img/logoo.png";
                                ?>
                                <img src="<?= $foto; ?>" class="img-fluid w-100" style="object-fit: cover; aspect-ratio: 3/4;">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <p class="text-muted fw-medium mb-2">Bismillahirrohmanirrohim...</p>
                            <div class="text-secondary" style="line-height: 1.8; text-align: justify; font-size: 0.95rem;">
                                <?= nl2br(htmlspecialchars(substr($sk['isi'] ?? 'Teks sambutan sedang diperbarui.', 0, 500), ENT_QUOTES, 'UTF-8')); ?>...
                            </div>
                            <a href="<?= htmlspecialchars($base_url . 'profil_view.php?kat=sambutan', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sage rounded-pill px-4 mt-4 fw-bold shadow-sm">
                                Baca Selengkapnya <i class="bi bi-arrow-right-short ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="feature-story-panel">
                    <span class="eyebrow">Dari ruang kelas</span>
                    <h3 class="fw-bold text-navy mb-3">Belajar dengan rasa ingin tahu, tumbuh dengan percaya diri.</h3>
                    <p class="text-secondary mb-0">Kami percaya lingkungan belajar yang hangat membantu setiap anak menemukan suaranya sendiri.</p>
                    <div class="story-accent mt-4"><i class="bi bi-mortarboard-fill"></i><span>Lingkungan aman, nyaman, dan berkualitas.</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section py-5 bg-sand-light">
    <div class="container">
        <?php
        $visi_stmt = mysqli_prepare($conn, "SELECT isi FROM profil WHERE kategori = 'visi' LIMIT 1");
        mysqli_stmt_execute($visi_stmt);
        $visi_result = mysqli_stmt_get_result($visi_stmt);
        $visi_data = mysqli_fetch_assoc($visi_result) ?: [];
        mysqli_stmt_close($visi_stmt);
        $misi_stmt = mysqli_prepare($conn, "SELECT isi FROM profil WHERE kategori = 'misi' LIMIT 1");
        mysqli_stmt_execute($misi_stmt);
        $misi_result = mysqli_stmt_get_result($misi_stmt);
        $misi_data = mysqli_fetch_assoc($misi_result) ?: [];
        mysqli_stmt_close($misi_stmt);
        ?>
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5" data-aos="fade-right"><span class="eyebrow">Arah pendidikan</span><h2 class="display-6 fw-bold text-navy mb-3">Visi & Misi</h2><p class="text-secondary mb-4">Nilai yang menjadi arah kami dalam menemani setiap proses belajar.</p><a href="<?= htmlspecialchars($base_url . 'profil_view.php?kat=visi', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-sage rounded-pill px-4">Selengkapnya <i class="bi bi-arrow-up-right ms-1"></i></a></div>
            <div class="col-lg-7" data-aos="fade-left"><div class="vision-mission-grid"><article class="vision-card"><span class="vision-icon"><i class="bi bi-eye-fill"></i></span><h4 class="fw-bold text-navy">Visi</h4><p class="text-secondary mb-0"><?= htmlspecialchars(substr(str_replace('[BREAK]', ' ', $visi_data['isi'] ?? 'Membangun generasi cerdas dan berkarakter.'), 0, 220), ENT_QUOTES, 'UTF-8'); ?>...</p></article><article class="vision-card"><span class="vision-icon"><i class="bi bi-rocket-takeoff-fill"></i></span><h4 class="fw-bold text-navy">Misi</h4><p class="text-secondary mb-0"><?= htmlspecialchars(substr(str_replace('[BREAK]', ' ', $misi_data['isi'] ?? 'Menyediakan pengalaman belajar yang bermakna.'), 0, 220), ENT_QUOTES, 'UTF-8'); ?>...</p></article></div></div>
        </div>
    </div>
</section>

<section id="berita-terbaru" class="home-section py-5 bg-sage-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold text-navy">Berita & Kegiatan Terbaru</h2>
            <hr class="mx-auto section-rule">
        </div>
        <div class="row g-4">
            <?php
            // Sesuaikan kolom 'id' menjadi 'id_berita'
            $sql_news = mysqli_query($conn, "SELECT * FROM berita WHERE status='tampil' ORDER BY id_berita DESC LIMIT 3");
            while ($bn = mysqli_fetch_array($sql_news)):
            ?>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-dukuhbenda02 news-card">
                        <img src="<?= $base_url; ?>assets/img/<?= $bn['gambar']; ?>" class="card-img-top news-image" style="height: 220px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3"><?= $bn['judul']; ?></h5>
                            <p class="text-muted small mb-4"><?= substr(strip_tags($bn['isi']), 0, 100); ?>...</p>
                            <a href="<?= $base_url; ?>berita_view.php?id=<?= $bn['id_berita']; ?>" class="btn btn-link text-sage fw-bold p-0 text-decoration-none">
                                Selengkapnya <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="home-section py-5 bg-white">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4"><div><span class="eyebrow">Capaian siswa</span><h2 class="display-6 fw-bold text-navy mb-2">Prestasi terbaru</h2><p class="text-muted mb-0">Momen yang layak dirayakan bersama.</p></div><a href="<?= htmlspecialchars($base_url . 'prestasi.php', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-sage rounded-pill px-4">Lihat semua <i class="bi bi-arrow-right ms-1"></i></a></div>
        <div class="row g-4">
            <?php
            $prestasi_stmt = mysqli_prepare($conn, "SELECT * FROM prestasi ORDER BY tgl_prestasi DESC LIMIT 3");
            mysqli_stmt_execute($prestasi_stmt);
            $prestasi_result = mysqli_stmt_get_result($prestasi_stmt);
            while ($prestasi_home = mysqli_fetch_assoc($prestasi_result)):
            ?>
                <div class="col-md-4" data-aos="fade-up"><article class="card-dukuhbenda02 achievement-card h-100 p-4"><span class="small text-amber text-uppercase fw-bold"><?= htmlspecialchars($prestasi_home['kategori'], ENT_QUOTES, 'UTF-8'); ?></span><h4 class="fw-bold text-navy mt-3 mb-2"><?= htmlspecialchars($prestasi_home['judul_prestasi'], ENT_QUOTES, 'UTF-8'); ?></h4><p class="text-muted small mb-3"><?= htmlspecialchars(substr($prestasi_home['keterangan'], 0, 120), ENT_QUOTES, 'UTF-8'); ?>...</p><span class="small text-secondary"><i class="bi bi-calendar3 me-1 text-amber"></i><?= date('d/m/Y', strtotime($prestasi_home['tgl_prestasi'])); ?></span></article></div>
            <?php endwhile; mysqli_stmt_close($prestasi_stmt); ?>
        </div>
    </div>
</section>

<section class="home-section py-5 bg-sage-light">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4"><div><span class="eyebrow">Momen sekolah</span><h2 class="display-6 fw-bold text-navy mb-2">Galeri kegiatan</h2><p class="text-muted mb-0">Potret kecil dari hari-hari yang penuh cerita.</p></div><a href="<?= htmlspecialchars($base_url . 'galeri.php', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-sage rounded-pill px-4">Lihat galeri lengkap <i class="bi bi-arrow-up-right ms-1"></i></a></div>
        <div class="editorial-gallery" data-aos="fade-up">
            <?php
            $gallery_stmt = mysqli_prepare($conn, "SELECT * FROM galeri WHERE tipe_sumber = 'upload' ORDER BY id_galeri DESC LIMIT 5");
            mysqli_stmt_execute($gallery_stmt);
            $gallery_result = mysqli_stmt_get_result($gallery_stmt);
            while ($gallery_home = mysqli_fetch_assoc($gallery_result)):
            ?>
                <a href="<?= htmlspecialchars($base_url . 'galeri.php', ENT_QUOTES, 'UTF-8'); ?>" class="gallery-tile" aria-label="Lihat galeri <?= htmlspecialchars($gallery_home['judul'], ENT_QUOTES, 'UTF-8'); ?>"><img src="<?= htmlspecialchars($base_url . 'assets/img/' . $gallery_home['sumber'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($gallery_home['judul'], ENT_QUOTES, 'UTF-8'); ?>"><span><?= htmlspecialchars($gallery_home['judul'], ENT_QUOTES, 'UTF-8'); ?></span></a>
            <?php endwhile; mysqli_stmt_close($gallery_stmt); ?>
        </div>
    </div>
</section>

<section class="home-section py-5 bg-sand-light">
    <div class="container"><div class="row g-4 align-items-center"><div class="col-lg-4"><span class="eyebrow">Tetap terhubung</span><h2 class="display-6 fw-bold text-navy mb-3">Pengumuman sekolah</h2><p class="text-secondary mb-0">Informasi penting untuk keluarga besar SDN Dukuhbenda 02.</p></div><div class="col-lg-8"><div class="announcement-timeline">
        <?php $q_peng = mysqli_query($conn, "SELECT * FROM pengumuman WHERE status='aktif' ORDER BY tanggal DESC LIMIT 3"); if (mysqli_num_rows($q_peng) > 0): while ($p = mysqli_fetch_array($q_peng)): ?>
            <article class="timeline-item"><span class="badge bg-amber-subtle text-amber mb-2"><?= date('d M Y', strtotime($p['tanggal'])); ?></span><h5 class="fw-bold text-navy mb-2"><?= htmlspecialchars($p['judul'], ENT_QUOTES, 'UTF-8'); ?></h5><?php if (!empty($p['dokumen'])): ?><a href="<?= htmlspecialchars($base_url . 'assets/doc/' . $p['dokumen'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="small text-amber fw-semibold text-decoration-none"><i class="bi bi-file-earmark-pdf me-1"></i>Lihat lampiran</a><?php endif; ?></article>
        <?php endwhile; else: ?><p class="text-muted mb-0">Belum ada pengumuman aktif.</p><?php endif; ?>
    </div></div></div></div>
</section>

<section id="hubungi-kami" class="home-section py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold text-navy">Hubungi Kami</h2>
            <hr class="mx-auto section-rule">
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 contact-card">
                    <h5 class="fw-bold mb-4">Kirim Pesan</h5>
                    <form action="<?= $base_url; ?>proses_kontak.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control bg-light border-0 py-2 px-3" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2 px-3" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nomor Telepon/WA</label>
                            <input type="text" name="telepon" class="form-control bg-light border-0 py-2 px-3" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Subjek</label>
                            <input type="text" name="subjek" class="form-control bg-light border-0 py-2 px-3" placeholder="Tanya PPDB / Info Sekolah" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Pesan</label>
                            <textarea name="isi_pesan" class="form-control bg-light border-0 py-2 px-3" rows="4" placeholder="Tuliskan pesan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">Kirim Pesan Sekarang</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-sage-light contact-card">
                    <h5 class="fw-bold mb-4">Informasi Sekolah</h5>
                    <div class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                        <p class="small mb-0 text-secondary">Jl. Dukuhbenda, Kec. Bumijawa, Tegal, Jawa Tengah.</p>
                    </div>
                    <div class="rounded-3 overflow-hidden border mb-4" style="height: 250px;">
                        <iframe src="https://maps.google.com/maps?q=SDN+Dukuhbenda+02&t=&z=16&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold small d-block">Kontak:</label>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                            <span class="small text-secondary">(0283) 123456</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            <span class="small text-secondary">info@sdndukuhbenda.sch.id</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_GET['status']) && $_GET['status'] == 'terkirim'): ?>
    <script>
        Swal.fire({
            title: "Pesan Terkirim!",
            text: "Terima kasih, kami akan segera merespons pesan Anda.",
            icon: "success",
            timer: 3500,
            showConfirmButton: false,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        });
    </script>
<?php endif; ?>