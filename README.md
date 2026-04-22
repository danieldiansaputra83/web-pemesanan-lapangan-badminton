# 🏸 BUD.ME - Badminton Court Booking System

BUD.ME adalah aplikasi web responsif yang dirancang untuk mendigitalisasi proses pemesanan lapangan badminton, khususnya untuk wilayah Malang. Proyek ini berfokus pada kemudahan navigasi bagi pengguna dan pengelolaan data yang terstruktur bagi penyedia lapangan.

## 🚀 Fitur Utama

- **Interactive Booking Flow:** Alur pemesanan yang mulus mulai dari pemilihan cabang, tipe lapangan, hingga jadwal yang tersedia.
- **Modern UI/UX:** Antarmuka bertema sporty dengan palet warna biru tua (dark blue) dan putih, dilengkapi dengan animasi transisi yang halus.
- **Secure Authentication:** Sistem login yang aman menggunakan *password hashing* dan *session-based authentication*.
- **Robust Security:** Implementasi pencegahan *SQL Injection* untuk menjaga integritas basis data.
- **Real-time Status:** Memastikan tidak ada jadwal ganda (double booking) pada waktu yang sama.

## 🛠️ Tech Stack

- **Backend:** PHP Native (dengan prinsip OOP & arsitektur MVC)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Keamanan:** Password Hashing, Prepared Statements (SQL Injection Prevention)

## 🏗️ Arsitektur Proyek

Proyek ini dikembangkan menggunakan pola **Model-View-Controller (MVC)** untuk memastikan kode yang bersih, modular, dan mudah dipelihara (*maintainable*):

- **Model:** Menangani logika data dan interaksi dengan database MySQL.
- **View:** Mengelola presentasi data dan antarmuka pengguna (User Interface).
- **Controller:** Bertindak sebagai jembatan yang menghubungkan Model dan View.

## 📸 Tampilan Aplikasi

![Dashboard BUD.ME](assets/dashboard-mockup.png)
![Halaman Booking](assets/booking-page.png)
