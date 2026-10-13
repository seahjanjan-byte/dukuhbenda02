<?php include '../../../config/config.php';
include '../../cek_session.php';

// Ambil data visi dan misi
$qv = mysqli_query($conn, "SELECT isi FROM profil WHERE kategori='visi'");
$dv = mysqli_fetch_array($qv);
$qm = mysqli_query($conn, "SELECT isi FROM profil WHERE kategori='misi'");
$dm = mysqli_fetch_array($qm);

// NULL CHECK: Jika data tidak ada, berikan array berisi satu string kosong agar form tetap muncul
$isi_visi = isset($dv['isi']) ? $dv['isi'] : '';
$poin_visi = !empty($isi_visi) ? explode("[BREAK]", $isi_visi) : [''];

$isi_misi = isset($dm['isi']) ? $dm['isi'] : '';
$poin_misi = !empty($isi_misi) ? explode("[BREAK]", $isi_misi) : [''];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Visi Misi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body style="background-color: #f8f9fa;">
    <div class="main-wrapper">
        <?php include '../../sidebar.php'; ?>
        <div class="content-main">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Kelola Visi & Misi</h3>
                <a href="../profil/index.php" class="btn btn-secondary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <form action="proses.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold">VISI SEKOLAH</h5>
                    </div>
                    <div class="card-body p-4">
                        <table class="table align-middle" id="tableVisi">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Poin Visi</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($poin_visi as $p): ?>
                                    <tr>
                                        <td class="fw-bold text-center no-urut"><?= $no++; ?></td>
                                        <td><input type="text" name="visi[]" class="form-control border-0 bg-light" value="<?= htmlspecialchars($p); ?>" placeholder="Tulis poin visi..."></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger border-0 btn-sm" onclick="hapusBaris(this)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-dark btn-sm rounded-pill px-3 mt-2" onclick="tambahBaris('tableVisi', 'visi[]')">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Poin Visi
                        </button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold">MISI SEKOLAH</h5>
                    </div>
                    <div class="card-body p-4">
                        <table class="table align-middle" id="tableMisi">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Poin Misi</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($poin_misi as $p): ?>
                                    <tr>
                                        <td class="fw-bold text-center no-urut"><?= $no++; ?></td>
                                        <td><input type="text" name="misi[]" class="form-control border-0 bg-light" value="<?= htmlspecialchars($p); ?>" placeholder="Tulis poin misi..."></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger border-0 btn-sm" onclick="hapusBaris(this)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-dark btn-sm rounded-pill px-3 mt-2" onclick="tambahBaris('tableMisi', 'misi[]')">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Poin Misi
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mb-5">
                    <button type="submit" name="update" class="btn btn-success px-5 rounded-pill shadow-sm fw-bold">
                        <i class="bi bi-check-circle me-2"></i> Simpan Visi & Misi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tambahBaris(tableId, inputName) {
            const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);
            row.innerHTML = `
        <td class="fw-bold text-center no-urut">${rowCount + 1}</td>
        <td><input type="text" name="${inputName}" class="form-control border-0 bg-light" placeholder="Tulis poin..."></td>
        <td class="text-center"><button type="button" class="btn btn-outline-danger border-0 btn-sm" onclick="hapusBaris(this)"><i class="bi bi-trash"></i></button></td>
    `;
        }

        function hapusBaris(btn) {
            const row = btn.parentNode.parentNode;
            const table = row.parentNode;
            if (table.rows.length > 1) {
                row.parentNode.removeChild(row);
                const rows = table.getElementsByClassName('no-urut');
                for (let i = 0; i < rows.length; i++) {
                    rows[i].innerHTML = i + 1;
                }
            } else {
                alert("Minimal harus ada satu poin.");
            }
        }
    </script>
</body>

</html>