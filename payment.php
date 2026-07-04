<?php
session_start();
require 'config/koneksi.php';
require 'config/midtrans.php';

$amount = 1000;
$midtransConfigured = !empty(getenv('MIDTRANS_SERVER_KEY')) && !empty(getenv('MIDTRANS_CLIENT_KEY'));

if (!$midtransConfigured) {
    $midtransConfigured = (strpos(\Midtrans\Config::$serverKey, 'REPLACE_ME') === false) && (strpos(\Midtrans\Config::$clientKey, 'REPLACE_ME') === false);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? 'Pengguna');
    $email = trim($_POST['email'] ?? 'pengguna@example.com');
    $telepon = trim($_POST['telepon'] ?? '081234567890');
    $orderId = 'QRIS-' . date('YmdHis') . '-' . substr(md5(uniqid('', true)), 0, 6);

    try {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'item_details' => [
                [
                    'id' => 'qris-1000',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Pembayaran QRIS Rp1.000',
                ],
            ],
            'customer_details' => [
                'first_name' => $nama,
                'email' => $email,
                'phone' => $telepon,
            ],
            'enabled_payments' => ['qris'],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $_SESSION['midtrans_order_id'] = $orderId;
        $_SESSION['midtrans_amount'] = $amount;
        $_SESSION['midtrans_token'] = $snapToken;
        $_SESSION['midtrans_customer'] = $nama;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/modern.css">
</head>
<body class="site-body">
<div class="container py-5">
    <div class="site-card">
        <div class="card-body p-4 p-md-5">
            <div class="mb-4">
                <h2 class="hero-title mb-2">Pembayaran QRIS</h2>
                <p class="text-muted mb-0">Metode pembayaran hanya QRIS dengan nominal tetap Rp1.000.</p>
            </div>

            <?php if (!$midtransConfigured) { ?>
                <div class="alert alert-warning">
                    Midtrans belum dikonfigurasi. Silakan isi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY terlebih dahulu di environment server Anda.
                </div>
            <?php } ?>

            <?php if (!empty($errorMessage)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php } ?>

            <?php if (!empty($_SESSION['midtrans_token'])) { ?>
                <div class="alert alert-success">
                    Order ID: <strong><?php echo htmlspecialchars($_SESSION['midtrans_order_id']); ?></strong><br>
                    Nominal: <strong>Rp<?php echo number_format($_SESSION['midtrans_amount'], 0, ',', '.'); ?></strong>
                </div>

                <div class="d-grid gap-2 d-md-block">
                    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                    <a href="payment.php" class="btn btn-outline-secondary">Buat Lagi</a>
                </div>

                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo htmlspecialchars(\Midtrans\Config::$clientKey); ?>"></script>
                <script>
                    document.getElementById('pay-button')?.addEventListener('click', function () {
                        window.snap.pay('<?php echo htmlspecialchars($_SESSION['midtrans_token']); ?>', {
                            onSuccess: function(result){ window.location.href = 'payment_result.php?status=success&order_id=' + encodeURIComponent(result.order_id || ''); },
                            onPending: function(result){ window.location.href = 'payment_result.php?status=pending&order_id=' + encodeURIComponent(result.order_id || ''); },
                            onError: function(result){ window.location.href = 'payment_result.php?status=error&order_id=' + encodeURIComponent(result.order_id || ''); },
                            onClose: function(){ window.location.href = 'payment_result.php?status=closed'; }
                        });
                    });
                </script>
            <?php } else { ?>
                <form method="post" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required value="Administrator">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required value="admin@example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" required value="081234567890">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nominal</label>
                        <input type="text" class="form-control" value="Rp1.000" readonly>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Buat Pembayaran QRIS</button>
                        <a href="index.php" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
