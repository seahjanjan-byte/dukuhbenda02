<?php
include '../../../config/config.php';
include '../../cek_session.php';
// Ambil data terbaru
$sql = mysqli_query($conn, "SELECT * FROM profil WHERE kategori='tentang'");
$d = mysqli_fetch_array($sql);

// Jika data tidak ada di DB, beri peringatan
if (!$d) {
    echo "<script>alert('Data kategori tentang tidak ditemukan di database! Jalankan SQL INSERT dulu.'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Tentang Sekolah - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Ubah Tentang Sekolah</h3>
                <a href="index.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
            </div>

            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0">Formulir Edit Teks</h5>
                </div>
                <div class="p-4">
                    <form action="proses.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Isi Tentang Sekolah (Hanya Teks)</label>
                            <textarea name="isi" class="form-control rounded-4" rows="12" required><?= htmlspecialchars($d['isi']); ?></textarea>
                            <div class="form-text mt-2 text-primary small">
                                <i class="bi bi-info-circle"></i> Gunakan enter untuk membuat baris baru. Teks akan tampil otomatis di halaman depan.
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" name="update" class="btn-primary-dukuhbenda02 px-5 shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>