<?php
require 'config/koneksi.php';

$id = $_GET['id'];
$delete = mysqli_query($koneksi, "DELETE FROM jurusan WHERE id_jurusan = '$id'");

if ($delete) {
    header("Location: jurusan_tampil.php?status=deleted");
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>
