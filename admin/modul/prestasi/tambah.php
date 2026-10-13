<?php include '../../../config/config.php';
include '../../cek_session.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Prestasi - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Tambah Prestasi Baru</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Formulir Prestasi</h5>
                </div>
                <div class="card-Dukuhbenda 02-body p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Prestasi</label>
                                    <input type="text" name="judul_prestasi" class="form-control" placeholder="Contoh: Juara 1 Lomba Adiwiyata" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tanggal Prestasi</label>
                                        <input type="date" name="tgl_prestasi" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <select name="kategori" class="form-select" required>
                                            <option value="akademik">Akademik</option>
                                            <option value="non-akademik">Non-Akademik</option>
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
                                            echo "<option value='" . $g['id_guru'] . "'>" . $g['nama'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar/Sertifikat</label>
                                    <input type="file" name="gambar" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 mt-2">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="5" placeholder="Jelaskan detail prestasi..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02 px-4">Simpan Prestasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>