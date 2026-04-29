<?php
require 'config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = $id");
$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];

    $update = mysqli_query($koneksi, "UPDATE anggota SET 
              nim = '$nim', nama = '$nama', jurusan = '$jurusan', 
              alamat = '$alamat', jenis_kelamin = '$jk' 
              WHERE id_anggota = $id");

    if ($update) {
        header("Location: anggota_tampil.php?status=updated");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

include 'layout/header.php';
?>

<h2>Edit Anggota</h2>

<form method="POST">
    <div class="form-group">
        <label>NIM</label>
        <input type="text" name="nim" value="<?php echo $data['nim']; ?>" required>
    </div>
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
    </div>
    <div class="form-group">
        <label>Jurusan</label>
        <input type="text" name="jurusan" value="<?php echo $data['jurusan']; ?>" required>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; min-height: 80px;"><?php echo $data['alamat']; ?></textarea>
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="L" <?php if ($data['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
            <option value="P" <?php if ($data['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
        </select>
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="anggota_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
