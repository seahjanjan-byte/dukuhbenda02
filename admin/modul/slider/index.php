<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Slider Beranda - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body style="background-color: #f8f9fa;">

    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Slider Beranda</h3>
                <a href="tambah.php" class="btn btn-primary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Slider
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-images me-2"></i> Daftar Slider Aktif</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3" width="5%">No</th>
                                    <th class="py-3" width="15%">Foto</th>
                                    <th class="py-3">Judul & Subjudul</th>
                                    <th class="py-3 text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                // REVISI: JOIN dengan admin dan ganti id menjadi id_slider
                                $sql = mysqli_query($conn, "SELECT slider.*, admin.username FROM slider 
                                                        JOIN admin ON slider.id_admin = admin.id_admin 
                                                        ORDER BY slider.id_slider DESC");
                                while ($d = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr>
                                        <td class="px-4 fw-bold"><?= $no++; ?></td>
                                        <td>
                                            <img src="../../../assets/img/<?= $d['gambar']; ?>" class="rounded shadow-sm border" style="width: 100px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $d['judul']; ?></div>
                                            <small class="text-muted"><?= $d['subjudul']; ?></small><br>
                                            <small class="text-muted" style="font-size: 10px;">Oleh: <?= $d['username']; ?></small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="edit.php?id=<?= $d['id_slider']; ?>" class="btn btn-warning btn-sm px-3"><i class="bi bi-pencil-square"></i></a>
                                                <form method="POST" action="proses.php" class="d-inline" onsubmit="return confirm('Hapus slider ini?')">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_slider'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <input type="hidden" name="aksi" value="hapus">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm px-3"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>