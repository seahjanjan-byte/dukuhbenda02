<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Guru - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">Input Data Guru</h3>
            </div>

            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-workspace me-2"></i> Profil Guru Baru</h5>
                </div>
                <div class="card-Dukuhbenda 02-body p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jabatan / Wali Kelas</label>
                                    <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Wali Kelas 6 / Guru PAI" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Foto Profil</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                                    <div class="form-text">Pastikan foto dalam posisi portrait (3x4/4x6).</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-3 d-flex justify-content-end">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i> Simpan Data Guru
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