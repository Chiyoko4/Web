<?php
session_start();
require 'config/koneksi.php';

$berita = $db->berita->find(
    ['status' => 'publish'],
    ['sort' => ['tanggal' => -1]]
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Sekretariat Daerah Kabupaten Rembang</title>
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
                <li class="nav-item"><a class="nav-link active" href="berita.php">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                <?php if (isset($_SESSION['username'])) { ?>
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
        <span class="hero-badge">Berita Resmi</span>
        <h2 class="hero-title">Berita Terbaru</h2>
        <p class="hero-text">Informasi dan kegiatan Sekretariat Daerah Kabupaten Rembang disajikan dalam tampilan yang lebih modern, cerdas, dan nyaman dibaca.</p>
    </section>

    <div class="row g-4 mt-4">
        <?php
        $jumlahBerita = 0;
        foreach ($berita as $item) {
            $jumlahBerita++;
            $ringkasan = mb_substr(strip_tags($item['isi'] ?? ''), 0, 150);
            $gambar = !empty($item['gambar']) && file_exists('uploads/berita/' . $item['gambar']) ? 'uploads/berita/' . $item['gambar'] : 'uploads/berita/default.jpg';
        ?>
            <div class="col-12">
                <div class="site-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo $gambar; ?>" class="img-fluid h-100" style="height:250px;width:100%;object-fit:cover;" alt="<?php echo htmlspecialchars($item['judul']); ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($item['judul']); ?></h3>
                                <p class="text-muted"><?php echo htmlspecialchars($ringkasan); ?> ...</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">Penulis : <?php echo htmlspecialchars($item['penulis']); ?></small>
                                    <a href="detail_berita.php?id=<?php echo htmlspecialchars((string) $item['_id']); ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }

        if ($jumlahBerita == 0) { ?>
            <div class="col-12">
                <div class="alert alert-secondary text-center">Belum ada berita yang dipublikasikan.</div>
            </div>
        <?php } ?>
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