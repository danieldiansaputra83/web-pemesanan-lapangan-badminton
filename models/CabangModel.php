<?php
class CabangModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil semua cabang untuk halaman Pilih Cabang
    public function getAllCabang() {
        $query = "SELECT * FROM cabang";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil lapangan berdasarkan Cabang ID (JOIN 3 Tabel)
    public function getLapanganByCabang($cabang_id) {
        $query = "SELECT l.id as lapangan_id, l.nama_lapangan, j.nama_jenis, j.harga_weekday, j.harga_weekend 
                  FROM lapangan l
                  JOIN jenis_lantai j ON l.jenis_lantai_id = j.id
                  WHERE l.cabang_id = :cabang_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cabang_id", $cabang_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil detail satu lapangan untuk halaman Ringkasan Booking (JOIN 3 Tabel)
    public function getDetailLapangan($lapangan_id) {
        $query = "SELECT l.nama_lapangan, c.nama_cabang, j.nama_jenis, j.harga_weekday, j.harga_weekend 
                  FROM lapangan l
                  JOIN cabang c ON l.cabang_id = c.id
                  JOIN jenis_lantai j ON l.jenis_lantai_id = j.id
                  WHERE l.id = :lapangan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":lapangan_id", $lapangan_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>