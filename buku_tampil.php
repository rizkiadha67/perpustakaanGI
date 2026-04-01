<?php
require 'config/koneksi.php';
include 'layout/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Daftar Buku</h2>
    <a href="buku_tambah.php" class="btn btn-primary">Tambah Buku</a>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ISBN</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['isbn']; ?></td>
                <td><?php echo $data['judul']; ?></td>
                <td><?php echo $data['pengarang']; ?></td>
                <td><?php echo $data['penerbit']; ?></td>
                <td><?php echo $data['tahun_terbit']; ?></td>
                <td><?php echo $data['stok']; ?></td>
                <td>
                    <a href="buku_edit.php?id=<?php echo $data['id_buku']; ?>" class="btn btn-warning">Edit</a>
                    <a href="buku_hapus.php?id=<?php echo $data['id_buku']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'layout/footer.php'; ?>
