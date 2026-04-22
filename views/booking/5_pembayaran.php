<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUD.ME - Pembayaran</title>
    <style>
        /* CSS TETAP SAMA SEPERTI SEBELUMNYA */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?= BASE_URL ?>assets/images/bg-badminton.jpg'); background-size: cover; background-position: center; background-attachment: fixed; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        header { background-color: #1541a6; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); }
        header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -1px; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 600; font-size: 14px; text-transform: uppercase; opacity: 0.8; }
        .container { padding: 30px; max-width: 800px; margin: 0 auto; flex: 1; width: 100%; box-sizing: border-box; }
        .payment-card { background: rgba(255, 255, 255, 0.95); padding: 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); border-top: 6px solid #1541a6; text-align: center; }
        .total-amount { font-size: 38px; font-weight: 900; color: #1541a6; margin: 15px 0 30px 0; letter-spacing: -1px; }
        
        /* OPSI METODE */
        .method-option { display: flex; align-items: center; background: #fff; padding: 18px; border: 2px solid #eee; border-radius: 12px; margin-bottom: 15px; cursor: pointer; transition: 0.3s; font-size: 15px; font-weight: 600; color: #555; }
        .method-option:hover { border-color: #4575e5; background: #f4f7fe; }
        .method-option input { margin-right: 15px; transform: scale(1.3); accent-color: #1541a6; }

        /* AREA DINAMIS (QRIS / UPLOAD) */
        #dynamic-area { margin-top: 20px; display: none; padding: 20px; border: 1px dashed #ccc; border-radius: 12px; background: #fafafa; }
        .qris-img { width: 200px; cursor: pointer; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn-upload { background-color: #4575e5; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; margin-top: 10px; }
        
        footer { background-color: #1541a6; color: white; padding: 30px; margin-top: auto; font-size: 13px; width: 100%; box-sizing: border-box; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <header>
        <h1>🏸 BUD.ME</h1>
        <nav>
            <a href="#">Beranda</a><a href="#">Booking</a><a href="#">Riwayat</a><a href="#">Profil 👤</a>
        </nav>
    </header>

    <div class="container">
        <div class="payment-card">
            <p style="color: #666; font-weight: 600;">Total Tagihan:</p>
            <div class="total-amount">Rp <?= number_format($_SESSION['booking_sementara']['total_biaya'], 0, ',', '.'); ?></div>

            <div id="payment-selection">
                <h4 style="text-align: left; margin-bottom: 15px;">Pilih Metode Pembayaran:</h4>
                <div class="method-option" onclick="showOption('QRIS')">
                    <input type="radio" name="pay_method" value="QRIS"> QRIS (Gopay/OVO/Dana)
                </div>
                <div class="method-option" onclick="showOption('Transfer')">
                    <input type="radio" name="pay_method" value="Transfer Bank"> Transfer Bank
                </div>
                <div class="method-option" onclick="handleEwallet()">
                    <input type="radio" name="pay_method" value="E-Wallet"> E-Wallet (Direct Pay)
                </div>
            </div>

            <div id="dynamic-area">
                </div>
        </div>
    </div>

    <footer>
        <div><strong>BUD.ME</strong><br>Jalan Meongin Nomor 67, Klojent, Kota Mawlang<br>📞 081-182-281-812 | ✉️ budmeoffi@gmail.com</div>
        <div style="text-align: right;">Jam Operasional: 07.00 - 22.00<br><br>&copy; 2026 PT. BudMe. All Rights Reserved</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const baseUrl = "<?= BASE_URL ?>";

        function showOption(type) {
            const area = document.getElementById('dynamic-area');
            area.style.display = 'block';
            
            if(type === 'QRIS') {
                area.innerHTML = `
                    <p style="font-size: 14px; color: #666;">Silakan scan QRIS di bawah ini:</p>
                    <img src="${baseUrl}assets/images/qris-dummy.png" class="qris-img" onclick="finishPayment('QRIS')" alt="Klik di sini jika sudah scan" title="Klik jika sudah bayar">
                    <p style="font-size: 12px; color: #d9534f; margin-top: 10px; font-weight: bold;">*Klik Gambar QRIS jika sudah bayar</p>
                `;
            } else if(type === 'Transfer') {
                area.innerHTML = `
                    <p style="font-size: 14px; color: #666; text-align: left;">Upload Struk Transfer:</p>
                    <input type="file" id="struk-file" class="editable-input" style="width:100%; margin-bottom:10px;">
                    <button class="btn-upload" onclick="finishPayment('Transfer Bank')">UNGGAH STRUK</button>
                `;
            }
        }

        function handleEwallet() {
            finishPayment('E-Wallet');
        }

        function finishPayment(method) {
            let formData = new FormData();
            formData.append('metode_pembayaran', method);

            fetch(baseUrl + "index.php?page=booking&step=5", {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data.trim() === "success") {
                    // PAKAI SWEETALERT AGAR POP-UP MODERN
                    Swal.fire({
                        title: '✅ Pembayaran Berhasil!',
                        text: 'Pesananmu sudah masuk ke sistem BUD.ME',
                        icon: 'success',
                        confirmButtonColor: '#1541a6',
                        confirmButtonText: 'OKE SIAP!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = baseUrl + "index.php?page=beranda";
                        }
                    });
                } else {
                    Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                }
            });
        }
    </script>
</body>
</html>