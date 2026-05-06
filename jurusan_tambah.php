<?php
require 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);

    $insert = mysqli_query($koneksi, "INSERT INTO jurusan (nama_jurusan) VALUES ('$nama')");

    if ($insert) {
        header("Location: jurusan_tampil.php?status=success");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

include 'layout/header.php';
?>

<h2>Tambah Jurusan</h2>

<form method="POST">
    <div class="form-group">
        <label>Nama Jurusan</label>
        <input type="text" name="nama_jurusan" required placeholder="Contoh: Teknik Informatika">
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="jurusan_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
