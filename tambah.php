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
}
?>

<form method="POST">
Nama: <input type="text" name="nama"><br>
Harga: <input type="number" name="harga"><br>
Stok: <input type="number" name="stok"><br>
<button type="submit">Simpan</button>
</form>