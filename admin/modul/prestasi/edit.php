<?php
include '../../../config/config.php';
include '../../cek_session.php';

// REVISI: Mengambil ID Prestasi (String/Varchar) dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// REVISI: Query menggunakan kolom id_prestasi
$query = mysqli_query($conn, "SELECT * FROM prestasi WHERE id_prestasi='$id'");
$data = mysqli_fetch_array($query);

// Jika data tidak ditemukan, kembali ke halaman utama
if (!$data) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Prestasi - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Data Prestasi</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Perbarui Data</h5>
                </div>
                <div class="card-Dukuhbenda 02-body p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $data['id_prestasi']; ?>">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Prestasi</label>
                                    <input type="text" name="judul_prestasi" class="form-control" value="<?= $data['judul_prestasi']; ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tanggal Prestasi</label>
                                        <input type="date" name="tgl_prestasi" class="form-control" value="<?= $data['tgl_prestasi']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <select name="kategori" class="form-select" required>
                                            <option value="akademik" <?= ($data['kategori'] == 'akademik') ? 'selected' : ''; ?>>Akademik</option>
                                            <option value="non-akademik" <?= ($data['kategori'] == 'non-akademik') ? 'selected' : ''; ?>>Non-Akademik</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Guru Pembimbing</label>
                                    <select name="id_guru" class="form-select" required>
                                        <option value="">-- Pilih Guru Pembimbing --</option>
                                        <?php
                                        $gurus = mysqli_query($conn, "SELECT id_guru, nama FROM guru ORDER BY nama ASC");
                                        while ($g = mysqli_fetch_array($gurus)) {
                                            $selected = ($g['id_guru'] == $data['id_guru']) ? 'selected' : '';
                                            echo "<option value='" . $g['id_guru'] . "' $selected>" . $g['nama'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <label class="form-label fw-bold d-block">Gambar Saat Ini</label>
                                <?php if (!empty($data['gambar'])): ?>
                                    <img src="../../../assets/img/<?= $data['gambar']; ?>" class="rounded shadow-sm border mb-2" style="max-height: 120px; width: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light border rounded mb-2 d-flex align-items-center justify-content-center" style="height: 120px;">
                                        <span class="text-muted small">Tanpa Gambar</span>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <div class="form-text small text-start">*Kosongkan jika tidak ingin mengganti gambar.</div>
                            </div>
                        </div>

                        <div class="mb-4 mt-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="5" required><?= $data['keterangan']; ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02 px-4">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
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