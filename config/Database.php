<?php
class Database {
    // Encapsulation: Menyembunyikan kredensial database menggunakan modifier 'private'
    private $host = "localhost";
    private $db_name = "budme_db";
    private $username = "root";
    private $password = "";
    
    // Property yang bisa diakses dari luar class
    public $conn;

    // Method untuk mendapatkan koneksi PDO
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi Database Error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>