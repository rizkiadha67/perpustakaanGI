<?php
require 'config/koneksi.php';

// ── Data grafik 7 hari ke belakang ────────────────────────────────────────
$labels        = [];
$data_pinjam   = [];
$data_kembali  = [];

for ($i = 6; $i >= 0; $i--) {
    $tanggal  = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime("-$i days"));

    $qp = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE tgl_pinjam = '$tanggal'");
    $data_pinjam[] = (int) mysqli_fetch_assoc($qp)['total'];

    $qk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE tgl_kembali = '$tanggal' AND status = 'Kembali'");
    $data_kembali[] = (int) mysqli_fetch_assoc($qk)['total'];
}

// ── Statistik ringkas ─────────────────────────────────────────────────────
$total_buku    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM buku"))['c'];
$total_anggota = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM anggota"))['c'];
$total_aktif   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM peminjaman WHERE status='Pinjam'"))['c'];
$total_kembali = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM peminjaman WHERE status='Kembali'"))['c'];

$labels_json       = json_encode($labels);
$data_pinjam_json  = json_encode($data_pinjam);
$data_kembali_json = json_encode($data_kembali);

// ── include header (menambahkan Bootstrap 5 via CDN) ─────────────────────
// Header asli hanya memuat style.css — kita include manual agar Bootstrap tersedia
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjaman – Perpustakaan</title>
    <meta name="description" content="Statistik dan grafik peminjaman buku 7 hari terakhir.">
    <link rel="stylesheet" href="assets/style.css">
    <!-- Bootstrap 5 (hanya untuk komponen tab chart) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ── Override agar Bootstrap tidak merusak style.css global ── */
        body  { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
                background-color: #f4f7f6 !important; color: #333 !important; }
        .container { max-width: 1100px !important; }

        /* ── Stat Cards ─────────────────────────────────────────────── */
        .stat-row { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 28px; }

        .stat-card {
            flex: 1 1 180px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,.06);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-top: 4px solid transparent;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .stat-card.blue   { border-top-color: #3498db; }
        .stat-card.teal   { border-top-color: #1abc9c; }
        .stat-card.orange { border-top-color: #f39c12; }
        .stat-card.green  { border-top-color: #27ae60; }

        .stat-icon {
            width: 46px; height: 46px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
        }
        .stat-icon.blue   { background: #ebf5fb; color: #3498db; }
        .stat-icon.teal   { background: #e8f8f5; color: #1abc9c; }
        .stat-icon.orange { background: #fef9e7; color: #f39c12; }
        .stat-icon.green  { background: #eafaf1; color: #27ae60; }

        .stat-info .stat-value { font-size: 1.9rem; font-weight: 700; color: #2c3e50; line-height: 1; }
        .stat-info .stat-label { font-size: .78rem; color: #7f8c8d; margin-top: 4px; font-weight: 500; }

        /* ── Chart Box ───────────────────────────────────────────────── */
        .chart-box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
            padding: 22px 24px;
            margin-bottom: 28px;
        }
        .chart-box h2 {
            font-size: 1.1rem; color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 6px; margin-bottom: 16px;
            display: inline-block;
        }

        /* ── Chart Type Tabs ─────────────────────────────────────────── */
        .chart-tabs {
            display: flex; flex-wrap: wrap; gap: 6px;
            margin-bottom: 18px;
        }
        .chart-tab-btn {
            padding: 6px 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f9fa;
            color: #2c3e50;
            font-size: .82rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            display: flex; align-items: center; gap: 5px;
        }
        .chart-tab-btn:hover { border-color: #3498db; color: #3498db; background: #ebf5fb; }
        .chart-tab-btn.active {
            background: #3498db; color: #fff; border-color: #3498db;
        }

        .chart-legend {
            display: flex; gap: 16px; margin-bottom: 14px;
            font-size: .82rem; color: #7f8c8d;
        }
        .legend-dot { display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 5px; }

        .chart-wrap { position: relative; height: 310px; }

        /* ── Tabel Riwayat ────────────────────────────────────────────── */
        .section-title {
            font-size: 1rem; color: #2c3e50; font-weight: 700;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px; margin-bottom: 16px;
            display: inline-block;
        }
        .badge-status {
            display: inline-block;
            padding: 3px 10px; border-radius: 4px;
            font-size: .75rem; font-weight: 600;
        }
        .badge-pinjam  { background: #fef9e7; color: #d35400; border: 1px solid #f39c12; }
        .badge-kembali { background: #eafaf1; color: #1e8449; border: 1px solid #27ae60; }

        /* ── Fade-in animation ────────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp .45s ease both; }
        .d1 { animation-delay:.05s; } .d2 { animation-delay:.1s; }
        .d3 { animation-delay:.15s; } .d4 { animation-delay:.2s; }
    </style>
</head>
<body>
<?php
// Navbar dari header.php (tanpa <!DOCTYPE ...> duplikat — kita ambil isinya saja)
?>
<!-- Navbar Top (sama dengan halaman lain) -->
<nav>
    <div class="logo">PerpusKu</div>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="buku_tampil.php">Buku</a></li>
        <li><a href="jurusan_tampil.php">Jurusan</a></li>
        <li><a href="anggota_tampil.php">Anggota</a></li>
        <li><a href="pinjam_tampil.php">Peminjaman</a></li>
        <li><a href="dashboard.php" style="color:#3498db;">Grafik</a></li>
    </ul>
</nav>

<div class="main-wrapper">
<div class="container">

    <!-- Judul halaman -->
    <h2 style="margin-bottom:22px; display:block; border:none; padding:0;">
        <i class="bi bi-bar-chart-line-fill me-2" style="color:#3498db;"></i>
        Dashboard Statistik Peminjaman
    </h2>

    <!-- ── STAT CARDS ──────────────────────────────────────────────── -->
    <div class="stat-row fade-up">
        <div class="stat-card blue">
            <div class="stat-icon blue"><i class="bi bi-journals"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?= $total_buku ?></div>
                <div class="stat-label">Total Buku</div>
            </div>
        </div>
        <div class="stat-card teal">
            <div class="stat-icon teal"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?= $total_anggota ?></div>
                <div class="stat-label">Total Anggota</div>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon orange"><i class="bi bi-bookmark-check"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?= $total_aktif ?></div>
                <div class="stat-label">Sedang Dipinjam</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon green"><i class="bi bi-check2-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?= $total_kembali ?></div>
                <div class="stat-label">Sudah Dikembalikan</div>
            </div>
        </div>
    </div>

    <!-- ── CHART BOX ─────────────────────────────────────────────── -->
    <div class="chart-box fade-up d1">
        <h2>Grafik Peminjaman – 7 Hari Terakhir</h2>

        <!-- Tab pilihan jenis diagram -->
        <div class="chart-tabs" id="chartTabs">
            <button class="chart-tab-btn active" data-chart="bar">
                <i class="bi bi-bar-chart-fill"></i> Bar
            </button>
            <button class="chart-tab-btn" data-chart="line">
                <i class="bi bi-graph-up"></i> Line
            </button>
            <button class="chart-tab-btn" data-chart="area">
                <i class="bi bi-water"></i> Area
            </button>
            <button class="chart-tab-btn" data-chart="radar">
                <i class="bi bi-hexagon"></i> Radar
            </button>
            <button class="chart-tab-btn" data-chart="pie">
                <i class="bi bi-pie-chart-fill"></i> Pie
            </button>
            <button class="chart-tab-btn" data-chart="doughnut">
                <i class="bi bi-circle-half"></i> Doughnut
            </button>
            <button class="chart-tab-btn" data-chart="polarArea">
                <i class="bi bi-record-circle"></i> Polar Area
            </button>
        </div>

        <!-- Legend -->
        <div class="chart-legend">
            <span><span class="legend-dot" style="background:#3498db;"></span>Dipinjam</span>
            <span><span class="legend-dot" style="background:#27ae60;"></span>Dikembalikan</span>
        </div>

        <!-- Canvas -->
        <div class="chart-wrap">
            <canvas id="mainChart"></canvas>
        </div>
    </div>

    <!-- ── TABEL RIWAYAT TERBARU ──────────────────────────────────── -->
    <div class="fade-up d2">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <span class="section-title"><i class="bi bi-clock-history" style="color:#3498db;"></i> Riwayat Peminjaman Terbaru</span>
            <a href="pinjam_tampil.php" class="btn btn-primary" style="font-size:.82rem; padding:6px 14px;">Lihat Semua</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Peminjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no     = 1;
            $recent = mysqli_query($koneksi,
                "SELECT p.*, b.judul, a.nama
                 FROM peminjaman p
                 JOIN buku b ON p.id_buku = b.id_buku
                 JOIN anggota a ON p.id_anggota = a.id_anggota
                 ORDER BY p.created_at DESC LIMIT 8");
            while ($row = mysqli_fetch_assoc($recent)):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= $row['tgl_pinjam'] ?></td>
                    <td><?= $row['tgl_kembali'] ?: '—' ?></td>
                    <td>
                        <span class="badge-status <?= $row['status'] === 'Pinjam' ? 'badge-pinjam' : 'badge-kembali' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div><!-- /.container -->
</div><!-- /.main-wrapper -->

<footer>
    <p>&copy; <?= date('Y') ?> Sistem Perpustakaan Sederhana – MK Pemrograman Web 1</p>
</footer>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
/**
 * ============================================================
 *  DASHBOARD GRAFIK PEMINJAMAN BUKU
 *  Menggunakan library Chart.js v4
 * ============================================================
 *
 *  Jenis grafik yang tersedia:
 *  1. Bar       - Diagram batang, cocok membandingkan jumlah per hari
 *  2. Line      - Diagram garis, menampilkan tren naik/turun
 *  3. Area      - Diagram garis dengan area terisi, memperjelas volume
 *  4. Radar     - Diagram jaring laba-laba, membandingkan pola antar hari
 *  5. Pie       - Diagram lingkaran, proporsi total pinjam vs kembali
 *  6. Doughnut  - Sama seperti Pie tapi berlubang di tengah
 *  7. PolarArea - Diagram polar, tiap irisan memiliki jari-jari proporsional
 * ============================================================
 */

// ── Data dari PHP (di-encode ke JSON untuk dipakai di JavaScript) ──────────
// LABELS  : array label tanggal, contoh: ["14 Mei", "15 Mei", ...]
// PINJAM  : jumlah buku dipinjam per hari selama 7 hari terakhir
// KEMBALI : jumlah buku dikembalikan per hari selama 7 hari terakhir
const LABELS   = <?= $labels_json ?>;
const PINJAM   = <?= $data_pinjam_json ?>;
const KEMBALI  = <?= $data_kembali_json ?>;

// ── Konstanta warna utama ─────────────────────────────────────────────────
const C_BLUE    = '#3498db';              // Warna biru untuk dataset "Dipinjam"
const C_GREEN   = '#27ae60';              // Warna hijau untuk dataset "Dikembalikan"
const C_BLUE_A  = 'rgba(52,152,219,.15)'; // Biru transparan (dipakai pada chart Area)
const C_GREEN_A = 'rgba(39,174,96,.15)';  // Hijau transparan (dipakai pada chart Area)

// ── Konfigurasi default global Chart.js ───────────────────────────────────
Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
Chart.defaults.color = '#7f8c8d';    // Warna teks label sumbu
Chart.defaults.borderColor = '#ecf0f1'; // Warna garis grid

// Variabel penampung instance chart aktif (digunakan saat ganti jenis diagram)
let chart = null;

/**
 * buildConfig(type)
 * Membangun objek konfigurasi Chart.js sesuai jenis diagram yang dipilih.
 *
 * @param {string} type - Jenis grafik: 'bar' | 'line' | 'area' | 'radar'
 *                        | 'pie' | 'doughnut' | 'polarArea'
 * @returns {object} Konfigurasi lengkap untuk new Chart(ctx, config)
 */
function buildConfig(type) {

    // ── Deteksi kategori diagram ───────────────────────────────────────────
    // isCircular : Pie, Doughnut, PolarArea → tidak punya sumbu X/Y
    //              Datanya digabung jadi total pinjam vs total kembali
    // isArea     : Area → secara teknis Chart.js tipe 'line' dengan fill: true
    // realType   : Nama tipe yang diterima Chart.js (area → line)
    const isCircular = ['pie', 'doughnut', 'polarArea'].includes(type);
    const isArea     = type === 'area';
    const realType   = isArea ? 'line' : type;

    // ── Konfigurasi Dataset ────────────────────────────────────────────────
    const datasets = isCircular

        /**
         * Dataset untuk diagram MELINGKAR (Pie / Doughnut / PolarArea)
         * ─────────────────────────────────────────────────────────────
         * - Hanya 1 dataset dengan 2 segmen: Total Dipinjam & Total Dikembalikan
         * - Data dihitung dengan menjumlahkan semua nilai 7 hari (Array.reduce)
         * - backgroundColor: array warna berbeda untuk tiap segmen
         */
        ? [{
            label: 'Total',
            data : [
                PINJAM.reduce((a, b) => a + b, 0),   // Total pinjam 7 hari
                KEMBALI.reduce((a, b) => a + b, 0),  // Total kembali 7 hari
            ],
            backgroundColor: [
                'rgba(52,152,219,.75)',  // Biru  → Dipinjam
                'rgba(39,174,96,.75)',   // Hijau → Dikembalikan
                'rgba(231,76,60,.75)',
                'rgba(243,156,18,.75)',
                'rgba(142,68,173,.75)',
                'rgba(26,188,156,.75)',
                'rgba(52,73,94,.75)',
            ],
            borderColor: '#fff', // Garis pemisah antar segmen
            borderWidth: 2,
          }]

        /**
         * Dataset untuk diagram BERBASIS SUMBU (Bar / Line / Area / Radar)
         * ─────────────────────────────────────────────────────────────────
         * - 2 dataset terpisah: "Dipinjam" (biru) dan "Dikembalikan" (hijau)
         * - Data per hari selama 7 hari terakhir sesuai array PINJAM & KEMBALI
         *
         * Penjelasan properti tiap dataset:
         *   backgroundColor : Warna isian batang/area. Pada Area pakai warna transparan.
         *   borderColor     : Warna garis tepi batang atau garis pada Line/Area
         *   borderWidth     : Ketebalan garis tepi (piksel)
         *   pointRadius     : Ukuran titik data pada Line/Area/Radar
         *   pointHoverRadius: Ukuran titik saat kursor hover
         *   fill            : true  → isi area di bawah garis (khusus chart Area)
         *                     false → tidak diisi (Line biasa)
         *   tension         : Kelengkungan garis (0 = lurus, 0.4 = melengkung)
         *                     Aktif hanya pada tipe Line dan Area
         */
        : [
            {
                // ── Dataset 1: Jumlah Peminjaman per Hari ─────────────────
                label: 'Dipinjam',
                data : PINJAM,
                backgroundColor: isArea ? C_BLUE_A : C_BLUE, // Transparan jika Area
                borderColor    : C_BLUE,
                borderWidth    : 2,
                pointBackgroundColor: C_BLUE,
                pointRadius: 5, pointHoverRadius: 7,
                fill   : isArea,                              // Isi area hanya jika tipe Area
                tension: (type === 'line' || isArea) ? 0.4 : 0, // Garis melengkung untuk Line/Area
            },
            {
                // ── Dataset 2: Jumlah Pengembalian per Hari ───────────────
                label: 'Dikembalikan',
                data : KEMBALI,
                backgroundColor: isArea ? C_GREEN_A : C_GREEN,
                borderColor    : C_GREEN,
                borderWidth    : 2,
                pointBackgroundColor: C_GREEN,
                pointRadius: 5, pointHoverRadius: 7,
                fill   : isArea,
                tension: (type === 'line' || isArea) ? 0.4 : 0,
            },
          ];

    // ── Objek konfigurasi lengkap Chart.js ────────────────────────────────
    return {
        type: realType, // Tipe chart yang dikenali Chart.js
        data: {
            // Circular chart pakai label nama kategori; lainnya pakai tanggal
            labels  : isCircular ? ['Dipinjam', 'Dikembalikan'] : LABELS,
            datasets,
        },
        options: {
            responsive         : true,  // Otomatis menyesuaikan lebar container
            maintainAspectRatio: false, // Tinggi dikontrol dari CSS (.chart-wrap)

            // ── Animasi transisi saat ganti diagram ───────────────────────
            animation: { duration: 550, easing: 'easeInOutQuart' },

            plugins: {
                // ── Legenda (label warna dataset) ─────────────────────────
                // Hanya ditampilkan pada diagram melingkar karena
                // Bar/Line/Area/Radar sudah punya legenda HTML di atasnya
                legend: {
                    display : isCircular,
                    position: 'bottom',
                    labels  : { color:'#555', padding:16, font:{size:12}, boxWidth:14, boxHeight:14 },
                },

                // ── Tooltip saat hover pada data point ────────────────────
                tooltip: {
                    backgroundColor: '#2c3e50', // Latar tooltip gelap
                    titleColor     : '#ecf0f1',
                    bodyColor      : '#bdc3c7',
                    borderColor    : '#34495e',
                    borderWidth    : 1,
                    padding        : 10,
                    cornerRadius   : 6,
                    // Format teks tooltip: tampilkan nama dataset + jumlah buku
                    // Circular chart tidak butuh format khusus (Chart.js otomatis)
                    callbacks: isCircular ? {} : {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} buku`,
                    },
                },
            },

            // ── Konfigurasi Sumbu X dan Y ──────────────────────────────────
            // Diagram melingkar tidak memiliki sumbu → dikosongkan ({})
            scales: isCircular ? {} : {
                x: {
                    grid : { color: '#ecf0f1' }, // Warna garis grid vertikal
                    ticks: { color: '#7f8c8d', font: {size:11} },
                },
                y: {
                    beginAtZero: true, // Sumbu Y selalu mulai dari 0
                    grid : { color: '#ecf0f1' }, // Warna garis grid horizontal
                    ticks: {
                        color    : '#7f8c8d',
                        font     : {size:11},
                        stepSize : 1,     // Kenaikan tiap strip = 1 (buku)
                        precision: 0,     // Tidak pakai desimal
                    },
                },
            },
        },
    };
}

/**
 * renderChart(type)
 * Menghancurkan chart lama (jika ada) lalu merender chart baru
 * di dalam elemen <canvas id="mainChart">.
 *
 * Menghancurkan dulu diperlukan agar Chart.js tidak menumpuk
 * instance di canvas yang sama dan menyebabkan memory leak.
 *
 * @param {string} type - Jenis diagram (bar | line | area | radar | pie | doughnut | polarArea)
 */
function renderChart(type) {
    const ctx = document.getElementById('mainChart');

    // Hancurkan chart sebelumnya jika sudah ada
    if (chart) {
        chart.destroy();
        chart = null;
    }

    // Buat instance Chart.js baru dengan konfigurasi sesuai tipe
    chart = new Chart(ctx, buildConfig(type));
}

// ── Inisialisasi: tampilkan Bar Chart saat halaman pertama dibuka ──────────
renderChart('bar');

// ── Event listener untuk tombol tab pilihan diagram ───────────────────────
// Saat salah satu tombol diklik:
//   1. Hapus kelas 'active' dari semua tombol
//   2. Tambahkan kelas 'active' ke tombol yang diklik
//   3. Render ulang chart sesuai atribut data-chart tombol tersebut
document.querySelectorAll('.chart-tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.chart-tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');                 // Tandai tombol aktif
        renderChart(this.dataset.chart);              // Ganti jenis diagram
    });
});
</script>
</body>
</html>
