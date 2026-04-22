<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Pilih Tanggal dan Jam</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: #fdfffa; /* KUNCI: Pastikan hanya ada warna latar ini */
            /* HAPUS baris background-image atau linear-gradient jika masih ada di sini! */
            color: #333; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
        }
        header { background-color: #1541a6; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(21, 65, 166, 0.1); }
        header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -1px; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 600; font-size: 14px; text-transform: uppercase; transition: 0.3s; opacity: 0.8; }
        nav a:hover, nav a.active { opacity: 1; border-bottom: 2px solid white; padding-bottom: 5px; }
        
        .booking-banner { 
            width: 100%; 
            height: 250px; /* Atur tinggi banner sesuai kebutuhan */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= BASE_URL ?>assets/images/bg-badminton.jpg'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 0 0 25px 25px; /* Melengkung di bawah */
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            color: white; 
            z-index: 1; /* Di bawah kotak konten */
            position: relative;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            overflow: hidden;
            margin-bottom: -150px; /* Negatif margin agar kotak di bawah menumpuk */
        }

        .booking-banner h2 { 
            margin: 0; 
            font-size: 50px; /* Sedikit dibesarkan */
            font-weight: 900; 
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1541a6; /* Warna teks biru */
            -webkit-text-stroke: 1.5px #ffffff; /* INI KUNCINYA: Garis tepi putih */
            text-shadow: 2px 2px 5px rgba(0,0,0,0.6); /* Tambahan bayangan agar makin pop-up */
        }

        .booking-banner p { 
            margin: 5px 0 0 0; 
            font-size: 16px; 
            font-weight: 500; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.6); 
        }

        /* 3. UBAH: CONTAINER STANDAR (Dibuat Menumpuk di Atas Banner) */
        .container { 
            padding: 30px; 
            max-width: 900px; 
            margin: 0 auto; 
            flex: 1; 
            width: 100%; 
            box-sizing: border-box; 
            position: relative; /* Atur posisi agar z-index berfungsi */
            z-index: 2; /* Di atas banner */
            background-color: transparent; /* Latar belakang kontainer transparan agar banner terlihat */
            margin-top: 180px; /* Beri margin atas agar konten tidak tertutup banner (sesuaikan dengan tinggi banner) */
            padding-top: 30px; /* Beri padding atas */
        }

        /* 4. UBAH: TEKS LUAR (Kembali ke Biru Tua agar terbaca di Latar Putih) */
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; font-weight: 500; }
        h2 { color: #1541a6; font-weight: 800; margin-top: 0; }
        
        .form-card { background: white; padding: 35px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border: 1px solid #eee; border-top: 6px solid #4575e5; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 10px; color: #555; font-size: 15px; }
        .form-group input, .form-group select { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 12px; box-sizing: border-box; font-size: 16px; transition: 0.3s; background-color: #fff; }
        .form-group input:focus, .form-group select:focus { border-color: #4575e5; outline: none; box-shadow: 0 0 0 3px rgba(69, 117, 229, 0.1); }
        
        .btn-lanjut { display: block; width: 100%; background-color: #1541a6; color: white; padding: 15px; border: none; border-radius: 12px; font-weight: 800; font-size: 16px; cursor: pointer; margin-top: 30px; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; }
        .btn-lanjut:hover { background-color: #4575e5; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(69, 117, 229, 0.2); }
        .btn-kembali { display: inline-block; margin-top: 25px; color: #666; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.3s; }
        .btn-kembali:hover { color: #1541a6; text-decoration: underline; }
        
        footer { background-color: #1541a6; color: white; padding: 30px; margin-top: auto; font-size: 13px; width: 100%; box-sizing: border-box; display: flex; justify-content: space-between; opacity: 0.95; }
    </style>
</head>
<body>
    <header>
        <h1>🏸 BUD.ME</h1>
        <nav>
            <a href="<?= BASE_URL ?>index.php?page=beranda">Beranda</a>
            <a href="<?= BASE_URL ?>index.php?page=booking" class="active">Booking</a>
            <a href="<?= BASE_URL ?>index.php?page=riwayat">Riwayat</a>
            <a href="<?= BASE_URL ?>index.php?page=profil">Profil 👤</a>
        </nav>
    </header>

    <div class="booking-banner">
        <h2>Pilih Jadwal Bermain</h2>
        <p>Tentukan tanggal dan jam untuk bermain</p>
    </div>

    <div class="container">
        <div class="breadcrumb">Beranda > Pilih Cabang > Pilih Lapangan > <strong>Pilih Jadwal</strong></div>
        <h2>Pilih Tanggal dan Jam Bermain</h2>
            <?php if(isset($_GET['error']) && $_GET['error'] == 'past_time'): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 12px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                    ⚠️ Maaf, kamu tidak bisa memesan jam yang sudah lewat!
                </div>
            <?php endif; ?>
        <div class="form-card">
            <form action="<?= BASE_URL ?>index.php?page=booking&step=4" method="POST">
                <div class="form-group">
                    <label>Pilih Tanggal</label>
                    <input type="date" name="tanggal_booking" min="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group">
                    <label>Pilih Jam Mulai</label>
                    <select name="jam_mulai" required>
                        <option value="">-- Pilih Jam --</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Durasi Bermain</label>
                    <select name="durasi" required>
                        <option value="1">1 Jam</option>
                        <option value="2">2 Jam</option>
                        <option value="3">3 Jam</option>
                    </select>
                </div>
                <button type="submit" class="btn-lanjut">LANJUTKAN KE RINGKASAN</button>
            </form>
        </div>
        <a href="<?= BASE_URL ?>index.php?page=booking&step=2&cabang_id=<?= $_SESSION['booking_sementara']['cabang_id'] ?? '' ?>" class="btn-kembali">&larr; Kembali Pilih Lapangan</a>
    </div>

    <footer>
        <div><strong>BUD.ME</strong><br>Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>📞 081-182-281-812 | ✉️ budmeoffi@gmail.com</div>
        <div style="text-align: right;">Jam Operasional: 07.00 - 22.00<br><br>&copy; 2026 PT. BudMe. All Rights Reserved</div>
    </footer>
</body>
</html>