<?php
require_once '../../../config/config.php';
include '../../cek_session.php';

// REVISI: JOIN dengan admin untuk membuktikan relasi dan ganti ID
$sql = mysqli_query($conn, "SELECT pengumuman.*, admin.username FROM pengumuman 
                            JOIN admin ON pengumuman.id_admin = admin.id_admin 
                            ORDER BY pengumuman.tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Pengumuman - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Pengumuman Sekolah</h3>
                <a href="tambah.php" class="btn-primary-dukuhbenda02 text-decoration-none">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Pengumuman
                </a>
            </div>

            <div class="card-dukuhbenda02">
                <div class="card-header-blue">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-megaphone me-2"></i> Daftar Pengumuman</h5>
                </div>
                <div class="p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4" width="5%">No</th>
                                <th>Judul & Dokumen</th>
                                <th width="15%">Tanggal</th>
                                <th width="10%">Status</th>
                                <th class="text-center" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($sql) > 0):
                                while ($d = mysqli_fetch_array($sql)):
                            ?>
                                    <tr>
                                        <td class="px-4 fw-bold"><?= $no++; ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= $d['judul']; ?></div>
                                            <small class="text-muted" style="font-size: 10px;">Oleh: <?= $d['username']; ?></small><br>
                                            <?php if (!empty($d['dokumen'])): ?>
                                                <small class="text-danger fw-bold"><i class="bi bi-file-earmark-pdf"></i> Ada Lampiran</small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($d['tanggal'])); ?></td>
                                        <td>
                                            <span class="badge <?= $d['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= ucfirst($d['status']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <?php if ($d['status'] == 'aktif'): ?>
                                                    <form method="POST" action="proses.php" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_pengumuman'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        <input type="hidden" name="aksi" value="status">
                                                        <input type="hidden" name="set" value="arsip">
                                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                                        <button type="submit" class="btn btn-sm btn-dark px-3" title="Arsipkan">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form method="POST" action="proses.php" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_pengumuman'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        <input type="hidden" name="aksi" value="status">
                                                        <input type="hidden" name="set" value="aktif">
                                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                                        <button type="submit" class="btn btn-sm btn-info text-white px-3" title="Tampilkan">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <a href="edit.php?id=<?= $d['id_pengumuman']; ?>" class="btn btn-sm btn-warning px-3"><i class="bi bi-pencil-square"></i></a>
                                                <form method="POST" action="proses.php" class="d-inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_pengumuman'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <input type="hidden" name="aksi" value="hapus">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger px-3"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                endwhile;
                            else:
                                echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data.</td></tr>";
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>