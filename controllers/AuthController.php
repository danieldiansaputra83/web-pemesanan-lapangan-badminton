<?php
require_once 'config/Database.php';
require_once 'models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        // Membuat Object dari Class UserModel
        $this->userModel = new UserModel($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password === $confirm_password) {
                // Memanggil Method register dari Object userModel
                if ($this->userModel->register($nama, $email, $password)) {
                    header("Location: " . BASE_URL . "index.php?page=login&status=success");
                    exit();
                } else {
                    $error_msg = "Gagal mendaftar. Email mungkin sudah digunakan.";
                    require_once 'views/daftar.php';
                }
            } else {
                $error_msg = "Password tidak cocok!";
                require_once 'views/daftar.php';
            }
        } else {
            require_once 'views/daftar.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                header("Location: " . BASE_URL . "index.php?page=beranda");
                exit();
            } else {
                $error_msg = "Email atau password salah!";
                require_once 'views/login.php';
            }
        } else {
            require_once 'views/login.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL . "index.php?page=login");
        exit();
    }
}
?>