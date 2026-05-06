<?php
require 'config/koneksi.php';

// Initialization Logic
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
    $where[] = "anggota.id_jurusan = '$filter_jurusan'";
}

$where_sql = count($where) > 0 ? "WHERE " . implode(' AND ', $where) : "";

// Pagination Logic
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Count total records for pagination
$q_count = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM anggota $where_sql");
$row_count = mysqli_fetch_assoc($q_count);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $limit);

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
            $q_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
            while($j = mysqli_fetch_array($q_jurusan)) {
                $selected = (isset($_GET['filter_jurusan']) && $_GET['filter_jurusan'] == $j['id_jurusan']) ? 'selected' : '';
                echo "<option value='".$j['id_jurusan']."' $selected>".$j['nama_jurusan']."</option>";
            }
            ?>
        </select>

        <select name="limit">
            <?php
            $limits = [10, 25, 50, 100];
            foreach($limits as $l) {
                $selected = ($limit == $l) ? 'selected' : '';
                echo "<option value='$l' $selected>$l Per Halaman</option>";
            }
            ?>
        </select>
        
        <button type="submit" class="btn btn-primary">Cari & Filter</button>
        <?php if(isset($_GET['cari']) || isset($_GET['filter_jurusan']) || isset($_GET['limit'])): ?>
            <a href="anggota_tampil.php" class="btn btn-danger">Reset</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>
                <a href="?sort=nim&order=<?php echo $next_order; ?>&cari=<?php echo $cari; ?>&filter_jurusan=<?php echo $filter_jurusan; ?>&limit=<?php echo $limit; ?>" style="text-decoration:none; color:inherit;">
                    NIM <?php echo ($sort == 'nim') ? ($order == 'ASC' ? '↑' : '↓') : ''; ?>
                </a>
            </th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Alamat</th>
            <th>L/P</th>
            <th>Terakhir Diupdate</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = $offset + 1;
        $query = mysqli_query($koneksi, "SELECT anggota.*, jurusan.nama_jurusan 
                                        FROM anggota 
                                        LEFT JOIN jurusan ON anggota.id_jurusan = jurusan.id_jurusan
                                        $where_sql 
                                        ORDER BY $sort $order 
                                        LIMIT $offset, $limit");
        
        if (mysqli_num_rows($query) == 0) {
            echo "<tr><td colspan='7' style='text-align:center;'>Data tidak ditemukan.</td></tr>";
        }

        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nim']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['nama_jurusan']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['jenis_kelamin']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($data['updated_at'])); ?></td>
                <td>
                    <a href="anggota_edit.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-warning">Edit</a>
                    <a href="anggota_hapus.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-danger"
                        onclick="return confirm('Yakin hapus anggota ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php 
        $params = "&cari=$cari&filter_jurusan=$filter_jurusan&limit=$limit&sort=$sort&order=$order";
        ?>
        
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1 . $params; ?>">&laquo; Prev</a>
        <?php else: ?>
            <span class="disabled">&laquo; Prev</span>
        <?php endif; ?>

        <?php
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $page + 2);
        
        if ($start_page > 1) {
            echo "<a href='?page=1$params'>1</a>";
            if ($start_page > 2) echo "<span>...</span>";
        }

        for ($i = $start_page; $i <= $end_page; $i++) {
            $active = ($i == $page) ? 'active' : '';
            echo "<a href='?page=$i$params' class='$active'>$i</a>";
        }

        if ($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) echo "<span>...</span>";
            echo "<a href='?page=$total_pages$params'>$total_pages</a>";
        }
        ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1 . $params; ?>">Next &raquo;</a>
        <?php else: ?>
            <span class="disabled">Next &raquo;</span>
        <?php endif; ?>
    </div>
    <div class="pagination-info">
        Menampilkan <?php echo min($total_records, $offset + 1); ?> - <?php echo min($total_records, $offset + $limit); ?> dari <?php echo $total_records; ?> total data
    </div>
<?php endif; ?>

<?php include 'layout/footer.php'; ?>