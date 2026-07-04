<?php
session_start();
require 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Sekretariat Daerah Kabupaten Rembang</title>
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
                <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
                <li class="nav-item"><a class="nav-link active" href="kontak.php">Kontak</a></li>
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
        <span class="hero-badge">Hubungi Kami</span>
        <h2 class="hero-title">Informasi Kontak Instansi</h2>
        <p class="hero-text">Kami siap menerima pertanyaan, permohonan informasi, serta kebutuhan koordinasi terkait layanan pemerintahan dan komunikasi resmi.</p>
    </section>

    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="site-card h-100">
                <div class="card-body">
                    <h3 class="section-title">Detail Kontak</h3>
                    <div class="d-flex flex-column gap-3">
                        <div class="contact-item">
                            <div class="contact-label">Nama Instansi</div>
                            <div class="contact-value">Sekretariat Daerah Kabupaten Rembang</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Alamat</div>
                            <div class="contact-value">Jl. Pahlawan No. 1, Kabupaten Rembang, Jawa Tengah</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Telepon</div>
                            <div class="contact-value">(0295) 691472</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Email</div>
                            <div class="contact-value">setda@rembangkab.go.id</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Jam Operasional</div>
                            <div class="contact-value">Senin - Jumat<br>08.00 - 16.00 WIB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="site-card h-100">
                <div class="card-body">
                    <h3 class="section-title">Lokasi Kantor</h3>
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps?q=Sekretariat+Daerah+Kabupaten+Rembang&z=15&output=embed" title="Lokasi Sekretariat Daerah Kabupaten Rembang" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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