<?php
require 'config/koneksi.php';

include 'layout/header.php';
?>

<div class="d-flex justify-between align-center">
    <h2>Daftar Jurusan</h2>
    <a href="jurusan_tambah.php" class="btn btn-primary">Tambah Jurusan</a>
</div>

<table>
    <thead>
        <tr>
            <th width="50">No</th>
            <th>Nama Jurusan</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
        
        if (mysqli_num_rows($query) == 0) {
            echo "<tr><td colspan='3' style='text-align:center;'>Data tidak ditemukan.</td></tr>";
        }

        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nama_jurusan']; ?></td>
                <td>
                    <a href="jurusan_edit.php?id=<?php echo $data['id_jurusan']; ?>" class="btn btn-warning">Edit</a>
                    <a href="jurusan_hapus.php?id=<?php echo $data['id_jurusan']; ?>" class="btn btn-danger"
                        onclick="return confirm('Yakin hapus jurusan ini? Anggota dengan jurusan ini mungkin akan terpengaruh.')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'layout/footer.php'; ?>
