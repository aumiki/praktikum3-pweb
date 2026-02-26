<?php
require 'connection.php';
$stmt = $pdo->query("SELECT * FROM produk ORDER BY id DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Daftar Produk</h2>
<a href="tambah.php">Tambah Produk</a>
<table border="1">
<tr>
    <th>Nama</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= htmlspecialchars($row['nama_produk']); ?></td>
    <td><?= $row['harga']; ?></td>
    <td><?= $row['stok']; ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
        <a href="hapus.php?id=<?= $row['id']; ?>">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>