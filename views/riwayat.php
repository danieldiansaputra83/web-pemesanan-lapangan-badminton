<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Riwayat Pemesanan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #fdfffa; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        header { background-color: #1541a6; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(21, 65, 166, 0.1); }
        header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -1px; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 600; font-size: 14px; text-transform: uppercase; transition: 0.3s; opacity: 0.8; }
        nav a:hover, nav a.active { opacity: 1; border-bottom: 2px solid white; padding-bottom: 5px; }
        .container { padding: 30px; max-width: 900px; margin: 0 auto; flex: 1; width: 100%; box-sizing: border-box; }
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; font-weight: 500; }
        h2 { color: #1541a6; font-weight: 800; margin-top: 0; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        
        .history-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #eee; border-left: 6px solid #4575e5; transition: 0.3s; }
        .history-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(69, 117, 229, 0.1); }
        .history-info h3 { margin: 0 0 8px 0; color: #1541a6; font-size: 18px; }
        .history-info p { margin: 5px 0; color: #666; font-size: 14px; }
        .history-price { font-size: 20px; font-weight: 800; color: #333; text-align: right; }
        
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: bold; color: white; margin-top: 10px; text-transform: uppercase; }
        .status-aktif { background-color: #4575e5; }
        .status-selesai { background-color: #6c757d; }
        .status-menunggu { background-color: #ffc107; color: #333; }
        
        footer { background-color: #1541a6; color: white; padding: 30px; margin-top: auto; font-size: 13px; width: 100%; box-sizing: border-box; display: flex; justify-content: space-between; opacity: 0.95; }
    </style>
</head>
<body>
    <header>
        <h1>🏸 BUD.ME</h1>
        <nav>
            <a href="<?= BASE_URL ?>index.php?page=beranda">Beranda</a>
            <a href="<?= BASE_URL ?>index.php?page=booking">Booking</a>
            <a href="<?= BASE_URL ?>index.php?page=riwayat" class="active">Riwayat</a>
            <a href="<?= BASE_URL ?>index.php?page=profil">Profil 👤</a>
        </nav>
    </header>

    <div class="container">
        <div class="breadcrumb">Beranda > <strong>Riwayat</strong></div>
        <h2>Riwayat Pemesanan</h2>

        <?php if(!empty($riwayat_booking)): ?>
            <?php foreach($riwayat_booking as $booking): ?>
                <div class="history-card">
                    <div class="history-info">
                        <h3><?= htmlspecialchars($booking['nama_cabang']); ?> (<?= htmlspecialchars($booking['nama_lapangan']); ?>)</h3>
                        <p>📅 <?= htmlspecialchars(date('d F Y', strtotime($booking['tanggal_booking']))); ?></p>
                        <p>⏰ <?= htmlspecialchars(substr($booking['jam_mulai'], 0, 5)); ?> - <?= htmlspecialchars(substr($booking['jam_selesai'], 0, 5)); ?></p>
                        <?php 
                            if ($booking['status_booking'] == 'Aktif') $status_class = 'status-aktif';
                            elseif ($booking['status_booking'] == 'Menunggu Pembayaran') $status_class = 'status-menunggu';
                            else $status_class = 'status-selesai'; 
                        ?>
                        <span class="status-badge <?= $status_class ?>"><?= htmlspecialchars($booking['status_booking']); ?></span>
                    </div>
                    <div class="history-price">Rp <?= number_format($booking['total_biaya'], 0, ',', '.'); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="history-card" style="justify-content: center; text-align: center; border-left: 6px solid #ccc;">
                <p>Belum ada riwayat pemesanan. Yuk, booking lapangan sekarang!</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <div><strong>BUD.ME</strong><br>Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>📞 081-182-281-812 | ✉️ budmeoffi@gmail.com</div>
        <div style="text-align: right;">Jam Operasional: 07.00 - 22.00<br><br>&copy; 2026 PT. BudMe. All Rights Reserved</div>
    </footer>
</body>
</html>