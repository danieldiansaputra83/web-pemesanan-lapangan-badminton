<?php
require_once 'config/Database.php';
require_once 'models/BookingModel.php';

class RiwayatController {
    private $bookingModel;

    public function __construct() {
        // Menerapkan OOP: Membuat object database dan model
        $database = new Database();
        $db = $database->getConnection();
        $this->bookingModel = new BookingModel($db);
    }

    public function index() {
        // Cek apakah pengguna sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?page=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        $this->bookingModel->autoUpdateStatusSelesai();
        
        // Memanggil method dari Model untuk mengambil data dari database
        $riwayat_booking = $this->bookingModel->getRiwayatByUser($user_id);

        // Memuat tampilan
        require_once 'views/riwayat.php';
    }
}
?>