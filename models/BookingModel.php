<?php
class BookingModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil statistik untuk Dashboard (Beranda)
    public function getDashboardStats($user_id) {
        $query = "SELECT 
                    COUNT(id) as total_booking,
                    SUM(CASE WHEN status_booking = 'Aktif' THEN 1 ELSE 0 END) as booking_aktif,
                    SUM(CASE WHEN status_booking = 'Selesai' THEN 1 ELSE 0 END) as booking_selesai,
                    SUM(total_biaya) as total_pengeluaran
                  FROM bookings 
                  WHERE user_id = :user_id";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(empty($result['total_pengeluaran'])) {
            $result['total_pengeluaran'] = 0;
        }
        return $result;
    }

    // Mengambil DAFTAR semua booking aktif untuk fitur Slider
    public function getActiveBookings($user_id) {
        $query = "SELECT b.tanggal_booking, b.jam_mulai, b.jam_selesai, c.nama_cabang, l.nama_lapangan
                  FROM bookings b
                  JOIN lapangan l ON b.lapangan_id = l.id
                  JOIN cabang c ON l.cabang_id = c.id
                  WHERE b.user_id = :user_id AND b.status_booking = 'Aktif'
                  ORDER BY b.tanggal_booking ASC, b.jam_mulai ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil Notifikasi Booking Terdekat (Maksimal H-3)
    public function getNearestBookingNotification($user_id) {
        $query = "SELECT b.tanggal_booking, b.jam_mulai, c.nama_cabang, l.nama_lapangan,
                         DATEDIFF(b.tanggal_booking, CURDATE()) as sisa_hari
                  FROM bookings b
                  JOIN lapangan l ON b.lapangan_id = l.id
                  JOIN cabang c ON l.cabang_id = c.id
                  WHERE b.user_id = :user_id 
                        AND b.status_booking = 'Aktif'
                        AND b.tanggal_booking >= CURDATE()
                        AND DATEDIFF(b.tanggal_booking, CURDATE()) <= 3
                  ORDER BY b.tanggal_booking ASC, b.jam_mulai ASC
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengambil Riwayat Booking (JOIN tabel bookings, lapangan, dan cabang)
    public function getRiwayatByUser($user_id) {
        $query = "SELECT b.tanggal_booking, b.jam_mulai, b.jam_selesai, b.total_biaya, b.status_booking, 
                         c.nama_cabang, l.nama_lapangan
                  FROM bookings b
                  JOIN lapangan l ON b.lapangan_id = l.id
                  JOIN cabang c ON l.cabang_id = c.id
                  WHERE b.user_id = :user_id
                  ORDER BY b.tanggal_booking DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk menyimpan booking dan pembayaran sekaligus (Database Transaction)
    public function buatBooking($user_id, $data_booking, $metode_pembayaran) {
        try {
            // Memulai transaksi agar jika satu gagal, gagal semua (aman untuk data keuangan)
            $this->conn->beginTransaction();

            // 1. Insert ke tabel bookings (Status langsung 'Aktif' karena simulasi bayar sukses)
            $query1 = "INSERT INTO bookings (user_id, lapangan_id, tanggal_booking, jam_mulai, jam_selesai, total_biaya, status_booking) 
                       VALUES (:user_id, :lapangan_id, :tanggal, :jam_mulai, :jam_selesai, :total_biaya, 'Aktif')";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':user_id', $user_id);
            $stmt1->bindParam(':lapangan_id', $data_booking['lapangan_id']);
            $stmt1->bindParam(':tanggal', $data_booking['tanggal_booking']);
            $stmt1->bindParam(':jam_mulai', $data_booking['jam_mulai']);
            $stmt1->bindParam(':jam_selesai', $data_booking['jam_selesai']);
            $stmt1->bindParam(':total_biaya', $data_booking['total_biaya']);
            $stmt1->execute();

            // 2. Dapatkan ID booking yang baru saja otomatis dibuat oleh database
            $booking_id = $this->conn->lastInsertId();

            // 3. Insert ke tabel pembayaran
            $query2 = "INSERT INTO pembayaran (booking_id, metode_pembayaran, status_pembayaran) 
                       VALUES (:booking_id, :metode, 'Berhasil')";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':booking_id', $booking_id);
            $stmt2->bindParam(':metode', $metode_pembayaran);
            $stmt2->execute();

            // Jika kedua insert berhasil, simpan permanen ke database
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            // Jika ada error (misal koneksi putus), batalkan semua perubahan
            $this->conn->rollBack();
            return false;
        }
    }
    
    public function autoUpdateStatusSelesai() {
        // Query ini mengecek: Jika tanggal kurang dari hari ini, ATAU 
        // tanggalnya hari ini tapi jam selesainya sudah lewat, maka ubah jadi 'Selesai'
        $query = "UPDATE bookings 
                  SET status_booking = 'Selesai' 
                  WHERE status_booking = 'Aktif' 
                  AND (tanggal_booking < CURDATE() 
                       OR (tanggal_booking = CURDATE() AND jam_selesai <= CURTIME()))";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
?>