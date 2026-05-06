<?php
require 'config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE id_jurusan = '$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);

    $update = mysqli_query($koneksi, "UPDATE jurusan SET nama_jurusan = '$nama' WHERE id_jurusan = '$id'");

    if ($update) {
        header("Location: jurusan_tampil.php?status=updated");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

include 'layout/header.php';
?>

<h2>Edit Jurusan</h2>

<form method="POST">
    <div class="form-group">
        <label>Nama Jurusan</label>
        <input type="text" name="nama_jurusan" value="<?php echo $data['nama_jurusan']; ?>" required>
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="jurusan_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
