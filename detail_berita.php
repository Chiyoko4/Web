<?php
require "vendor/autoload.php";
require "config/koneksi.php";

use MongoDB\BSON\ObjectId;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: berita.php");
    exit;
}

try {
    $id = new ObjectId($_GET['id']);
    $berita = $db->berita->findOne(["_id" => $id]);
} catch (Exception $e) {
    $berita = null;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if ($berita) { echo htmlspecialchars($berita["judul"]); } else { echo "Detail Berita"; } ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/modern.css">
</head>
<body class="site-body">

<div class="container py-5">
    <?php if (!$berita) { ?>
        <div class="alert alert-danger text-center">
            <h4>Berita tidak ditemukan.</h4>
            <a href="berita.php" class="btn btn-primary mt-3">Kembali ke Berita</a>
        </div>
    <?php } else { ?>
        <?php
        $gambar = "uploads/berita/" . $berita["gambar"];
        if (empty($berita["gambar"]) || !file_exists($gambar)) {
            $gambar = "uploads/berita/default.jpg";
        }
        ?>
        <div class="site-card">
            <img src="<?php echo $gambar; ?>" class="card-img-top" alt="Gambar Berita" style="width:100%; height:auto;">
            <div class="card-body">
                <h2 class="hero-title"><?php echo htmlspecialchars($berita["judul"]); ?></h2>
                <p class="text-muted"><strong>Penulis :</strong> <?php echo htmlspecialchars($berita["penulis"]); ?> | <strong>Tanggal :</strong> <?php echo htmlspecialchars($berita["tanggal"]); ?></p>
                <hr>
                <div style="text-align:justify; line-height:1.9; font-size:17px; white-space:pre-line;">
                    <?php echo htmlspecialchars($berita["isi"]); ?>
                </div>
                <hr>
                <a href="berita.php" class="btn btn-secondary">← Kembali ke Berita</a>
            </div>
        </div>
    <?php } ?>
</div>

<script>
setInterval(function(){
    fetch("heartbeat.php");
},30000);
</script>
</body>
</html>