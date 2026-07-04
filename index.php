<?php
session_start();
require 'config/koneksi.php';

$berita = $db->berita->find(
    [],
    [
        'sort' => ['tanggal' => -1],
        'limit' => 3
    ]
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekretariat Daerah Kabupaten Rembang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/modern.css">
</head>
<body class="site-body">

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">SETDA REMBANG</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                <?php if (isset($_SESSION['username'])) { ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                        <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Dashboard</a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <section class="hero-panel">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge">Portal Informasi Resmi</span>
                <h1 class="hero-title">Sekretariat Daerah Kabupaten Rembang</h1>
                <p class="hero-text">Menyajikan informasi pemerintahan secara modern, cepat, dan nyaman untuk masyarakat, mitra kerja, serta stakeholder yang membutuhkan akses resmi yang terpercaya.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="profil.php" class="btn btn-primary">Profil Instansi</a>
                    <a href="berita.php" class="btn btn-outline-primary">Lihat Berita</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="section-surface">
                    <h5 class="section-title mb-3">Informasi Cepat</h5>
                    <div class="d-flex flex-column gap-3">
                        <div class="feature-card">
                            <div class="feature-icon">🕒</div>
                            <h6 class="mb-1">Jam Pelayanan</h6>
                            <p class="text-muted mb-0">Senin–Jumat, 08.00–16.00 WIB</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📍</div>
                            <h6 class="mb-1">Lokasi Kantor</h6>
                            <p class="text-muted mb-0">Jl. Pahlawan No. 1, Kabupaten Rembang</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🔐</div>
                            <h6 class="mb-1">Akses Informasi</h6>
                            <p class="text-muted mb-0">Terintegrasi dengan berita resmi dan layanan publik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5 px-0">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="site-card h-100">
                    <div class="card-body">
                        <h2 class="section-title">Tentang Sekretariat Daerah</h2>
                        <p class="text-muted mb-0">
                            Sekretariat Daerah Kabupaten Rembang merupakan unsur pembantu pimpinan pemerintah daerah yang mempunyai tugas membantu Bupati dalam menyusun kebijakan daerah, mengoordinasikan pelaksanaan tugas perangkat daerah, serta memberikan pelayanan administrasi pemerintahan yang profesional.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <span class="info-pill">Pelayanan Publik</span>
                            <span class="info-pill">Informasi Resmi</span>
                            <span class="info-pill">Koordinasi Pemerintahan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="site-card h-100">
                    <div class="card-body">
                        <h2 class="section-title">Ringkasan Utama</h2>
                        <ul class="text-muted ps-3 mb-0">
                            <li>Berita resmi terbaru</li>
                            <li>Profil dan visi misi</li>
                            <li>Kontak instansi yang lengkap</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 px-0">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">📢</div>
                    <h5 class="mb-2">Berita Terkini</h5>
                    <p class="text-muted mb-0">Akses informasi resmi dengan penyajian yang rapi, cepat, dan mudah dipahami.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">🏛️</div>
                    <h5 class="mb-2">Profil Instansi</h5>
                    <p class="text-muted mb-0">Memahami struktur, tugas, dan arah kebijakan pemerintahan daerah secara menyeluruh.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">🤝</div>
                    <h5 class="mb-2">Layanan Responsif</h5>
                    <p class="text-muted mb-0">Menciptakan pengalaman yang nyaman bagi warga, tamu, dan mitra kerja pemerintah.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 px-0">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Berita Terbaru</h2>
            <a href="berita.php" class="btn btn-outline-primary">Lihat Semua Berita</a>
        </div>
        <div class="row g-4">
            <?php
            $jumlahBerita = 0;
            foreach ($berita as $item) {
                $jumlahBerita++;
                $namaGambar = trim($item['gambar'] ?? '');
                $gambar = $namaGambar !== '' ? "uploads/berita/" . $namaGambar : "uploads/berita/default.jpg";
            ?>
                <div class="col-md-4">
                    <div class="card card-berita h-100 site-card" onclick="window.location='detail_berita.php?id=<?php echo htmlspecialchars((string) $item['_id']); ?>'" style="cursor:pointer;">
                        <img src="<?php echo $gambar; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['judul'] ?? 'Berita'); ?>" style="height:250px;object-fit:cover;" onerror="this.src='uploads/berita/default.jpg';">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['judul'] ?? ''); ?></h5>
                            <p class="text-muted">
                                <?php
                                $isi = strip_tags($item['isi'] ?? '');
                                if (mb_strlen($isi) > 120) {
                                    echo htmlspecialchars(mb_substr($isi, 0, 120) . ' ...');
                                } else {
                                    echo htmlspecialchars($isi);
                                }
                                ?>
                            </p>
                        </div>
                        <div class="card-footer" style="background:transparent; border-top:1px solid rgba(255,255,255,0.08);">
                            <small class="text-muted">
                                Penulis : <?php echo htmlspecialchars($item['penulis'] ?? ''); ?><br>
                                Tanggal : <?php $tanggal = $item['tanggal'] ?? ''; if ($tanggal != '') { echo date('d F Y', strtotime($tanggal)); } ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($jumlahBerita == 0) { ?>
                <div class="col-12">
                    <div class="alert alert-secondary text-center">
                        Belum ada berita yang tersedia.
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="container mt-5 px-0">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="site-card h-100">
                    <div class="card-body">
                        <h3 class="section-title">Visi</h3>
                        <p class="text-muted mb-0">Terwujudnya tata kelola pemerintahan yang efektif, transparan, akuntabel, dan berorientasi pada pelayanan masyarakat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="site-card h-100">
                    <div class="card-body">
                        <h3 class="section-title">Misi</h3>
                        <ul class="text-muted mb-0 ps-3">
                            <li>Meningkatkan kualitas pelayanan publik.</li>
                            <li>Meningkatkan koordinasi perangkat daerah.</li>
                            <li>Mewujudkan pemerintahan yang profesional.</li>
                            <li>Meningkatkan kualitas administrasi pemerintahan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Sekretariat Daerah Kabupaten Rembang</h5>
                <p class="text-muted mb-0">Website ini dibuat sebagai media informasi mengenai kegiatan dan pelayanan Sekretariat Daerah Kabupaten Rembang.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1">Email : setda@rembangkab.go.id</p>
                <p class="mb-1">Telepon : (0295) 691472</p>
                <p class="mb-0">© <?php echo date("Y"); ?> Sekretariat Daerah Kabupaten Rembang</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
setInterval(function(){
    fetch("heartbeat.php");
},30000);
</script>
</body>
</html>