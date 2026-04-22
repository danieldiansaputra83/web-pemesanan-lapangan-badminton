<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Profil Pengguna</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #fdfffa; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        header { background-color: #1541a6; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(21, 65, 166, 0.1); }
        header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -1px; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 600; font-size: 14px; text-transform: uppercase; transition: 0.3s; opacity: 0.8; }
        nav a:hover, nav a.active { opacity: 1; border-bottom: 2px solid white; padding-bottom: 5px; }
        .container { padding: 30px; max-width: 800px; margin: 0 auto; flex: 1; width: 100%; box-sizing: border-box; }
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; font-weight: 500; }
        
        .profile-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border: 1px solid #eee; margin-top: 20px; }
        .profile-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .profile-header h2 { margin: 0; color: #1541a6; font-weight: 800; }
        .greeting { font-size: 20px; font-weight: bold; color: #333; }
        
        .profile-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; font-size: 14px; }
        
        .editable-input { width: 100%; padding: 12px; background-color: #fff; border: 1px solid #ccc; border-radius: 12px; font-size: 15px; color: #333; box-sizing: border-box; transition: 0.3s; }
        .editable-input:focus { border-color: #4575e5; outline: none; box-shadow: 0 0 0 3px rgba(69, 117, 229, 0.1); }
        .locked-value { padding: 12px; background-color: #f8f9fa; border: 1px solid #eee; border-radius: 12px; font-size: 15px; color: #666; }
        
        .btn-action { display: inline-block; padding: 12px 20px; color: white; text-decoration: none; border-radius: 12px; font-weight: bold; text-align: center; margin-top: 20px; border: none; cursor: pointer; font-size: 14px; transition: 0.3s; }
        .btn-edit { background-color: #1541a6; }
        .btn-edit:hover { background-color: #4575e5; transform: translateY(-2px); }
        .btn-save { background-color: #4575e5; margin-right: 10px; }
        .btn-save:hover { background-color: #1541a6; transform: translateY(-2px); }
        .btn-cancel { background-color: #e9ecef; color: #333; }
        .btn-cancel:hover { background-color: #dee2e6; }
        .btn-logout { background-color: #dc3545; margin-left: 10px; }
        .btn-logout:hover { background-color: #c82333; transform: translateY(-2px); }
        
        footer { background-color: #1541a6; color: white; padding: 30px; margin-top: auto; font-size: 13px; width: 100%; box-sizing: border-box; display: flex; justify-content: space-between; opacity: 0.95; }
        .alert { padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; text-align: center; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <header>
        <h1>🏸 BUD.ME</h1>
        <nav>
            <a href="<?= BASE_URL ?>index.php?page=beranda">Beranda</a>
            <a href="<?= BASE_URL ?>index.php?page=booking">Booking</a>
            <a href="<?= BASE_URL ?>index.php?page=riwayat">Riwayat</a>
            <a href="<?= BASE_URL ?>index.php?page=profil" class="active">Profil 👤</a>
        </nav>
    </header>

    <div class="container">
        <div class="breadcrumb">Beranda > <strong>Profil</strong></div>
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success">Profil berhasil diperbarui!</div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-header">
                <h2>Profil Pengguna</h2>
                <div class="greeting">Hai, <?= htmlspecialchars($_SESSION['nama'] ?? 'User'); ?>!!</div>
            </div>

            <div style="text-align: center; margin-bottom: 30px;">
                <img src="<?= BASE_URL ?>assets/images/profile/<?= htmlspecialchars($profil['foto'] ?? 'default_profile.png'); ?>" alt="Foto Profil" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #4575e5; padding: 4px;">
            </div>

            <?php if($is_edit): ?>
                <form action="<?= BASE_URL ?>index.php?page=profil&action=edit" method="POST" enctype="multipart/form-data">
                    <div class="profile-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="editable-input" value="<?= htmlspecialchars($profil['nama'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="nomor_hp" class="editable-input" value="<?= htmlspecialchars($profil['nomor_hp'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Ganti Foto Profil</label>
                            <input type="file" name="foto" class="editable-input" style="padding: 9px;">
                        </div>
                        <div class="form-group">
                            <label>Email (Terkunci)</label>
                            <div class="locked-value"><?= htmlspecialchars($profil['email'] ?? '-'); ?></div>
                        </div>
                        <div class="form-group">
                            <label>Status Akun</label>
                            <div class="locked-value" style="color: #4575e5; font-weight: bold;"><?= htmlspecialchars($profil['status_akun'] ?? 'AKTIF'); ?></div>
                        </div>
                    </div>
                    <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                        <button type="submit" name="simpan_profil" class="btn-action btn-save">SIMPAN PERUBAHAN</button>
                        <a href="<?= BASE_URL ?>index.php?page=profil" class="btn-action btn-cancel">BATAL</a>
                    </div>
                </form>
            <?php else: ?>
                <div class="profile-grid">
                    <div class="form-group">
                        <label>Nama</label>
                        <div class="locked-value"><?= htmlspecialchars($profil['nama'] ?? 'Belum diatur'); ?></div>
                    </div>
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <div class="locked-value"><?= htmlspecialchars($profil['nomor_hp'] ?? 'Belum diatur'); ?></div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <div class="locked-value"><?= htmlspecialchars($profil['email'] ?? '-'); ?></div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Bergabung</label>
                        <div class="locked-value"><?= htmlspecialchars($profil['tanggal_bergabung'] ?? '-'); ?></div>
                    </div>
                </div>
                <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                    <a href="<?= BASE_URL ?>index.php?page=profil&action=edit" class="btn-action btn-edit">EDIT PROFIL</a>
                    <a href="<?= BASE_URL ?>index.php?page=logout" class="btn-action btn-logout">LOGOUT</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div><strong>BUD.ME</strong><br>Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>📞 081-182-281-812 | ✉️ budmeoffi@gmail.com</div>
        <div style="text-align: right;">Jam Operasional: 07.00 - 22.00<br><br>&copy; 2026 PT. BudMe. All Rights Reserved</div>
    </footer>
</body>
</html>