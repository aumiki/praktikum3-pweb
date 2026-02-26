<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO produk (nama_produk, harga, stok) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $harga, $stok]);

    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - HappyPaws</title>
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
            <h2>➕ Tambah Produk Baru</h2>
            <p>Tambahkan produk baru ke dalam toko Anda</p>
        </div>

        <a href="produk.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>

        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama"><i class="fas fa-box"></i> Nama Produk</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama produk" required>
                </div>

                <div class="form-group">
                    <label for="harga"><i class="fas fa-tag"></i> Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" placeholder="Masukkan harga produk" min="0" required>
                </div>

                <div class="form-group">
                    <label for="stok"><i class="fas fa-cubes"></i> Stok</label>
                    <input type="number" id="stok" name="stok" placeholder="Masukkan jumlah stok" min="0" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Produk
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
