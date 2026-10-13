<?php include '../../../config/config.php';
include '../../cek_session.php';
$d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM profil WHERE kategori='struktur'"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Struktur - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body style="background-color: #f8f9fa;">
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Kelola Struktur Organisasi</h3>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-diagram-3 me-2"></i> Bagan Struktur Sekolah</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-5">
                        <?php if ($d && !empty($d['gambar'])): ?>
                            <img src="../../../assets/img/<?= $d['gambar']; ?>" class="img-fluid border p-2 bg-white shadow-sm rounded" style="max-height: 400px;">
                        <?php else: ?>
                            <div class="py-5 bg-light rounded-4 border border-dashed text-muted">Belum ada gambar bagan struktur.</div>
                        <?php endif; ?>
                    </div>
                    <form action="proses.php" method="POST" enctype="multipart/form-data" class="text-start">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ganti Bagan (Gambar)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="../profil/index.php" class="btn btn-secondary px-4 rounded-pill fw-bold">Kembali</a>
                            <button type="submit" name="update" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>