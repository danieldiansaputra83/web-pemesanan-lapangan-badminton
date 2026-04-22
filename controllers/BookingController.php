<?php
require_once 'config/Database.php';
require_once 'models/CabangModel.php';
require_once 'models/BookingModel.php';

class BookingController {
    private $db;
    private $cabangModel;
    private $bookingModel; // <--- 1. Tambahkan baris ini

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cabangModel = new CabangModel($this->db);
        $this->bookingModel = new BookingModel($this->db); // <--- 2. Tambahkan baris ini juga
    }

    // ... (kode fungsi pilihCabang() dan ke bawahnya biarkan tetap sama persis)
    // TAHAP 1: Pilih Cabang 
    public function pilihCabang() {
        $this->cekLogin();
        
        $data_cabang = $this->cabangModel->getAllCabang();
        require_once 'views/booking/1_pilih_cabang.php';
    }

    // TAHAP 2: Pilih Jenis Lapangan 
    public function pilihLapangan() {
        $this->cekLogin();

        $cabang_id = isset($_GET['cabang_id']) ? $_GET['cabang_id'] : null;

        if ($cabang_id) {
            $_SESSION['booking_sementara']['cabang_id'] = $cabang_id;
        } else if (!isset($_SESSION['booking_sementara']['cabang_id'])) {
            header("Location: " . BASE_URL . "index.php?page=booking&step=1");
            exit();
        }

        $data_lapangan = $this->cabangModel->getLapanganByCabang($_SESSION['booking_sementara']['cabang_id']);
        
        require_once 'views/booking/2_pilih_lapangan.php';
    }

    // TAHAP 3: Pilih Jadwal (Tanggal & Jam)
    public function pilihJadwal() {
        $this->cekLogin();

        // Tangkap ID lapangan dari URL saat user klik "Pilih Lapangan" di Step 2
        $lapangan_id = isset($_GET['lapangan_id']) ? $_GET['lapangan_id'] : null;

        if ($lapangan_id) {
            // Simpan ID lapangan ke dalam session sementara
            $_SESSION['booking_sementara']['lapangan_id'] = $lapangan_id;
        } else if (!isset($_SESSION['booking_sementara']['lapangan_id'])) {
            // Jika iseng buka URL tanpa milih lapangan, kembalikan ke step 2
            header("Location: " . BASE_URL . "index.php?page=booking&step=2");
            exit();
        }

        // Memanggil View untuk Tahap 3 yang baru saja kita buat
        require_once 'views/booking/3_pilih_jadwal.php';
    }

    // TAHAP 4: Ringkasan Booking (Menghitung Total Harga)
    public function detailBooking() {
        $this->cekLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tanggal_input = $_POST['tanggal_booking'];
            $jam_input = $_POST['jam_mulai'];
            
            // LOGIKA VALIDASI WAKTU NYATA
            $sekarang = new DateTime();
            $waktu_booking = new DateTime($tanggal_input . ' ' . $jam_input);

            if ($waktu_booking <= $sekarang) {
                // Jika waktu sudah lewat, lempar balik ke step 3 dengan error
                header("Location: " . BASE_URL . "index.php?page=booking&step=3&error=past_time");
                exit();
            }
        }

        // Menangkap data dari form Step 3
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['booking_sementara']['tanggal_booking'] = $_POST['tanggal_booking'];
            $_SESSION['booking_sementara']['jam_mulai'] = $_POST['jam_mulai'];
            $_SESSION['booking_sementara']['durasi'] = $_POST['durasi'];
        }

        // Cek apakah data tanggal sudah ada
        if (!isset($_SESSION['booking_sementara']['tanggal_booking'])) {
            header("Location: " . BASE_URL . "index.php?page=booking&step=3");
            exit();
        }

        // Ambil detail harga dan nama lapangan dari database
        $lapangan_id = $_SESSION['booking_sementara']['lapangan_id'];
        $detail_lapangan = $this->cabangModel->getDetailLapangan($lapangan_id);

        // Hitung Jam Selesai
        $jam_mulai = $_SESSION['booking_sementara']['jam_mulai'];
        $durasi = $_SESSION['booking_sementara']['durasi'];
        // Menambahkan durasi ke jam mulai
        $jam_selesai = date('H:i', strtotime($jam_mulai . " + $durasi hours"));
        $_SESSION['booking_sementara']['jam_selesai'] = $jam_selesai;

        // Cek Hari (Weekday atau Weekend) untuk menentukan harga
        $tanggal = $_SESSION['booking_sementara']['tanggal_booking'];
        $dayOfWeek = date('N', strtotime($tanggal)); // 1 (Senin) sampai 7 (Minggu)
        
        if ($dayOfWeek >= 6) { // Jika Sabtu atau Minggu
            $harga_per_jam = $detail_lapangan['harga_weekend'];
        } else { // Jika Senin - Jumat
            $harga_per_jam = $detail_lapangan['harga_weekday'];
        }

        // Hitung Total Biaya
        $total_biaya = $harga_per_jam * $durasi;
        $_SESSION['booking_sementara']['total_biaya'] = $total_biaya;

        // Memanggil View Tahap 4
        require_once 'views/booking/4_detail_booking.php';
    }

    // TAHAP 5: Proses Pembayaran
    public function prosesPembayaran() {
        $this->cekLogin();

        // Jika dipanggil via POST (setelah klik OK di notifikasi)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $data_booking = $_SESSION['booking_sementara'];
            $metode = $_POST['metode_pembayaran'];

            // Simpan ke database
            if ($this->bookingModel->buatBooking($user_id, $data_booking, $metode)) {
                unset($_SESSION['booking_sementara']);
                // Kirim respon sukses untuk dibaca JavaScript
                echo "success"; 
                exit();
            }
        }
        // Tampilkan halaman awal pembayaran
        require_once 'views/booking/5_pembayaran.php';
    }

    private function cekLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?page=login");
            exit();
        }
    }
}
?>