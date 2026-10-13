<?php
include '../../../config/config.php';
include '../../cek_session.php';


// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita = '$id'");
$data = mysqli_fetch_array($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("Data tidak ditemukan...");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Berita - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">Edit Berita</h3>
                <a href="index.php" class="btn-secondary-dukuhbenda02 text-decoration-none">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card-dukuhbenda02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Perbarui Konten Berita</h5>
                </div>
                <div class="card-dukuhbenda02-body p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

                        <input type="hidden" name="id" value="<?= $data['id_berita']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Berita</label>
                            <input type="text" name="judul" class="form-control form-control-lg" value="<?= $data['judul']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Berita</label>
                            <textarea name="isi" class="form-control" rows="10" required><?= $data['isi']; ?></textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <label class="form-label d-block fw-bold">Gambar Saat Ini</label>
                                <?php if ($data['gambar'] != ""): ?>
                                    <img src="../../../assets/img/<?= $data['gambar']; ?>" class="img-fluid rounded shadow-sm border" style="max-height: 150px;">
                                <?php else: ?>
                                    <div class="bg-light rounded py-4 text-muted border small">Tidak ada gambar</div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <div class="form-text mt-2 text-muted">*Biarkan kosong jika tidak ingin mengganti gambar sampul.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-4">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" name="update" class="btn-primary-dukuhbenda02 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
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