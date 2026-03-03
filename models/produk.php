<?php
class Produk {
    private $conn;
    private $table_name = "produk";

    // Properties
    public $id;
    public $nama_produk;
    public $harga;
    public $stok;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create - Menambahkan produk baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama_produk, harga, stok) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $this->nama_produk);
        $stmt->bindParam(2, $this->harga);
        $stmt->bindParam(3, $this->stok);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read - Membaca semua produk
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read All - Alias untuk read()
    public function readAll() {
        return $this->read();
    }

    // Read - Membaca produk berdasarkan ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->nama_produk = $row['nama_produk'];
            $this->harga = $row['harga'];
            $this->stok = $row['stok'];
            return true;
        }
        return false;
    }

    // Read - Membaca produk yang stoknya tersedia
    public function readAvailable() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE stok > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update - Mengupdate produk
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_produk = ?, harga = ?, stok = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $this->nama_produk);
        $stmt->bindParam(2, $this->harga);
        $stmt->bindParam(3, $this->stok);
        $stmt->bindParam(4, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete - Menghapus produk
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update Stok - Mengupdate jumlah stok produk
    public function updateStok($new_stok) {
        $query = "UPDATE " . $this->table_name . " SET stok = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $new_stok);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Kurangi Stok - Mengurangi stok saat produk dibeli
    public function reduceStok($quantity) {
        $query = "UPDATE " . $this->table_name . " SET stok = stok - ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $quantity);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
