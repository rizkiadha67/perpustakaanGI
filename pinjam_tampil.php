<?php
require 'config/koneksi.php';
include 'layout/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Daftar Peminjaman</h2>
    <a href="pinjam_tambah.php" class="btn btn-primary">Tambah Peminjaman</a>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Buku</th>
            <th>Peminjam</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT p.*, b.judul, a.nama 
                                         FROM peminjaman p 
                                         JOIN buku b ON p.id_buku = b.id_buku 
                                         JOIN anggota a ON p.id_anggota = a.id_anggota 
                                         ORDER BY p.id_pinjam DESC");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['judul']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['tgl_pinjam']; ?></td>
                <td><?php echo $data['tgl_kembali'] ?: '-'; ?></td>
                <td>
                    <span style="padding: 3px 8px; border-radius: 4px; font-size: 12px; color: #fff; background: <?php echo $data['status'] == 'Pinjam' ? '#f39c12' : '#27ae60'; ?>;">
                        <?php echo $data['status']; ?>
                    </span>
                </td>
                <td>
                    <?php if ($data['status'] == 'Pinjam') : ?>
                        <a href="pinjam_kembali.php?id=<?php echo $data['id_pinjam']; ?>&id_buku=<?php echo $data['id_buku']; ?>" class="btn btn-success" onclick="return confirm('Proses pengembalian buku?')">Kembalikan</a>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'layout/footer.php'; ?>
