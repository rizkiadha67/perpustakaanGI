<?php
require 'config/koneksi.php';

if (isset($_GET['id']) && isset($_GET['id_buku'])) {
    $id = $_GET['id'];
    $id_buku = $_GET['id_buku'];
    $tgl_kembali = date('Y-m-d');

    $update = mysqli_query($koneksi, "UPDATE peminjaman SET 
              tgl_kembali = '$tgl_kembali', status = 'Kembali' 
              WHERE id_pinjam = $id");

    if ($update) {
        // Kembalikan stok buku
        mysqli_query($koneksi, "UPDATE buku SET stok = stok + 1 WHERE id_buku = $id_buku");
        header("Location: pinjam_tampil.php?status=returned");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>
