<?php
include '../../../config/config.php';
include '../../cek_session.php';
$id = $_GET['id'];
$d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM profil WHERE id_profil='$id'"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Profil - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Konten Profil</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0">Ubah Profil: <?= $d['judul']; ?></h5>
                </div>
                <div class="p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_profil']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Profil</label>
                            <input type="text" name="judul" class="form-control" value="<?= $d['judul']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Konten</label>
                            <textarea name="isi" class="form-control" rows="8" required><?= $d['isi']; ?></textarea>
                        </div>
                        <div class="row mb-4">
                            <?php if ($d['gambar']): ?>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold d-block">Gambar Saat Ini</label>
                                    <img src="../../../assets/img/<?= $d['gambar']; ?>" class="img-fluid rounded border">
                                </div>
                            <?php endif; ?>
                            <div class="col-md-9">
                                <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">Update Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>