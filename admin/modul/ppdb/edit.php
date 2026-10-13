<?php
include '../../../config/config.php';
include '../../cek_session.php';
// Mengambil ID dari URL
$id = $_GET['id'];
$d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ppdb WHERE id_ppdb='$id'"));

// Jika data tidak ditemukan, kembalikan ke index
if (!$d) {
    header("location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Brosur PPDB - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body class="admin-body">
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Brosur PPDB</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Formulir Perubahan Brosur</h5>
                </div>
                <div class="p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_ppdb']; ?>">

                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold d-block text-start">Brosur Saat Ini</label>
                            <img src="../../../assets/img/<?= $d['gambar']; ?>" class="img-fluid rounded border mb-3 shadow-sm" style="max-height: 300px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ganti Gambar Brosur (Opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <div class="form-text">*Kosongkan jika tidak ingin mengganti gambar.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Pendaftaran</label>
                            <select name="status" class="form-select" required>
                                <option value="tutup" <?= ($d['status'] == 'tutup') ? 'selected' : ''; ?>>Tutup (Sembunyikan dari Website)</option>
                                <option value="buka" <?= ($d['status'] == 'buka') ? 'selected' : ''; ?>>Buka (Tampilkan di Website)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02 px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>