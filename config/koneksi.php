<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

    $db = $client->setda_rembang;

} catch (Exception $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}