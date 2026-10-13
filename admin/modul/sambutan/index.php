<?php
include '../../../config/config.php';
include '../../cek_session.php';

// REVISI: Mengambil data sambutan dengan kolom id_profil
$query = mysqli_query($conn, "SELECT * FROM profil WHERE kategori='sambutan' LIMIT 1");
$d = mysqli_fetch_array($query);

// Jika data belum ada di database, siapkan nilai default agar form tidak error
if (!$d) {
    $d = [
        'id_profil' => '', // ID kosong untuk di-handle di proses.php
        'isi' => 'Data belum ada, silakan isi sambutan baru.',
        'gambar' => 'default.jpg'
    ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Sambutan - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5><i class="bi bi-person-badge me-2"></i> Edit Sambutan Kepala Sekolah</h5>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> Sambutan berhasil diperbarui!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="proses.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_profil']; ?>">

                        <div class="row">
                            <div class="col-md-4 text-center">
                                <label class="fw-bold d-block mb-3">Foto Kepala Sekolah</label>
                                <img src="../../../assets/img/<?= $d['gambar']; ?>" class="img-fluid rounded-4 shadow-sm border mb-3" style="max-height: 250px; width: 100%; object-fit: cover;">
                                <input type="file" name="gambar" class="form-control rounded-pill" accept="image/*">
                                <div class="form-text small text-muted">*Gunakan foto portrait (3x4/4x6)</div>
                            </div>
                            <div class="col-md-8">
                                <label class="fw-bold mb-2">Teks Sambutan</label>
                                <textarea name="isi" class="form-control rounded-4" rows="12" required><?= $d['isi']; ?></textarea>
                                <div class="mt-4 d-flex justify-content-end">
                                    <button type="submit" name="update" class="btn-primary-dukuhbenda02 px-5 shadow-sm">
                                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>