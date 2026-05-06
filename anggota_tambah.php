<?php
require 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $id_jurusan = $_POST['id_jurusan'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];

    $insert = mysqli_query($koneksi, "INSERT INTO anggota (nim, id_jurusan, nama, alamat, jenis_kelamin) 
              VALUES ('$nim', '$id_jurusan', '$nama', '$alamat', '$jk')");

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
        <select name="id_jurusan" required>
            <option value="">-- Pilih Jurusan --</option>
            <?php
            $q_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
            while($j = mysqli_fetch_array($q_jurusan)) {
                echo "<option value='".$j['id_jurusan']."'>".$j['nama_jurusan']."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" required placeholder="Alamat Lengkap" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; min-height: 80px;"></textarea>
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
