<?php
require 'config/koneksi.php';
include 'layout/header.php';
?>

<div class="d-flex justify-between align-center">
    <h2>Daftar Anggota</h2>
    <a href="anggota_tambah.php" class="btn btn-primary">Tambah Anggota</a>
</div>

<!-- Search & Filter Bar -->
<div class="search-filter-bar mb-20">
    <form method="GET" action="" class="d-flex flex-wrap gap-10">
        <input type="text" name="cari" placeholder="Cari Nama atau NIM..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>" style="flex: 1; min-width: 200px;">
        
        <select name="filter_jurusan">
            <option value="">-- Semua Jurusan --</option>
            <?php
            $q_jurusan = mysqli_query($koneksi, "SELECT DISTINCT jurusan FROM anggota WHERE jurusan != '' ORDER BY jurusan ASC");
            while($j = mysqli_fetch_array($q_jurusan)) {
                $selected = (isset($_GET['filter_jurusan']) && $_GET['filter_jurusan'] == $j['jurusan']) ? 'selected' : '';
                echo "<option value='".$j['jurusan']."' $selected>".$j['jurusan']."</option>";
            }
            ?>
        </select>
        
        <button type="submit" class="btn btn-primary">Cari & Filter</button>
        <?php if(isset($_GET['cari']) || isset($_GET['filter_jurusan'])): ?>
            <a href="anggota_tampil.php" class="btn btn-danger">Reset</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>
                <a href="?sort=nim&order=<?php echo $next_order; ?>&cari=<?php echo $cari; ?>&filter_jurusan=<?php echo $filter_jurusan; ?>" style="text-decoration:none; color:inherit;">
                    NIM <?php echo ($sort == 'nim') ? ($order == 'ASC' ? '↑' : '↓') : ''; ?>
                </a>
            </th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Alamat</th>
            <th>L/P</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $where = [];
        $cari = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
        $filter_jurusan = isset($_GET['filter_jurusan']) ? mysqli_real_escape_string($koneksi, $_GET['filter_jurusan']) : '';
        
        // Sorting Logic
        $sort = isset($_GET['sort']) ? mysqli_real_escape_string($koneksi, $_GET['sort']) : 'id_anggota';
        $order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
        $next_order = ($order == 'ASC') ? 'desc' : 'asc';

        if ($cari) {
            $where[] = "(nama LIKE '%$cari%' OR nim LIKE '%$cari%')";
        }
        if ($filter_jurusan) {
            $where[] = "jurusan = '$filter_jurusan'";
        }

        $where_sql = count($where) > 0 ? "WHERE " . implode(' AND ', $where) : "";
        $query = mysqli_query($koneksi, "SELECT * FROM anggota $where_sql ORDER BY $sort $order");
        
        if (mysqli_num_rows($query) == 0) {
            echo "<tr><td colspan='7' style='text-align:center;'>Data tidak ditemukan.</td></tr>";
        }

        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nim']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['jurusan']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['jenis_kelamin']; ?></td>
                <td>
                    <a href="anggota_edit.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-warning">Edit</a>
                    <a href="anggota_hapus.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-danger"
                        onclick="return confirm('Yakin hapus anggota ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'layout/footer.php'; ?>