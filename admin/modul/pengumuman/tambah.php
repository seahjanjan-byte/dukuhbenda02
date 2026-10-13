<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Pengumuman - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Tambah Pengumuman Baru</h3>
                <a href="index.php" class="btn btn-secondary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Input Data Pengumuman</h5>
                </div>
                <div class="card-body p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Pengumuman</label>
                            <input type="text" name="judul" class="form-control rounded-pill" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Tampil</label>
                                <input type="date" name="tanggal" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select rounded-pill">
                                    <option value="aktif">Aktif (Tampilkan)</option>
                                    <option value="arsip">Arsip (Sembunyikan)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Pengumuman</label>
                            <textarea name="isi" class="form-control rounded-4" rows="5"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Lampiran Dokumen (PDF/Gambar)</label>
                            <input type="file" name="dokumen" class="form-control rounded-pill">
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">
                                <i class="bi bi-check-circle me-2"></i> Simpan Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>