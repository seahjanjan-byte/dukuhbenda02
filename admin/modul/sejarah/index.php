<?php include '../../../config/config.php';
include '../../cek_session.php';
// Mengambil data sejarah dari database
$sql = mysqli_query($conn, "SELECT * FROM profil WHERE kategori='sejarah'");
$d = mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Sejarah Sekolah - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body style="background-color: #f8f9fa;">

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <h3 class="fw-bold m-0 mb-4">Kelola Sejarah Sekolah</h3>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i> Konten Teks Sejarah Sekolah</h5>
                </div>
                <div class="card-body p-4">
                    <form action="proses.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <label class="fw-bold text-muted mb-3">Isi Teks Sejarah:</label>

                        <div class="mb-4">
                            <textarea name="isi" class="form-control bg-light border border-primary" rows="15" style="line-height: 1.8;" required><?= $d['isi'] ?? ''; ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="../profil/index.php" class="btn btn-secondary px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" name="update" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>