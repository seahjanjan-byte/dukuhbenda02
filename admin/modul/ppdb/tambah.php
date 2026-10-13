<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Upload Brosur PPDB - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Upload Brosur PPDB Baru</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0">Formulir Brosur</h5>
                </div>
                <div class="p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Gambar Brosur</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <div class="form-text text-muted">*Gunakan gambar dengan resolusi tinggi (JPG/PNG).</div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Awal</label>
                            <select name="status" class="form-select" required>
                                <option value="tutup">Tutup (Belum Ditampilkan)</option>
                                <option value="buka">Buka (Langsung Tampilkan)</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">Upload & Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>