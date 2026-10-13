<?php
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input untuk keamanan database
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon   = mysqli_real_escape_string($conn, $_POST['telepon']);
    $subjek    = mysqli_real_escape_string($conn, $_POST['subjek']);
    $isi_pesan = mysqli_real_escape_string($conn, $_POST['isi_pesan']);
    $tanggal   = date('Y-m-d H:i:s');

    $result_id = mysqli_query(
        $conn,
        "SELECT id_pesan FROM pesan
         WHERE id_pesan LIKE 'PSN%'
         ORDER BY CAST(SUBSTRING(id_pesan, 4) AS UNSIGNED) DESC
         LIMIT 1"
    );
    $last_id = mysqli_fetch_assoc($result_id);
    $next_number = $last_id ? (int) substr($last_id['id_pesan'], 3) + 1 : 1;
    $id_pesan = 'PSN' . str_pad((string) $next_number, 3, '0', STR_PAD_LEFT);

    // Query untuk menyimpan pesan ke tabel pesan
    $query = "INSERT INTO pesan (id_pesan, nama, email, telepon, subjek, isi_pesan, tanggal, status, is_pinned)
              VALUES ('$id_pesan', '$nama', '$email', '$telepon', '$subjek', '$isi_pesan', '$tanggal', 'belum', '0')";

    if (mysqli_query($conn, $query)) {
        // Berhasil: Kembali ke beranda dengan parameter status untuk memicu SweetAlert2
        // Menggunakan $base_url agar navigasi tidak putus saat hosting
        header("location:" . $base_url . "index.php?status=terkirim#hubungi-kami");
        exit();
    } else {
        // Gagal: Tampilkan error (opsional: bisa di-redirect dengan status error)
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika diakses langsung tanpa POST, kembalikan ke beranda
    header("location:" . $base_url . "index.php");
    exit();
}
?>