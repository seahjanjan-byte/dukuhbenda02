<?php
include '../../../config/config.php';
include '../../cek_session.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tentang Sekolah - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body class="admin-body">
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold m-0">Kelola Tentang Sekolah</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active"><a href="../../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tentang Sekolah</li>
                        </ol>
                    </nav>
                </div>
                <a href="../profil/index.php" class="btn btn-secondary px-4 rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <?php
            // Ambil data berdasarkan kategori
            $sql = mysqli_query($conn, "SELECT * FROM profil WHERE kategori='tentang'");
            $d = mysqli_fetch_array($sql);
            ?>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Data berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card-dukuhbenda02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Form Edit Konten</h5>
                </div>
                <div class="card-body p-4">
                    <form action="proses.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_profil'] ?? ''; ?>">

                        <div class="mb-4">
                            <label class="fw-bold text-dark mb-3">Isi Teks Tentang Sekolah:</label>
                            <textarea name="isi" class="form-control rounded-4 shadow-none border-primary"
                                rows="12" style="line-height: 1.8;" required><?= $d['isi'] ?? ''; ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" name="update" class="btn btn-primary-dukuhbenda02 px-5 shadow-sm">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
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