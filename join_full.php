<?php
require 'config/koneksi.php';
include 'layout/header.php';
?>
<div class="mb-20" style="margin-bottom: 20px;">
    <a href="join_inner.php" class="btn btn-secondary" style="margin-right: 5px;">INNER JOIN</a>
    <a href="join_left.php" class="btn btn-secondary" style="margin-right: 5px;">LEFT JOIN</a>
    <a href="join_right.php" class="btn btn-secondary" style="margin-right: 5px;">RIGHT JOIN</a>
    <a href="join_full.php" class="btn btn-primary">FULL OUTER JOIN</a>
</div>

<div class="d-flex justify-between align-center mb-20">
    <h2>Demo FULL OUTER JOIN</h2>
</div>

<div style="background-color: #d1ecf1; border-left: 5px solid #17a2b8; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h4 style="margin-top: 0;">Maksud dan Tujuan: FULL OUTER JOIN</h4>
    <p style="margin-bottom: 5px;"><strong>FULL OUTER JOIN</strong> digunakan untuk menampilkan <strong>SEMUA</strong> data dari kedua tabel, tidak peduli apakah data di tabel kiri memiliki pasangan di tabel kanan atau tidak, begitu juga sebaliknya.</p>
    <p style="margin-bottom: 0;"><strong>Penjelasan untuk Orang Awam:</strong> Ini adalah penggabungan paling maksimal. Kita ingin melihat <strong>SEMUA Anggota</strong> DAN <strong>SEMUA Jurusan</strong> secara bersamaan. <br>
    - Jika ada anggota yang belum memilih jurusan, <strong>TETAP DITAMPILKAN</strong>.<br>
    - Jika ada jurusan baru yang belum punya anggota, <strong>TETAP DITAMPILKAN</strong>.<br>
    - Jika keduanya punya pasangan, tampilkan bersandingan.<br>
    <em>(Catatan Teknis: Karena database MySQL secara bawaan tidak mendukung kata kunci FULL OUTER JOIN, kita mewujudkannya dengan menggabungkan hasil LEFT JOIN dan RIGHT JOIN menggunakan perintah UNION).</em></p>
</div>

<table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <thead>
        <tr style="text-align: left; background-color: #f2f2f2;">
            <th style="padding: 10px; border: 1px solid #ddd;">NIM</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Nama Anggota</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Nama Jurusan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = mysqli_query($koneksi, "
            SELECT anggota.nim, anggota.nama, jurusan.nama_jurusan 
            FROM anggota 
            LEFT JOIN jurusan ON anggota.id_jurusan = jurusan.id_jurusan
            UNION
            SELECT anggota.nim, anggota.nama, jurusan.nama_jurusan 
            FROM anggota 
            RIGHT JOIN jurusan ON anggota.id_jurusan = jurusan.id_jurusan
        ");
        while ($data = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td style='padding: 10px; border: 1px solid #ddd; color: ".($data['nim'] ? 'black' : 'red').";'>".($data['nim'] ? $data['nim'] : '<i>Tidak ada (Kosong)</i>')."</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd; color: ".($data['nama'] ? 'black' : 'red').";'>".($data['nama'] ? $data['nama'] : '<i>Tidak ada (Kosong)</i>')."</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd; color: ".($data['nama_jurusan'] ? 'black' : 'red').";'>".($data['nama_jurusan'] ? $data['nama_jurusan'] : '<i>Belum ada jurusan (Kosong)</i>')."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php include 'layout/footer.php'; ?>
