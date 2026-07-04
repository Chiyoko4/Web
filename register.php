<?php
session_start();
require "config/koneksi.php";

$pesan = "";

if (isset($_POST["daftar"])) {
    $nama = trim($_POST["nama"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $konfirmasi = $_POST["konfirmasi"];

    if (empty($nama) || empty($username) || empty($password) || empty($konfirmasi)) {
        $pesan = "Semua data wajib diisi.";
    } elseif ($password !== $konfirmasi) {
        $pesan = "Konfirmasi password tidak sesuai.";
    } else {
        $cek = $db->users->findOne(["username" => $username]);
        if ($cek) {
            $pesan = "Username sudah digunakan.";
        } else {
            $db->users->insertOne([
                "nama" => $nama,
                "username" => $username,
                "password" => $password,
                "role" => "member"
            ]);
            $_SESSION["register_berhasil"] = true;
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/modern.css">
</head>
<body class="site-body">

<div class="container py-5">
    <div class="auth-card card">
        <div class="card-header text-center">
            <h4>Register</h4>
        </div>
        <div class="card-body">
            <?php if ($pesan != "") { ?>
                <div class="alert alert-danger"><?php echo $pesan; ?></div>
            <?php } ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi" class="form-control" required>
                </div>
                <button type="submit" name="daftar" class="btn btn-primary w-100">Daftar</button>
            </form>
            <div class="text-center mt-3">
                <small>Sudah mempunyai akun? <a href="login.php">Login di sini</a></small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>