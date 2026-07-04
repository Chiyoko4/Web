<?php
session_start();
require "../config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$online = [];
$users = $db->users->find();
foreach ($users as $user) {
    if (empty($user["last_active"])) {
        continue;
    }
    $selisih = time() - strtotime($user["last_active"]);
    if ($selisih <= 60) {
        $online[] = $user;
    }
}

$totalBerita = $db->berita->countDocuments([]);
$totalPublish = $db->berita->countDocuments(["status" => "publish"]);
$totalMember = $db->users->countDocuments(["role" => "member"]);
$onlineCount = count($online);
$beritaTerbaruCursor = $db->berita->find([], [
    "sort" => ["tanggal" => -1],
    "limit" => 3
]);
$beritaTerbaru = iterator_to_array($beritaTerbaruCursor);
$phpVersion = PHP_VERSION;
$mongoVersion = function_exists("phpversion") ? phpversion("mongodb") : "Tidak tersedia";

function potongTeks($teks, $panjang = 140) {
    $teks = preg_replace('/\s+/', ' ', trim(strip_tags($teks ?? '')));
    if (mb_strlen($teks) <= $panjang) {
        return $teks;
    }

    return mb_substr($teks, 0, $panjang) . '...';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/modern.css">
</head>
<body class="admin-body">

<div class="container py-5">
    <div class="admin-shell">
        <div class="mb-4">
            <h2>Dashboard Admin</h2>
            <p class="text-muted">Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['nama']); ?></strong></p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card site-card h-100">
                    <div class="card-body text-center">
                        <h6 class="text-uppercase text-muted">Total Berita</h6>
                        <h3 class="mb-0"><?php echo $totalBerita; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card site-card h-100">
                    <div class="card-body text-center">
                        <h6 class="text-uppercase text-muted">Dipublikasikan</h6>
                        <h3 class="mb-0"><?php echo $totalPublish; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card site-card h-100">
                    <div class="card-body text-center">
                        <h6 class="text-uppercase text-muted">Total Member</h6>
                        <h3 class="mb-0"><?php echo $totalMember; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card site-card h-100">
                    <div class="card-body text-center">
                        <h6 class="text-uppercase text-muted">Online</h6>
                        <h3 class="mb-0"><?php echo $onlineCount; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card site-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Menu Cepat</h5>
                    </div>
                    <div class="card-body">
                        <a href="kelola_berita.php" class="text-decoration-none">
                            <div class="quick-link-card">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="quick-link-icon">📰</div>
                                    <div>
                                        <h6 class="mb-1">Kelola Berita</h6>
                                        <p class="mb-0 text-muted">Lihat, edit, dan hapus berita publikasi.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card site-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Berita Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($beritaTerbaru) > 0) { ?>
                            <div class="d-flex flex-column gap-3">
                                <?php foreach ($beritaTerbaru as $item) { ?>
                                    <a href="../detail_berita.php?id=<?php echo rawurlencode((string) $item['_id']); ?>" class="news-link-card text-decoration-none">
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div>
                                                <h6 class="news-link-title mb-1"><?php echo htmlspecialchars($item['judul']); ?></h6>
                                                <div class="news-link-meta"><?php echo htmlspecialchars($item['tanggal'] ?? '-'); ?></div>
                                                <p class="news-link-excerpt mb-0"><?php echo htmlspecialchars(potongTeks($item['isi'] ?? '')); ?></p>
                                            </div>
                                            <span class="badge bg-success-subtle text-success-emphasis"><?php echo ucfirst($item['status'] ?? 'draft'); ?></span>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-secondary mb-0">Belum ada berita.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card site-card h-100">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid rgba(255,255,255,0.08);">
                        <h5 class="mb-0">Pengguna Online</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($online) > 0) { ?>
                            <ul class="list-group">
                                <?php foreach ($online as $item) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background:rgba(255,255,255,0.04); border-color:rgba(255,255,255,0.08);">
                                        <div>
                                            <strong><?php echo htmlspecialchars($item["nama"]); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($item["username"]); ?></small>
                                        </div>
                                        <span class="badge bg-success">Online</span>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <div class="alert alert-secondary mb-0">Tidak ada pengguna yang sedang online.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card site-card h-100">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid rgba(255,255,255,0.08);">
                        <h5 class="mb-0">Informasi Sistem</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 text-muted">
                            <li><strong>Versi Website</strong><br>v1.0</li>
                            <li class="mt-3"><strong>PHP</strong><br><?php echo htmlspecialchars($phpVersion); ?></li>
                            <li class="mt-3"><strong>MongoDB</strong><br><?php echo htmlspecialchars($mongoVersion); ?></li>
                            <li class="mt-3"><strong>Bootstrap</strong><br>5.3</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center">
            <a href="../index.php" class="btn btn-outline-primary">Kembali ke Website</a>
            <a href="../payment.php" class="btn btn-outline-primary">Donasi</a>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<script>
setInterval(function(){
    fetch("../heartbeat.php");
},30000);
</script>
</body>
</html>
