<?php
session_start();
require 'config/koneksi.php';

if (isset($_SESSION["register_berhasil"])) {
    echo '<div class="alert alert-success text-center">Registrasi berhasil. Silakan login.</div>';
    unset($_SESSION["register_berhasil"]);
}

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $user = $db->users->findOne(['username' => $username]);

    if ($user && $password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        $db->users->updateOne(
            ["_id" => $user["_id"]],
            ['$set' => ["last_active" => date("Y-m-d H:i:s")]]
        );

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/modern.css">
</head>
<body class="site-body">

<div class="container py-5">
    <div class="auth-card card">
        <div class="card-header text-center">
            <h4>Login Admin</h4>
        </div>
        <div class="card-body">
            <?php if ($error != "") { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="text-center mt-3">
                    <small>Belum mempunyai akun? <a href="register.php">Daftar di sini</a></small>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 mt-3">Masuk</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>