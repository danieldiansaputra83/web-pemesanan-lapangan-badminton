<?php
session_start();

require_once 'config/config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    case 'login':
    case 'register':
    case 'logout':
        require_once 'controllers/AuthController.php';
        $authController = new AuthController();
        
        if ($page == 'login') {
            $authController->login();
        } elseif ($page == 'register') {
            $authController->register();
        } elseif ($page == 'logout') {
            $authController->logout();
        }
        break;

    case 'beranda':
        require_once 'controllers/BerandaController.php';
        $berandaController = new BerandaController();
        $berandaController->index();
        break;

    case 'booking':
        require_once 'controllers/BookingController.php';
        $bookingController = new BookingController();
        
        $step = isset($_GET['step']) ? $_GET['step'] : '1';
        if ($step == '1') {
            $bookingController->pilihCabang();
        } elseif ($step == '2') {
            $bookingController->pilihLapangan();
        } elseif ($step == '3') {
            $bookingController->pilihJadwal();
        } elseif ($step == '4') {
            $bookingController->detailBooking();
        } elseif ($step == '5') {
            $bookingController->prosesPembayaran(); // <--- Tambahan Tahap Akhir
        }
        break;

    case 'riwayat':
        require_once 'controllers/RiwayatController.php';
        $riwayatController = new RiwayatController();
        $riwayatController->index();
        break;

    case 'profil':
        require_once 'controllers/ProfilController.php';
        $profilController = new ProfilController();
        $profilController->index();
        break;

    default:
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        break;
}
?>