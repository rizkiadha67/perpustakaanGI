<?php
require 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $jk = $_POST['jenis_kelamin'];

    $insert = mysqli_query($koneksi, "INSERT INTO anggota (nim, nama, jurusan, jenis_kelamin) 
              VALUES ('$nim', '$nama', '$jurusan', '$jk')");

    if ($insert) {
        header("Location: anggota_tampil.php?status=success");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

include 'layout/header.php';
?>

<h2>Tambah Anggota</h2>

<form method="POST">
    <div class="form-group">
        <label>NIM</label>
        <input type="text" name="nim" required placeholder="Contoh: 22001...">
    </div>
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required placeholder="Nama Lengkap">
    </div>
    <div class="form-group">
        <label>Jurusan</label>
        <input type="text" name="jurusan" required placeholder="Contoh: Teknik Informatika">
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="anggota_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
