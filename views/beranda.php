<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Beranda</title>
    <style>
        /* 1. GLOBAL & BACKGROUND IMAGE */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            /* Lapisan gelap diturunkan jadi 0.3 agar gambar lebih terang & jelas */
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?= BASE_URL ?>assets/images/bg-badminton.jpg');
            background-size: cover; 
            background-position: center; 
            background-attachment: fixed; 
            color: #333; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
        }

        /* 2. HEADER (Ini yang tadi hilang!) */
        header { 
            background-color: #1541a6; 
            color: white; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); /* Shadow dipertegas */
        }
        header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -1px; }
        nav a { 
            color: white; 
            text-decoration: none; 
            margin-left: 20px; 
            font-weight: 600; 
            font-size: 14px;
            text-transform: uppercase;
            transition: 0.3s;
            opacity: 0.8;
        }
        nav a:hover, nav a.active { opacity: 1; border-bottom: 2px solid white; padding-bottom: 5px; }

        /* 3. CONTAINER & TEKS LUAR (Diberi bayangan agar terbaca di atas gambar) */
        .container { padding: 30px; max-width: 1000px; margin: 0 auto; flex: 1; width: 100%; box-sizing: border-box; }
        /* 3. TEKS SAPAAN DIPERBESAR */
        .greeting { font-size: 32px; font-weight: 700; margin-bottom: 35px; color: #ffffff; text-shadow: 2px 2px 4px rgba(0,0,0,0.6); }

        /* 4. RUNNING NOTIFICATION (Skala Diperbesar) */
        .marquee-container { 
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 18px 25px; /* Padding ditambah */
            border-radius: 50px; 
            display: flex; 
            align-items: center; 
            margin-bottom: 40px; 
            overflow: hidden; 
            position: relative;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .marquee-icon { font-size: 26px; margin-right: 20px; z-index: 2; }
        .marquee-content { white-space: nowrap; animation: marquee 15s linear infinite; color: #1541a6; font-weight: 700; font-size: 18px;} /* Font dibesarkan */
        @keyframes marquee { 0% { transform: translateX(100%); } 100% { transform: translateX(-180%); } }

        /* 5. KOTAK STATISTIK (Skala Diperbesar) */
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 25px; /* Jarak antar kotak dilebarkan */
            margin-bottom: 50px; 
            width: 100%;
        }
        .stat-card { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 25px; 
            border-radius: 20px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.15); 
            display: flex; 
            flex-direction: column; 
            height: 220px; /* Tinggi kotak ditambah dari 160px ke 220px */
            box-sizing: border-box;
            text-align: center;
        }
        .stat-card h3 { 
            margin: 0; 
            font-size: 16px; /* Ukuran font judul dibesarkan */
            color: #666; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            font-weight: 600;
            padding-top: 10px;
        }
        .stat-card p { 
            margin: auto 0; 
            font-size: 40px; /* Ukuran nominal dibesarkan drastis */
            font-weight: 900; 
            color: #1541a6; 
            white-space: nowrap; 
            display: block;
            width: 100%;
        }
        
        /* 6. BOOKING SECTION (Skala Diperbesar) */
        .booking-section { display: flex; gap: 25px; align-items: stretch; margin-bottom: 40px; min-height: 250px; }
        .slider-wrapper { 
            flex: 2; 
            background: rgba(69, 117, 229, 0.95); 
            padding: 35px; /* Padding ditambah */
            border-radius: 20px; 
            color: white; 
            overflow: hidden; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .slider-container { display: flex; gap: 20px; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 10px; }
        .slider-container::-webkit-scrollbar { height: 8px; }
        .slider-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }
        .slide-item { min-width: 100%; scroll-snap-align: start; box-sizing: border-box; }
        .slide-item h3 { margin-top: 0; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 15px; margin-bottom: 20px; font-size: 24px; font-weight: 700;}
        .slide-item p { margin: 10px 0; font-size: 18px; opacity: 0.9; }
        
        .btn-pesan { 
            flex: 1; 
            background: rgba(21, 65, 166, 0.95); 
            color: white; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            text-decoration: none; 
            font-size: 32px; /* Ukuran teks tombol dibesarkan */
            font-weight: 900; 
            border-radius: 20px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3); 
            transition: 0.3s;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: -1px;
            padding: 30px;
            border: 2px solid rgba(255,255,255,0.1);
        }
        .btn-pesan:hover { background: #4575e5; transform: scale(1.03); }

        /* 7. FOOTER */
        footer { 
            background-color: #1541a6; 
            color: white; 
            padding: 30px; 
            margin-top: auto; 
            font-size: 13px; 
            width: 100%; 
            box-sizing: border-box; 
            display: flex; 
            justify-content: space-between;
        }
        footer strong { font-size: 16px; }
    </style>
</head>
<body>

    <header>
        <h1>🏸 BUD.ME</h1>
        <nav>
            <a href="<?= BASE_URL ?>index.php?page=beranda" class="active">Beranda</a>
            <a href="<?= BASE_URL ?>index.php?page=booking">Booking</a>
            <a href="<?= BASE_URL ?>index.php?page=riwayat">Riwayat</a>
            <a href="<?= BASE_URL ?>index.php?page=profil">Profil 👤</a>
        </nav>
    </header>

    <div class="container">
        <div class="greeting">Hai, <?= htmlspecialchars($nama_user ?? 'User'); ?> !!</div>

        <div class="marquee-container">
            <div class="marquee-icon">📢</div>
            <div class="marquee-content">
                <?php if($notifikasi): ?>
                    <?php $hari = ($notifikasi['sisa_hari'] == 0) ? "Hari ini" : "H-" . $notifikasi['sisa_hari']; ?>
                    [<?= substr($notifikasi['jam_mulai'], 0, 5) ?>] <?= $hari ?> Jadwal Booking di <?= htmlspecialchars($notifikasi['nama_lapangan']) ?>, <?= htmlspecialchars($notifikasi['nama_cabang']) ?>. Jangan sampai telat ya!
                <?php else: ?>
                    Belum ada jadwal main terdekat dalam 3 hari ke depan. Yuk, segera agendakan main badmintonmu!
                <?php endif; ?>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Booking</h3>
                <p><?= htmlspecialchars($stats['total_booking'] ?? 0); ?></p>
            </div>
            <div class="stat-card">
                <h3>Booking Aktif</h3>
                <p><?= htmlspecialchars($stats['booking_aktif'] ?? 0); ?></p>
            </div>
            <div class="stat-card">
                <h3>Booking Selesai</h3>
                <p><?= htmlspecialchars($stats['booking_selesai'] ?? 0); ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Pengeluaran</h3>
                <p>Rp <?= number_format($stats['total_pengeluaran'] ?? 0, 0, ',', '.'); ?></p>
            </div>
        </div>

        <div class="booking-section">
            <div class="slider-wrapper">
                <div class="slider-container">
                    <?php if(!empty($booking_aktif_list)): ?>
                        <?php foreach($booking_aktif_list as $index => $b_aktif): ?>
                            <div class="slide-item">
                                <h3>Jadwal Aktif (<?= $index + 1 ?>/<?= count($booking_aktif_list) ?>)</h3>
                                <p>📅 <?= htmlspecialchars(date('l, d F Y', strtotime($b_aktif['tanggal_booking']))); ?></p>
                                <p>⏰ Pukul <?= htmlspecialchars(substr($b_aktif['jam_mulai'], 0, 5)); ?> - <?= htmlspecialchars(substr($b_aktif['jam_selesai'], 0, 5)); ?></p>
                                <p>📍 <?= htmlspecialchars($b_aktif['nama_lapangan']); ?>, <?= htmlspecialchars($b_aktif['nama_cabang']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="slide-item">
                            <h3>Belum ada booking aktif nih!</h3>
                            <p>Jadwal lapanganmu masih kosong.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if(count($booking_aktif_list) > 1): ?>
                    <small style="opacity: 0.7; font-size: 11px;">*Geser kesamping untuk jadwal lainnya &rarr;</small>
                <?php endif; ?>
            </div>

            <a href="<?= BASE_URL ?>index.php?page=booking" class="btn-pesan">PESAN<br>SEKARANG!!</a>
        </div>
    </div>

    <footer>
        <div>
            <strong>BUD.ME</strong><br>
            Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>
            📞 081-182-281-812 | ✉️ budmeoffi@gmail.com
        </div>
        <div style="text-align: right;">
            Jam Operasional: 07.00 - 22.00<br><br>
            &copy; 2026 PT. BudMe. All Rights Reserved
        </div>
    </footer>

</body>
</html>