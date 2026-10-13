<?php include '../../../config/config.php';
include '../../cek_session.php';

// Menangkap kategori dari URL
$kat = isset($_GET['kat']) ? $_GET['kat'] : '';

// Pemetaan Nama Tampilan
$label = [
    'tentang'  => 'Tentang Sekolah',
    'visi'     => 'Visi Sekolah',
    'misi'     => 'Misi Sekolah',
    'struktur' => 'Struktur Organisasi',
    'sejarah'  => 'Sejarah Sekolah'
];

$nama_kategori = isset($label[$kat]) ? $label[$kat] : 'Profil Baru';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Input <?= $nama_kategori; ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Input Konten: <span class="text-primary"><?= $nama_kategori; ?></span></h3>

            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Formulir Pengisian</h5>
                </div>
                <div class="p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="kategori" value="<?= $kat; ?>">

                        <?php if ($kat == 'visi' || $kat == 'misi'): ?>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Poin-poin <?= $nama_kategori; ?></label>
                                <div id="containerPoin">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text fw-bold">1</span>
                                        <input type="text" name="poin[]" class="form-control" placeholder="Masukkan poin pertama..." required>
                                        <button class="btn btn-outline-danger" type="button" onclick="hapusPoin(this)"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-dark btn-sm rounded-pill mt-2" onclick="tambahPoin()">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Baris Nomor
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Isi Konten <?= $nama_kategori; ?></label>
                                <textarea name="isi_biasa" class="form-control" rows="10" placeholder="Tuliskan isi <?= $kat; ?> secara lengkap..." required></textarea>
                            </div>
                        <?php endif; ?>

                        <?php if ($kat == 'struktur'): ?>
                            <div class="mb-4 p-3 bg-light rounded border border-primary">
                                <label class="form-label fw-bold text-primary"><i class="bi bi-diagram-3 me-2"></i> Upload Bagan Struktur (Gambar)</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" required>
                                <div class="form-text text-muted small">*Wajib untuk kategori Struktur Organisasi agar bagan tampil di website.</div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-end gap-2 border-top pt-4">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02 px-5">
                                <i class="bi bi-check-circle me-2"></i> Simpan Konten
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tambahPoin() {
            const container = document.getElementById('containerPoin');
            const rowCount = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
        <span class="input-group-text fw-bold">${rowCount}</span>
        <input type="text" name="poin[]" class="form-control" placeholder="Masukkan poin berikutnya..." required>
        <button class="btn btn-outline-danger" type="button" onclick="hapusPoin(this)"><i class="bi bi-trash"></i></button>
    `;
            container.appendChild(div);
        }

        function hapusPoin(btn) {
            const container = document.getElementById('containerPoin');
            if (container.children.length > 1) {
                btn.closest('.input-group').remove();
                Array.from(container.children).forEach((child, index) => {
                    child.querySelector('.input-group-text').innerText = index + 1;
                });
            }
        }
    </script>
</body>

</html>