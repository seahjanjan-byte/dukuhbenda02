<?php
include '../../../config/config.php';
include '../../cek_session.php';
$id = $_GET['id'];
// REVISI: Query menggunakan id_guru
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM guru WHERE id_guru='$id'"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Guru - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Data Tenaga Pengajar</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i> Ubah Profil Guru</h5>
                </div>
                <div class="card-Dukuhbenda 02-body p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $data['id_guru']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="<?= $data['jabatan']; ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Foto Profil</label>
                            <img src="../../../assets/img/<?= $data['foto']; ?>" width="100" class="rounded-circle shadow-sm mb-3 border">
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <div class="form-text small">*Biarkan kosong jika tidak ingin mengganti foto.</div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>