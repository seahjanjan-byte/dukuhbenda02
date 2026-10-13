<?php include '../../../config/config.php';
include '../../cek_session.php';
$d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM profil WHERE kategori='sejarah'"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Sejarah - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Sejarah Sekolah</h3>
            <div class="card-Dukuhbenda 02">
                <div class="p-4">
                    <form action="proses.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Teks Sejarah</label>
                            <textarea name="isi" class="form-control" rows="10" required><?= $d['isi']; ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Sejarah (Opsional)</label>
                            <?php if ($d['gambar']): ?>
                                <img src="../../../assets/img/<?= $d['gambar']; ?>" class="d-block mb-2 rounded border" width="200">
                            <?php endif; ?>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02">Batal</a>
                            <button type="submit" name="update" class="btn-primary-dukuhbenda02">Simpan Sejarah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>