<?php
require_once '../../../config/config.php';
include '../../cek_session.php';;
$id = $_GET['id'];
$d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pengumuman WHERE id_pengumuman='$id'"));

// Jika data tidak ditemukan, kembali ke index
if (!$d) {
    header("location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pengumuman - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">Edit Pengumuman</h3>
                <a href="index.php" class="btn btn-secondary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i> Batal
                </a>
            </div>

            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Perbarui Data Pengumuman</h5>
                </div>
                <div class="card-body p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_pengumuman']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Pengumuman</label>
                            <input type="text" name="judul" class="form-control rounded-pill" value="<?= $d['judul']; ?>" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Tampil</label>
                                <input type="date" name="tanggal" class="form-control rounded-pill" value="<?= $d['tanggal']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select rounded-pill">
                                    <option value="aktif" <?= ($d['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif (Tampilkan)</option>
                                    <option value="arsip" <?= ($d['status'] == 'arsip') ? 'selected' : ''; ?>>Arsip (Sembunyikan)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Pengumuman</label>
                            <textarea name="isi" class="form-control rounded-4" rows="5"><?= $d['isi']; ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Dokumen Saat Ini</label>
                            <?php if (!empty($d['dokumen'])): ?>
                                <div class="p-3 bg-light border rounded-3 mb-2 d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf fs-3 text-danger me-3"></i>
                                    <span class="small text-muted"><?= $d['dokumen']; ?></span>
                                </div>
                            <?php else: ?>
                                <p class="small text-muted italic">Tidak ada lampiran dokumen.</p>
                            <?php endif; ?>

                            <label class="form-label fw-bold">Ganti Dokumen (PDF/Gambar)</label>
                            <input type="file" name="dokumen" class="form-control rounded-pill">
                            <div class="form-text small">*Biarkan kosong jika tidak ingin mengganti file.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02 px-5">
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