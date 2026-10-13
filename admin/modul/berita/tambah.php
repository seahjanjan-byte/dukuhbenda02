<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Berita - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">Tambah Berita Baru</h3>
                <a href="index.php" class="btn btn-secondary-dukuhbenda02 text-decoration-none">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card-dukuhbenda02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Formulir Konten Berita</h5>
                </div>
                <div class="card-dukuhbenda02-body p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Berita</label>
                            <input type="text" name="judul" class="form-control form-control-lg" placeholder="Masukkan judul berita..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Berita</label>
                            <textarea name="isi" class="form-control" rows="10" placeholder="Tuliskan isi berita secara lengkap..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Sampul</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <div class="form-text mt-2 text-muted italic small">*Format: JPG, PNG, atau WebP. Maksimal 2MB.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" name="simpan" class="btn-primary-dukuhbenda02">
                                <i class="bi bi-send me-2"></i> Posting Berita Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>