<?php include '../../../config/config.php';
include '../../cek_session.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Galeri - Admin SDN Dukuhbenda 02</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Tambah Dokumentasi Baru</h3>
            <div class="card-Dukuhbenda 02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Form Galeri</h5>
                </div>
                <div class="p-4">
                    <form action="proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Kegiatan</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Lomba 17 Agustus 2025" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select" id="kategori" required>
                                    <option value="foto">Foto</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Sumber</label>
                                <select name="tipe_sumber" class="form-select" id="tipe_sumber" required>
                                    <option value="upload">Upload File (Lokal)</option>
                                    <option value="link_drive">Link Google Drive</option>
                                    <option value="link_youtube">Link YouTube (Hanya Video)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4" id="input_sumber">
                            <label class="form-label fw-bold" id="label_sumber">Pilih File</label>
                            <input type="file" name="file_sumber" id="file_input" class="form-control" accept="image/*">
                            <input type="url" name="url_sumber" id="url_input" class="form-control d-none" placeholder="Tempel link di sini...">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">
                                <i class="bi bi-check-circle me-2"></i> Simpan Media
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const tipe = document.getElementById('tipe_sumber');
        const fileInput = document.getElementById('file_input');
        const urlInput = document.getElementById('url_input');
        const label = document.getElementById('label_sumber');

        tipe.addEventListener('change', function() {
            if (this.value === 'upload') {
                fileInput.classList.remove('d-none');
                fileInput.required = true;
                urlInput.classList.add('d-none');
                urlInput.required = false;
                label.innerText = "Pilih File";
            } else {
                fileInput.classList.add('d-none');
                fileInput.required = false;
                urlInput.classList.remove('d-none');
                urlInput.required = true;
                label.innerText = "Masukkan URL / Link";
            }
        });
    </script>
</body>

</html>