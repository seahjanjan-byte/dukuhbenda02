<?php
include '../../../config/config.php';
include '../../cek_session.php';

$id = $_GET['id'];
// REVISI: Menggunakan id_fasilitas
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM fasilitas WHERE id_fasilitas='$id'"));

if (!$data) {
    die("Data tidak ditemukan...");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Fasilitas - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Ubah Data Fasilitas</h3>
            <div class="card-dukuhbenda02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Formulir Perubahan</h5>
                </div>
                <div class="card-dukuhbenda02-body p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $data['id_fasilitas']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Fasilitas</label>
                            <input type="text" name="nama_fasilitas" class="form-control" value="<?= $data['nama_fasilitas']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required><?= $data['deskripsi']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Gambar Saat Ini</label>
                            <img src="../../../assets/img/<?= $data['gambar']; ?>" width="150" class="rounded shadow-sm mb-2 border">
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <div class="form-text">*Kosongkan jika tidak ingin mengganti gambar.</div>
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