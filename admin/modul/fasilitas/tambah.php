<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Fasilitas - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Tambah Fasilitas Baru</h3>
            <div class="card-dukuhbenda02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Input Data Fasilitas</h5>
                </div>
                <div class="card-dukuhbenda02-body p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Fasilitas</label>
                            <input type="text" name="nama_fasilitas" class="form-control" placeholder="Contoh: Perpustakaan Digital" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan fasilitas ini..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Fasilitas</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">
                                <i class="bi bi-check-circle me-2"></i> Simpan Fasilitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>