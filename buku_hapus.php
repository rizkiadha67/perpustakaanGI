<?php
require 'config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku = $id");

    if ($delete) {
        header("Location: buku_tampil.php?status=deleted");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>
