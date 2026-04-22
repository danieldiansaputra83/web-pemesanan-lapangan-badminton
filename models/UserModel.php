<?php
class UserModel {
    // Property dengan Encapsulation (private) [cite: 342, 343]
    private $conn;
    private $table_name = "users";

    // Method Constructor [cite: 343]
    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nama, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " (nama, email, password, status_akun, tanggal_bergabung) VALUES (:nama, :email, :password, 'AKTIF', CURDATE())";
        $stmt = $this->conn->prepare($query);

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password_hash);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($email, $password) {
        $query = "SELECT id, nama, email, password, nomor_hp, status_akun FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    public function getUserProfile($user_id) {
        // Tambahkan kolom 'foto' ke dalam SELECT query
        $query = "SELECT nama, email, nomor_hp, tanggal_bergabung, status_akun, foto FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method baru untuk mengedit profil pengguna (OOP Encapsulation)
    public function updateProfile($user_id, $nama, $hp, $foto_filename = null) {
        // Query dasar UPDATE Nama dan Nomor HP
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, nomor_hp = :hp";

        // Jika ada foto baru yang diunggah, tambahkan ke query UPDATE
        if ($foto_filename) {
            $query .= ", foto = :foto";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind data (Security: Menghindari SQL Injection)
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':hp', $hp);
        $stmt->bindParam(':id', $user_id);
        
        if ($foto_filename) {
            $stmt->bindParam(':foto', $foto_filename);
        }

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>