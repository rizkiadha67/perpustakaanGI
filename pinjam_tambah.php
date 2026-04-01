<?php
require 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tgl_pinjam = $_POST['tgl_pinjam'];

    // Cek stok buku
    $cek_stok = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku = $id_buku");
    $data_stok = mysqli_fetch_assoc($cek_stok);

    if ($data_stok['stok'] > 0) {
        $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (id_buku, id_anggota, tgl_pinjam, status) 
                  VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', 'Pinjam')");
        
        if ($insert) {
            // Kurangi stok buku
            mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE id_buku = $id_buku");
            header("Location: pinjam_tampil.php?status=success");
        } else {
            echo "Gagal: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Stok buku habis!'); window.location='pinjam_tambah.php';</script>";
    }
}

include 'layout/header.php';
?>

<h2>Tambah Peminjaman</h2>

<form method="POST">
    <div class="form-group">
        <label>Buku</label>
        <select name="id_buku" required>
            <option value="">-- Pilih Buku --</option>
            <?php
            $q_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE stok > 0");
            while ($b = mysqli_fetch_array($q_buku)) {
                echo "<option value='$b[id_buku]'>$b[judul] (Stok: $b[stok])</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Anggota</label>
        <select name="id_anggota" required>
            <option value="">-- Pilih Anggota --</option>
            <?php
            $q_anggota = mysqli_query($koneksi, "SELECT * FROM anggota");
            while ($a = mysqli_fetch_array($q_anggota)) {
                echo "<option value='$a[id_anggota]'>$a[nama] ($a[nim])</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    
    <div style="margin-top: 10px;">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="pinjam_tampil.php" class="btn btn-danger">Batal</a>
    </div>
</form>

<?php include 'layout/footer.php'; ?>
