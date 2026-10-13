<?php
include '../../../config/config.php';
include '../../cek_session.php';

// REVISI: Mengambil ID Slider (String)
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = mysqli_query($conn, "SELECT * FROM slider WHERE id_slider='$id'");
$d = mysqli_fetch_array($sql);

if (!$d) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Slider - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body style="background-color: #f8f9fa;">

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>

        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Slider</h3>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Form Edit Slider</h5>
                </div>
                <div class="card-body p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_slider']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Utama</label>
                            <input type="text" name="judul" class="form-control" value="<?= $d['judul']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Subjudul / Keterangan</label>
                            <input type="text" name="subjudul" class="form-control" value="<?= $d['subjudul']; ?>" required>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold d-block">Gambar Saat Ini</label>
                                <img src="../../../assets/img/<?= $d['gambar']; ?>" class="img-fluid rounded shadow-sm border mb-2" style="max-height: 150px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <div class="form-text mt-2">*Biarkan kosong jika tidak ingin mengganti gambar.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">
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