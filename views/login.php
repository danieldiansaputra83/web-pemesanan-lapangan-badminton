<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Akses Masuk</title>
    <style>
        /* 1. GLOBAL & BACKGROUND */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            background-color: #fdfffa; /* Warna Latar Baru */
            margin: 0; 
            color: #333;
        }

        /* 2. LOGIN BOX (Minimalis & Modern) */
        .login-box { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; /* Lebih membulat */
            box-shadow: 0 10px 25px rgba(21, 65, 166, 0.1); /* Shadow kebiruan tipis */
            text-align: center; 
            width: 350px; 
            border: 1px solid rgba(21, 65, 166, 0.05);
        }

        /* 3. TYPOGRAPHY & LOGO */
        h1 { 
            color: #1541a6; /* Warna Utama Baru */
            margin-bottom: 5px; 
            font-size: 32px;
            font-weight: 800;
        }
        p.subtitle { 
            font-size: 14px; 
            color: #666; 
            margin-bottom: 30px; 
            font-weight: 400;
        }
        h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* 4. FORM INPUTS (Modern) */
        input { 
            width: 100%; 
            padding: 12px 15px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 12px; /* Standar bulatan 12px */
            box-sizing: border-box; 
            font-size: 14px;
            transition: 0.3s;
        }
        input:focus {
            border-color: #4575e5; /* Warna Secondary saat fokus */
            outline: none;
            box-shadow: 0 0 0 3px rgba(69, 117, 229, 0.1);
        }

        /* 5. PRIMARY BUTTON (Sporty & Dynamic) */
        button { 
            width: 100%; 
            padding: 12px; 
            background-color: #1541a6; /* Warna Utama */
            color: white; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 16px;
            margin-top: 15px;
            transition: 0.3s;
            text-transform: uppercase; /* Agar sporty */
            letter-spacing: 1px;
        }
        button:hover { 
            background-color: #4575e5; /* Warna Secondary saat hover */
            transform: translateY(-2px); /* Efek angkat sedikit */
        }

        /* 6. MESSAGES & LINKS */
        .error { color: #dc3545; font-size: 14px; margin-bottom: 10px; background: #f8d7da; padding: 10px; border-radius: 8px; }
        .success { color: #28a745; font-size: 14px; margin-bottom: 10px; background: #d4edda; padding: 10px; border-radius: 8px; }
        .links a { 
            display: block; 
            margin-top: 15px; 
            color: #4575e5; /* Warna Secondary */
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500;
        }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>BUD.ME</h1>
        <p class="subtitle">Sobat Booking Lapangan Badminton Kamu!</p>

        <h2>LOGIN</h2>

        <?php if (isset($error_msg)): ?>
            <p class="error"><?= $error_msg; ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <p class="success">Pendaftaran berhasil! Silakan login.</p>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>index.php?page=login" method="POST">
            <input type="email" name="email" placeholder="iniemail@gmail.com" required>
            <input type="password" name="password" placeholder="InIPassWord55" required>
            <button type="submit">LOGIN</button>
        </form>

        <div class="links">
            <a href="<?= BASE_URL ?>index.php?page=register">DAFTAR</a>
        </div>
    </div>
</body>
</html>