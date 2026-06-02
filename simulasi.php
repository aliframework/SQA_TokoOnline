<?php

require_once 'src/Catalog.php';
require_once 'src/Checkout.php';

use App\Catalog;
use App\Checkout;

$fileProduk = __DIR__ . '/data/products.json';
$filePesanan = __DIR__ . '/data/orders.json';

echo "=== SIMULASI TOKO ONLINE ===\n\n";

try {

    // 1. Tampilkan katalog
    $katalog = new Catalog($fileProduk);

    echo "Daftar Produk:\n";
    print_r($katalog->getAllProducts());

    // 2. Simulasi checkout
    echo "\nMemproses Checkout...\n";

    $checkoutManager = new Checkout($fileProduk, $filePesanan);

    $keranjangBudi = [
        'PRD-001' => 2,
        'PRD-002' => 1
    ];

    // TAMBAHKAN PARAMETER ALAMAT
    $nota = $checkoutManager->prosesCheckout(
        'budi@email.com',
        'Jl. Mawar No. 10',
        $keranjangBudi
    );

    echo "\nCheckout Berhasil!\n";
    print_r($nota);

} catch (Exception $e) {

    echo "\nGAGAL: " . $e->getMessage();

}