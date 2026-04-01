<?php
require 'config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($koneksi, "DELETE FROM anggota WHERE id_anggota = $id");

    if ($delete) {
        header("Location: anggota_tampil.php?status=deleted");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>
