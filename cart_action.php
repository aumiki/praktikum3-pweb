<?php
session_start();
require 'connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_REQUEST['action'] ?? '';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    
    // Check stock in database
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan']);
        exit;
    }

    $current_in_cart = $_SESSION['cart'][$id]['quantity'] ?? 0;

    if ($product['stok'] > $current_in_cart) {
        // Add to session cart
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'nama_produk' => $product['nama_produk'],
                'harga' => $product['harga'],
                'quantity' => 1
            ];
        }

        // Calculate total count
        $cart_count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cart_count += $item['quantity'];
        }

        echo json_encode([
            'success' => true, 
            'message' => 'Produk ditambahkan ke keranjang',
            'cart_count' => $cart_count,
            'new_stock' => $product['stok'] - ($current_in_cart + 1)
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Stok tidak mencukupi!']);
    }
    exit;
}

if ($action === 'get_cart') {
    $items = [];
    foreach ($_SESSION['cart'] as $id => $details) {
        $items[] = [
            'id' => $id,
            'nama_produk' => $details['nama_produk'],
            'harga' => $details['harga'],
            'quantity' => $details['quantity']
        ];
    }
    echo json_encode(['items' => $items]);
    exit;
}
?>

