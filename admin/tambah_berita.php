<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $judul = trim($_POST['judul']);
    $isi = trim($_POST['isi']);
    $tanggal = trim($_POST['tanggal']);
    $penulis = trim($_POST['penulis']);
    $status = trim($_POST['status']);

    $gambar = "default.jpg";

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $folder = "../uploads/berita/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $namaBaru = time() . "." . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $folder . $namaBaru);
        $gambar = $namaBaru;
    }

    $db->berita->insertOne([
        "judul" => $judul,
        "isi" => $isi,
        "tanggal" => $tanggal,
        "penulis" => $penulis,
        "status" => $status,
        "gambar" => $gambar
    ]);

    header("Location: kelola_berita.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/modern.css">
</head>
<body class="admin-body">

<div class="container py-5">
    <div class="form-card card">
        <div class="card-header" style="background:transparent; border-bottom:1px solid rgba(255,255,255,0.08);">
            <h4 class="mb-0">Tambah Berita</h4>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Berita</label>
                    <textarea name="isi" class="form-control" rows="8" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="publish">Publish</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="kelola_berita.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="site-footer">
    <div class="container text-center">
        <p class="mb-0">© <?php echo date("Y"); ?> Admin SETDA Rembang</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
setInterval(function(){
    fetch("../heartbeat.php");
},30000);
</script>
</body>
</html>