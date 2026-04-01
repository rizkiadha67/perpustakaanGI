<?php
require 'config/koneksi.php';
include 'layout/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Daftar Anggota</h2>
    <a href="anggota_tambah.php" class="btn btn-primary">Tambah Anggota</a>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>L/P</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id_anggota DESC");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nim']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['jurusan']; ?></td>
                <td><?php echo $data['jenis_kelamin']; ?></td>
                <td>
                    <a href="anggota_edit.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-warning">Edit</a>
                    <a href="anggota_hapus.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus anggota ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'layout/footer.php'; ?>
