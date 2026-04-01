<?php
require 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    $insert = mysqli_query($koneksi, "INSERT INTO buku (isbn, judul, pengarang, penerbit, tahun_terbit, stok) 
              VALUES ('$isbn', '$judul', '$pengarang', '$penerbit', '$tahun', '$stok')");

    if ($insert) {
        header("Location: buku_tampil.php?status=success");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

include 'layout/header.php';
?>

<h2>Tambah Buku</h2>

<form method="POST">
    <div class="form-group">
        <label>ISBN</label>
        <input type="text" name="isbn" required placeholder="Contoh: 978-602-...">
    </div>
    <div class="form-group">
        <label>Judul Buku</label>
        <input type="text" name="judul" required placeholder="Judul Lengkap">
    </div>
    <div class="form-group">
        <label>Pengarang</label>
        <input type="text" name="pengarang" required placeholder="Nama Pengarang">
    </div>
    <div class="form-group">
        <label>Penerbit</label>
        <input type="text" name="penerbit" required placeholder="Nama Penerbit">
    </div>
    <div class="form-group">
        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" required placeholder="2024">
    </div>
    <div class="form-group">
        <label>Stok</label>
        <input type="number" name="stok" required placeholder="Jumlah Buku">
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="buku_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
