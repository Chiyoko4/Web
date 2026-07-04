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

use MongoDB\BSON\ObjectId;

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = $db->berita->findOne(["_id" => new ObjectId($id)]);

    if ($data) {
        if (!empty($data['gambar'])) {
            $file = "../uploads/berita/" . $data['gambar'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $db->berita->deleteOne(["_id" => new ObjectId($id)]);
    }

    header("Location: kelola_berita.php");
    exit;
}

$berita = $db->berita->find([], ["sort" => ["tanggal" => -1]]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/modern.css">
</head>
<body class="admin-body">

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin SETDA</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="kelola_berita.php">Kelola Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php">Lihat Website</a></li>
                <li class="nav-item"><a class="nav-link text-warning" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="admin-shell">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Kelola Berita</h2>
                <p class="text-muted">Kelola seluruh berita yang akan ditampilkan pada website.</p>
            </div>
            <div>
                <a href="tambah_berita.php" class="btn btn-success">+ Tambah Berita</a>
            </div>
        </div>

        <div class="card site-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-center">
                                <th width="60">No</th>
                                <th>Judul</th>
                                <th width="130">Tanggal</th>
                                <th width="150">Penulis</th>
                                <th width="100">Status</th>
                                <th width="170">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $jumlahBerita = 0;
                            foreach ($berita as $item) {
                                $jumlahBerita++;
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($item['judul']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($item['tanggal']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($item['penulis']); ?></td>
                                    <td class="text-center">
                                        <?php if ($item['status'] == "publish") { ?>
                                            <span class="badge bg-success">Publish</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Draft</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit_berita.php?id=<?php echo $item['_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="kelola_berita.php?hapus=<?php echo (string)$item['_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus berita ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php }

                            if ($jumlahBerita == 0) { ?>
                                <tr><td colspan="6" class="text-center">Belum ada berita.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
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

</html>