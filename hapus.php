<?php
require 'config/database.php';
require 'models/produk.php';

$database = new Database();
$conn = $database->getConnection();

$produk = new Produk($conn);
$produk->id = $_GET['id'];

// Get product info first
$produk->readOne();
$produk_data = [
    'nama_produk' => $produk->nama_produk,
    'harga' => $produk->harga,
    'stok' => $produk->stok
];

if (!$produk_data['nama_produk']) {
    header("Location: produk.php");
    exit;
}

// Handle deletion
if (isset($_POST['confirm_delete'])) {
    $produk->id = $_GET['id'];
    
    if ($produk->delete()) {
        header("Location: produk.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Produk - HappyPaws</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fredoka:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <i class="fas fa-paw logo-icon"></i>
                <h1>HappyPaws</h1>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
            <a href="produk.php"><i class="fas fa-box"></i> Kelola Produk</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <div class="page-title">
            <h2>🗑️ Hapus Produk</h2>
            <p>Konfirmasi penghapusan produk</p>
        </div>

        <a href="produk.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>

        <div class="form-container" style="text-align: center;">
            <div style="margin-bottom: 30px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: var(--secondary); margin-bottom: 20px;"></i>
                <h3 style="margin-bottom: 15px;">Apakah Anda yakin?</h3>
                <p style="color: var(--gray); margin-bottom: 30px;">Produk berikut akan dihapus secara permanen:</p>
            </div>

            <div style="background: var(--light); padding: 20px; border-radius: var(--radius); margin-bottom: 30px;">
                <p><strong><?= htmlspecialchars($produk_data['nama_produk']); ?></strong></p>
                <p class="price" style="font-size: 1.2rem;">Rp <?= number_format($produk_data['harga'], 0, ',', '.'); ?></p>
                <p style="color: var(--gray);">Stok: <?= $produk_data['stok']; ?></p>
            </div>

            <form method="POST" action="">
                <div class="form-actions" style="justify-content: center;">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus Produk
                    </button>
                    <a href="produk.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>© 2024 HappyPaws - Toko Keperluan Hewan Terpercaya</p>
        </div>
    </footer>
</body>
</html>