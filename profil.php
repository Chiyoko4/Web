<?php
session_start();
require 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Sekretariat Daerah Kabupaten Rembang</title>
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
                <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link active" href="profil.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                <?php if(isset($_SESSION['username'])){ ?>
                    <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <section class="page-hero text-center">
        <span class="hero-badge">Profil Instansi</span>
        <h2 class="hero-title">Profil Sekretariat Daerah Kabupaten Rembang</h2>
        <p class="hero-text">Bagian utama pemerintahan daerah yang berperan sebagai pusat koordinasi, administrasi, dan dukungan strategis bagi penyelenggaraan pemerintahan.</p>
    </section>

    <div class="row g-4 mt-4">
        <div class="col-lg-8">
            <div class="site-card h-100">
                <div class="card-body">
                    <h3 class="section-title">Tentang Kami</h3>
                    <p class="text-muted">Sekretariat Daerah Kabupaten Rembang merupakan unsur pembantu pimpinan Pemerintah Kabupaten Rembang yang dipimpin oleh Sekretaris Daerah dan bertanggung jawab kepada Bupati.</p>
                    <p class="text-muted">Sekretariat Daerah mempunyai tugas membantu Bupati dalam penyusunan kebijakan daerah, mengoordinasikan pelaksanaan tugas perangkat daerah, serta memberikan pelayanan administratif kepada seluruh perangkat daerah.</p>
                    <p class="text-muted">Dalam menjalankan tugasnya, Sekretariat Daerah berkomitmen memberikan pelayanan pemerintahan yang profesional, efektif, efisien, transparan, dan akuntabel demi mendukung pembangunan Kabupaten Rembang.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="site-card h-100">
                <div class="card-body">
                    <h3 class="section-title">Komitmen</h3>
                    <div class="d-flex flex-column gap-3">
                        <div class="feature-card">
                            <div class="feature-icon">⚙️</div>
                            <h6 class="mb-1">Koordinasi Terpadu</h6>
                            <p class="text-muted mb-0">Menghubungkan seluruh unsur kerja secara efektif.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🧭</div>
                            <h6 class="mb-1">Pelayanan Terpercaya</h6>
                            <p class="text-muted mb-0">Menjalankan tata kelola pemerintahan yang akuntabel.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="site-footer">
    <div class="container text-center">
        <p class="mb-0">© <?php echo date("Y"); ?> Sekretariat Daerah Kabupaten Rembang</p>
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