<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Pilih Cabang</title>
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
     
        h2 { color: #ffffff; font-weight: 800; margin-top: 0; }
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
        
        .search-bar { width: 100%; padding: 15px; margin-bottom: 30px; border: 1px solid #ddd; border-radius: 12px; box-sizing: border-box; font-size: 15px; transition: 0.3s; }
        .search-bar:focus { border-color: #4575e5; outline: none; box-shadow: 0 0 0 3px rgba(69, 117, 229, 0.1); }
        
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #eee; border-left: 6px solid #4575e5; transition: 0.3s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(69, 117, 229, 0.15); }
        .card-info h3 { margin: 0 0 10px 0; color: #1541a6; font-size: 20px; }
        .card-info p { margin: 5px 0; color: #666; font-size: 14px; }
        
        .btn-pilih { background-color: #1541a6; color: white; padding: 12px 25px; text-decoration: none; border-radius: 12px; font-weight: bold; transition: 0.3s; display: inline-block; }
        .btn-pilih:hover { background-color: #4575e5; transform: scale(1.05); }
        
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
        <h2>Pilih GOR Badminton</h2>
        <p>Temukan cabang terdekat dari lokasimu</p>
    </div>

    <div class="container">
        <div class="breadcrumb">Beranda > <strong>Booking</strong></div>
        <h2>Pilih Cabang Lapangan</h2>
        <input type="text" id="searchInput" class="search-bar" placeholder="🔍 Cari nama cabang, alamat, atau kota..." onkeyup="filterCabang()">

        <?php foreach($data_cabang as $cabang): ?>
            <div class="card">
                <div class="card-info">
                    <h3><?= htmlspecialchars($cabang['nama_cabang']); ?></h3>
                    <p>📍 <?= htmlspecialchars($cabang['alamat']); ?></p>
                    <p>📞 <?= htmlspecialchars($cabang['kontak']); ?></p>
                    <p>⏰ <?= htmlspecialchars(substr($cabang['jam_buka'], 0, 5)); ?> - <?= htmlspecialchars(substr($cabang['jam_tutup'], 0, 5)); ?></p>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>index.php?page=booking&step=2&cabang_id=<?= $cabang['id'] ?>" class="btn-pilih">Pilih Cabang</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <div><strong>BUD.ME</strong><br>Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>📞 081-182-281-812 | ✉️ budmeoffi@gmail.com</div>
        <div style="text-align: right;">Jam Operasional: 07.00 - 22.00<br><br>&copy; 2026 PT. BudMe. All Rights Reserved</div>
    </footer>

    <script>
        function filterCabang() {
            // Ambil inputan user dan ubah ke huruf kecil semua
            let input = document.getElementById('searchInput').value.toLowerCase();
            // Ambil semua elemen kotak cabang (.card)
            let cards = document.querySelectorAll('.card');
            
            // Lakukan perulangan untuk mengecek setiap kotak
            cards.forEach(function(card) {
                // Ambil seluruh teks di dalam kotak tersebut
                let textInside = card.textContent || card.innerText;
                
                // Jika teks cocok dengan inputan, tampilkan. Jika tidak, sembunyikan.
                if (textInside.toLowerCase().indexOf(input) > -1) {
                    card.style.display = "flex"; // Tetap pertahankan display:flex dari CSS
                } else {
                    card.style.display = "none"; // Sembunyikan kotak
                }
            });
        }
    </script>
</body>
</html>