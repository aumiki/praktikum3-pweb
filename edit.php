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
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Edit Produk</h2>
    <form method="POST" action="">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama_produk" value="<?= $data['nama_produk']; ?>"
        required><br>
    
        <label>Harga:</label><br>
        <input type="text" name="harga" value="<?= $data['harga']; ?>"
        required><br>

        <label>Stok:</label><br>
        <input type="text" name="stok" value="<?= $data['stok']; ?>"
        required><br>

        <button type="submit">Update Data</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>