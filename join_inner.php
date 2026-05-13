<?php
require 'config/koneksi.php';
include 'layout/header.php';
?>
<div class="mb-20" style="margin-bottom: 20px;">
    <a href="join_inner.php" class="btn btn-primary" style="margin-right: 5px;">INNER JOIN</a>
    <a href="join_left.php" class="btn btn-secondary" style="margin-right: 5px;">LEFT JOIN</a>
    <a href="join_right.php" class="btn btn-secondary" style="margin-right: 5px;">RIGHT JOIN</a>
    <a href="join_full.php" class="btn btn-secondary">FULL OUTER JOIN</a>
</div>

<div class="d-flex justify-between align-center mb-20">
    <h2>Demo INNER JOIN</h2>
</div>

<div style="background-color: #e9f7ef; border-left: 5px solid #28a745; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h4 style="margin-top: 0;">Maksud dan Tujuan: INNER JOIN</h4>
    <p style="margin-bottom: 5px;"><strong>INNER JOIN</strong> digunakan untuk menggabungkan dua tabel dan <strong>HANYA</strong> menampilkan data yang memiliki pasangan atau kecocokan di kedua tabel tersebut.</p>
    <p style="margin-bottom: 0;"><strong>Penjelasan untuk Orang Awam:</strong> Bayangkan kita punya daftar "Anggota" dan daftar "Jurusan". INNER JOIN hanya akan menampilkan anggota yang <strong>sudah pasti memiliki jurusan</strong>. Jika ada anggota yang belum terdaftar di jurusan manapun, atau ada jurusan yang kosong tanpa anggota, maka mereka <strong>TIDAK AKAN</strong> ditampilkan di sini.</p>
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
        $query = mysqli_query($koneksi, "SELECT anggota.nim, anggota.nama, jurusan.nama_jurusan 
                                        FROM anggota 
                                        INNER JOIN jurusan ON anggota.id_jurusan = jurusan.id_jurusan");
        while ($data = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>".$data['nim']."</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>".$data['nama']."</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>".($data['nama_jurusan'] ? $data['nama_jurusan'] : '-')."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php include 'layout/footer.php'; ?>
