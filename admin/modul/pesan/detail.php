<?php
include '../../../config/config.php';
include '../../cek_session.php';

// REVISI: Mengambil ID pesan (String) dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);
$admin_id = $_SESSION['admin_id'];

// REVISI: Update status dan catat admin yang membaca sesuai aturan relasi
mysqli_query($conn, "UPDATE pesan SET status='dibaca', id_admin_pembaca='$admin_id' WHERE id_pesan='$id'");

// REVISI: Query menggunakan kolom id_pesan
$query = mysqli_query($conn, "SELECT * FROM pesan WHERE id_pesan='$id'");
$d = mysqli_fetch_array($query);

if (!$d) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

$wa_number = preg_replace('/[^0-9]/', '', $d['telepon']);
if (substr($wa_number, 0, 1) === '0') {
    $wa_number = '62' . substr($wa_number, 1);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Baca Pesan - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body style="background-color: #f8f9fa;">
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0 text-dark">Baca Pesan Masuk</h3>
                <a href="index.php" class="btn btn-secondary px-4 rounded-pill shadow-sm fw-bold">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Inbox
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-envelope-open-fill me-2"></i> Detail Pesan</h5>
                        <?php if ($d['is_pinned'] == '1'): ?>
                            <span class="badge bg-warning text-dark rounded-pill px-3"><i class="bi bi-pin-angle-fill me-1"></i> Tersemat</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Nama Pengirim</label>
                            <p class="fs-5 fw-bold text-dark mb-0"><?= htmlspecialchars($d['nama']); ?></p>
                        </div>
                        <div class="col-md-4 border-start ps-md-4">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Kontak Telepon / WA</label>
                            <div class="d-flex align-items-center">
                                <p class="fs-5 fw-bold text-dark mb-0 me-3"><?= htmlspecialchars($d['telepon']); ?></p>
                                <a href="https://wa.me/<?= $wa_number; ?>" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                                    <i class="bi bi-whatsapp me-2"></i> Balas di WA
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 border-start ps-md-4">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Diterima Pada</label>
                            <p class="fs-6 fw-semibold text-muted mb-0"><?= date('d F Y, H:i', strtotime($d['tanggal'])); ?> WIB</p>
                        </div>
                    </div>

                    <hr class="opacity-10 mb-5">

                    <div class="message-content">
                        <div class="mb-4">
                            <label class="text-muted small text-uppercase fw-bold mb-2">Subjek Pesan:</label>
                            <h4 class="fw-bold text-primary"><?= htmlspecialchars($d['subjek']); ?></h4>
                        </div>

                        <label class="text-muted small text-uppercase fw-bold mb-2">Isi Pesan:</label>
                        <div class="p-4 bg-light rounded-4 border-0 shadow-none text-dark" style="line-height: 1.8; font-size: 1.1rem; min-height: 250px;">
                            <?= nl2br(htmlspecialchars($d['isi_pesan'])); ?>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-end align-items-center border-top pt-4">
                        <div class="d-flex gap-2">
                            <form method="POST" action="proses.php" class="d-inline">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_pesan'], ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="aksi" value="status">
                                <input type="hidden" name="set" value="arsip">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <button type="submit" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                                    <i class="bi bi-archive me-2"></i> Arsipkan Pesan
                                </button>
                            </form>
                            <form method="POST" action="proses.php" class="d-inline" onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_pesan'], ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="aksi" value="hapus">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <button type="submit" class="btn btn-danger px-4 rounded-pill fw-bold">
                                    <i class="bi bi-trash me-2"></i> Hapus Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>