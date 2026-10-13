<?php
include '../../../config/config.php';
include '../../cek_session.php';
$id = $_GET['id'];
// REVISI: Mencari berdasarkan id_galeri
$d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM galeri WHERE id_galeri='$id'"));

if (!$d) {
    die("Data tidak ditemukan...");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Galeri - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <h3 class="fw-bold mb-4">Edit Dokumentasi</h3>
            <div class="card-dukuhbenda02">
                <div class="card-header-blue text-white">
                    <h5 class="mb-0">Ubah Data Media</h5>
                </div>
                <div class="p-4">
                    <form action="proses.php?aksi=edit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="id" value="<?= $d['id_galeri']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Kegiatan</label>
                            <input type="text" name="judul" class="form-control" value="<?= $d['judul']; ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select" id="kategori" required>
                                    <option value="foto" <?= $d['kategori'] === 'foto' ? 'selected' : ''; ?>>Foto</option>
                                    <option value="video" <?= $d['kategori'] === 'video' ? 'selected' : ''; ?>>Video</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Sumber</label>
                                <select name="tipe_sumber" class="form-select" id="tipe_sumber" required>
                                    <option value="upload" <?= $d['tipe_sumber'] === 'upload' ? 'selected' : ''; ?>>Upload File (Lokal)</option>
                                    <option value="link_drive" <?= $d['tipe_sumber'] === 'link_drive' ? 'selected' : ''; ?>>Link Google Drive</option>
                                    <option value="link_youtube" <?= $d['tipe_sumber'] === 'link_youtube' ? 'selected' : ''; ?>>Link YouTube (Hanya Video)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold" id="label_sumber">Sumber Saat Ini</label>
                            <p class="small text-truncate border p-2 bg-light mb-3"><?= htmlspecialchars($d['sumber'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <input type="file" name="file_sumber" id="file_input" class="form-control <?= $d['tipe_sumber'] === 'upload' ? '' : 'd-none'; ?>" accept="image/*">
                            <input type="url" name="url_sumber" id="url_input" class="form-control <?= $d['tipe_sumber'] === 'upload' ? 'd-none' : ''; ?>" placeholder="Tempel link baru di sini...">
                            <div class="form-text">Kosongkan sumber jika hanya ingin mengubah judul.</div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn-cancel-dukuhbenda02 me-2">Batal</a>
                            <button type="submit" class="btn-primary-dukuhbenda02">Update Media</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const tipe = document.getElementById('tipe_sumber');
        const kategori = document.getElementById('kategori');
        const fileInput = document.getElementById('file_input');
        const urlInput = document.getElementById('url_input');

        function updateSourceInput() {
            const upload = tipe.value === 'upload';
            fileInput.classList.toggle('d-none', !upload);
            urlInput.classList.toggle('d-none', upload);
            fileInput.required = false;
            urlInput.required = false;
            if (upload) {
                fileInput.value = '';
            }
        }

        tipe.addEventListener('change', updateSourceInput);
        kategori.addEventListener('change', function() {
            if (this.value === 'foto' && tipe.value === 'link_youtube') {
                tipe.value = 'upload';
                updateSourceInput();
            }
        });
        updateSourceInput();
    </script>
</body>

</html>