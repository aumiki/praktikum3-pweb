<?php
require 'connection.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "UPDATE produk SET nama_produk = ?, harga = ?, stok = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nama_produk, $harga, $stok, $id])) {
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
    <title>Edit Produk - HappyPaws</title>
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
            <h2>✏️ Edit Produk</h2>
            <p>Perbarui informasi produk</p>
        </div>

        <a href="produk.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>

        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama_produk"><i class="fas fa-box"></i> Nama Produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="harga"><i class="fas fa-tag"></i> Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" value="<?= $data['harga']; ?>" min="0" required>
                </div>

                <div class="form-group">
                    <label for="stok"><i class="fas fa-cubes"></i> Stok</label>
                    <input type="number" id="stok" name="stok" value="<?= $data['stok']; ?>" min="0" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Data
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
