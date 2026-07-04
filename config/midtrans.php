<?php
require_once __DIR__ . '/../vendor/autoload.php';

\Midtrans\Config::$serverKey = getenv('MIDTRANS_SERVER_KEY') ?: 'Mid-server--l4YgZZ-sNOZgFPh_G9TAeBP';
\Midtrans\Config::$clientKey = getenv('MIDTRANS_CLIENT_KEY') ?: 'Mid-client-6oY1LAfRsOI7GzNa';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
