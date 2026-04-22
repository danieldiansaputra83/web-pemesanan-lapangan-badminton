<?php
require_once 'config/Database.php';
require_once 'models/BookingModel.php';

class BerandaController {
    private $bookingModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->bookingModel = new BookingModel($db);
    }

    public function index() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?page=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $nama_user = $_SESSION['nama']; 

        // --- TAMBAHKAN BARIS INI (Update status diam-diam) ---
        $this->bookingModel->autoUpdateStatusSelesai();
        // -----------------------------------------------------

        // 1. Ambil data statistik kotak (Total, Aktif, Selesai, Pengeluaran)
        $stats = $this->bookingModel->getDashboardStats($user_id);
        
        // 2. Ambil data list booking aktif untuk Slider
        $booking_aktif_list = $this->bookingModel->getActiveBookings($user_id);
        
        // 3. Ambil data notifikasi H-3
        $notifikasi = $this->bookingModel->getNearestBookingNotification($user_id);

        // Menampilkan halaman beranda
        require_once 'views/beranda.php';
    }
}
?>