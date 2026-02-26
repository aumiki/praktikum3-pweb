<?php
require 'connection.php';
$stmt = $pdo->query("SELECT * FROM produk ORDER BY id DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - HappyPaws</title>
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
            <h2>🐾 Kelola Produk</h2>
            <p>Kelola semua produk toko Anda di sini</p>
        </div>

        <div style="margin-bottom: 30px;">
            <a href="tambah.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk Baru
            </a>
            <a href="index.php" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-left"></i> Lihat Toko
            </a>
        </div>

        <?php if (count($data) === 0): ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Produk</h3>
                <p>Silakan tambahkan produk pertama Anda.</p>
                <a href="tambah.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-box"></i> Nama Produk</th>
                            <th><i class="fas fa-tag"></i> Harga</th>
                            <th><i class="fas fa-cubes"></i> Stok</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data as $row): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_produk']); ?></strong></td>
                            <td><span class="price" style="font-size: 1rem;"><?= number_format($row['harga'], 0, ',', '.'); ?></span></td>
                            <td>
                                <?php if($row['stok'] > 0): ?>
                                    <span style="color: var(--accent);"><i class="fas fa-check-circle"></i> <?= $row['stok']; ?></span>
                                <?php else: ?>
                                    <span style="color: var(--secondary);"><i class="fas fa-times-circle"></i> Habis</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>© 2024 HappyPaws - Toko Keperluan Hewan Terpercaya</p>
        </div>
    </footer>
</body>
</html>
