<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Ringkasan Booking</title>
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
        
        .summary-card { background: white; padding: 35px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border: 1px solid #eee; }
        .summary-card h3 { margin-top: 0; color: #4575e5; border-bottom: 2px solid #f8f9fa; padding-bottom: 15px; font-size: 18px; }
        
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #666; }
        .detail-value { color: #333; text-align: right; font-weight: 500; }
        
        .total-box { background-color: #f4f7fe; padding: 25px; border-radius: 12px; margin-top: 30px; text-align: right; border: 1px solid #e1e8fa; }
        .total-box h4 { margin: 0 0 10px 0; color: #666; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; }
        .total-box h2 { margin: 0; color: #1541a6; font-size: 32px; font-weight: 800; }
        
        .btn-bayar { display: block; width: 100%; text-align: center; background-color: #1541a6; color: white; padding: 18px; text-decoration: none; border-radius: 12px; font-weight: 800; font-size: 16px; margin-top: 30px; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; }
        .btn-bayar:hover { background-color: #4575e5; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(69, 117, 229, 0.2); }
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
        <h2>Ringkasan Booking</h2>
        <p>Tinjau detail pesananmu sebelum melakukan pembayaran</p>
    </div>

    <div class="container">
        <div class="breadcrumb">Beranda > Pilih Cabang > Pilih Lapangan > Pilih Jadwal > <strong>Ringkasan</strong></div>
        <h2>Ringkasan Booking</h2>

        <div class="summary-card">
            <h3>Detail Lapangan</h3>
            <div class="detail-row">
                <span class="detail-label">Lokasi:</span>
                <span class="detail-value"><?= htmlspecialchars($detail_lapangan['nama_cabang']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Lapangan:</span>
                <span class="detail-value"><?= htmlspecialchars($detail_lapangan['nama_lapangan']); ?> (<?= htmlspecialchars($detail_lapangan['nama_jenis']); ?>)</span>
            </div>
            
            <h3 style="margin-top: 30px;">Jadwal Bermain</h3>
            <div class="detail-row">
                <span class="detail-label">Tanggal:</span>
                <span class="detail-value"><?= htmlspecialchars(date('d F Y', strtotime($_SESSION['booking_sementara']['tanggal_booking']))); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Waktu:</span>
                <span class="detail-value"><?= htmlspecialchars($_SESSION['booking_sementara']['jam_mulai']); ?> - <?= htmlspecialchars($_SESSION['booking_sementara']['jam_selesai']); ?> (<?= htmlspecialchars($_SESSION['booking_sementara']['durasi']); ?> Jam)</span>
            </div>

            <div class="total-box">
                <h4>Total Tagihan</h4>
                <h2>Rp <?= number_format($_SESSION['booking_sementara']['total_biaya'], 0, ',', '.'); ?></h2>
            </div>

            <a href="<?= BASE_URL ?>index.php?page=booking&step=5" class="btn-bayar">LANJUT KE PEMBAYARAN</a>
        </div>
        <a href="<?= BASE_URL ?>index.php?page=booking&step=3" class="btn-kembali">&larr; Kembali Edit Jadwal</a>
    </div>

    <footer>
        <div><strong>BUD.ME</strong><br>Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>📞 081-182-281-812 | ✉️ budmeoffi@gmail.com</div>
        <div style="text-align: right;">Jam Operasional: 07.00 - 22.00<br><br>&copy; 2026 PT. BudMe. All Rights Reserved</div>
    </footer>
</body>
</html>