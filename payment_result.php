<?php
session_start();
$status = $_GET['status'] ?? 'unknown';
$orderId = $_GET['order_id'] ?? ($_SESSION['midtrans_order_id'] ?? '-');
$amount = $_SESSION['midtrans_amount'] ?? 1000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/modern.css">
</head>
<body class="site-body">
<div class="container py-5">
    <div class="site-card">
        <div class="card-body p-4 p-md-5">
            <h2 class="hero-title mb-3">Status Pembayaran</h2>
            <?php if ($status === 'success') { ?>
                <div class="alert alert-success">Pembayaran berhasil diterima.</div>
            <?php } elseif ($status === 'pending') { ?>
                <div class="alert alert-warning">Pembayaran sedang menunggu konfirmasi.</div>
            <?php } elseif ($status === 'error') { ?>
                <div class="alert alert-danger">Pembayaran gagal atau dibatalkan.</div>
            <?php } else { ?>
                <div class="alert alert-secondary">Sesi pembayaran ditutup.</div>
            <?php } ?>
            <p class="text-muted">Order ID: <strong><?php echo htmlspecialchars($orderId); ?></strong></p>
            <p class="text-muted">Nominal: <strong>Rp<?php echo number_format($amount, 0, ',', '.'); ?></strong></p>
            <a href="payment.php" class="btn btn-primary">Coba Lagi</a>
            <a href="index.php" class="btn btn-outline-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
</body>
</html>
