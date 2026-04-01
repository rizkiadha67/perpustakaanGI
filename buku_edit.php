<?php
require 'config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = $id");
$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    $update = mysqli_query($koneksi, "UPDATE buku SET 
              isbn = '$isbn', judul = '$judul', pengarang = '$pengarang', 
              penerbit = '$penerbit', tahun_terbit = '$tahun', stok = '$stok' 
              WHERE id_buku = $id");

    if ($update) {
        header("Location: buku_tampil.php?status=updated");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

include 'layout/header.php';
?>

<h2>Edit Buku</h2>

<form method="POST">
    <div class="form-group">
        <label>ISBN</label>
        <input type="text" name="isbn" value="<?php echo $data['isbn']; ?>" required>
    </div>
    <div class="form-group">
        <label>Judul Buku</label>
        <input type="text" name="judul" value="<?php echo $data['judul']; ?>" required>
    </div>
    <div class="form-group">
        <label>Pengarang</label>
        <input type="text" name="pengarang" value="<?php echo $data['pengarang']; ?>" required>
    </div>
    <div class="form-group">
        <label>Penerbit</label>
        <input type="text" name="penerbit" value="<?php echo $data['penerbit']; ?>" required>
    </div>
    <div class="form-group">
        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="<?php echo $data['tahun_terbit']; ?>" required>
    </div>
    <div class="form-group">
        <label>Stok</label>
        <input type="number" name="stok" value="<?php echo $data['stok']; ?>" required>
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="buku_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
