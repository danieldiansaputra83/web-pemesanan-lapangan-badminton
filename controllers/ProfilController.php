<?php
require_once 'config/Database.php';
require_once 'models/UserModel.php';

class ProfilController {
    private $userModel;

    public function __construct() {
        // OOP: Membuat object database dan model
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
    }

    public function index() {
        $this->cekLogin();
        $user_id = $_SESSION['user_id'];
        
        // Ambil data profil terbaru dari database
        $profil = $this->userModel->getUserProfile($user_id);

        // Tentukan apakah halaman ditampilkan dalam Mode Edit
        $is_edit = (isset($_GET['action']) && $_GET['action'] == 'edit');

        // LOGIKA MEMPROSES FORM SIMPAN (POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan_profil'])) {
            // 1. Tangkap data teks dan bersihkan (XSS Protection)
            $nama_baru = htmlspecialchars($_POST['nama']);
            $hp_baru = htmlspecialchars($_POST['nomor_hp']);
            $foto_baru_filename = null;

            // 2. Logika Unggah Foto (Jika ada file yang dipilih)
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $target_dir = "assets/images/profile/";
                $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                
                // Validasi Tipe File (Hanya JPG/PNG)
                $allowed_types = ['jpg', 'jpeg', 'png'];
                if (!in_array(strtolower($file_extension), $allowed_types)) {
                    $error_msg = "Format foto harus JPG atau PNG.";
                } else if ($_FILES["foto"]["size"] > 2000000) { // Validasi Ukuran (Maks 2MB)
                    $error_msg = "Ukuran foto maksimal 2MB.";
                } else {
                    // Buat nama file unik: userid_waktu.jpg
                    $foto_baru_filename = $user_id . "_" . time() . "." . $file_extension;
                    $target_file = $target_dir . $foto_baru_filename;

                    // Pindahkan file dari folder sementara ke folder assets
                    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                        $error_msg = "Gagal mengunggah foto profil.";
                        $foto_baru_filename = null; // Gagal upload, jangan update database
                    }
                }
            }

            // Jika tidak ada error validasi, simpan ke database
            if (!isset($error_msg)) {
                if ($this->userModel->updateProfile($user_id, $nama_baru, $hp_baru, $foto_baru_filename)) {
                    // Update session nama agar sapaan di navbar/beranda ikut berubah
                    $_SESSION['nama'] = $nama_baru;
                    // Alihkan kembali ke halaman profil biasa dengan status sukses
                    header("Location: " . BASE_URL . "index.php?page=profil&status=success");
                    exit();
                } else {
                    $error_msg = "Gagal memperbarui profil ke database.";
                }
            }
        }

        // Muat View (mengirimkan variabel data profil dan status mode edit)
        require_once 'views/profil.php';
    }

    private function cekLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?page=login");
            exit();
        }
    }
}
?>