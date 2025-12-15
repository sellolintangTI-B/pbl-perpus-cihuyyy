<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            background: linear-gradient(135deg, #0B3F78 0%, #1DA0B4 100%);
            padding: 40px 20px;
            text-align: center;
        }

        .header-icon {
            font-size: 64px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 10px 0 0 0;
        }

        .content {
            padding: 40px 30px;
        }

        .content h2 {
            color: #0B3F78;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: bold;

        }

        .content p {
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            background-color: #e8f5f3;
            color: #1CBAA3;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .booking-code-section {
            background: linear-gradient(135deg, #1CBAA3 0%, #1DA0B4 100%);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 8px 24px rgba(28, 186, 163, 0.3);
        }

        .booking-code-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .booking-code {
            background-color: #ffffff;
            color: #0B3F78;
            font-size: 36px;
            font-weight: 700;
            padding: 20px 30px;
            border-radius: 8px;
            letter-spacing: 4px;
            margin: 15px 0;
            display: inline-block;
            font-family: 'Courier New', monospace;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .booking-code-note {
            color: rgba(255, 255, 255, 0.95);
            font-size: 14px;
            margin-top: 15px;
        }

        .booking-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #1CBAA3;
        }

        .booking-details h3 {
            color: #0B3F78;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-weight: 600;

        }

        .booking-details h3::before {
            margin-right: 10px;
            font-size: 22px;
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            flex: 0 0 160px;
            font-weight: 600;
            color: #555555;
            font-size: 14px;
        }

        .detail-value {
            flex: 1;
            color: #333333;
            font-size: 14px;
        }

        .detail-value.highlight {
            color: #1CBAA3;
            font-weight: 600;
        }

        .info-box {
            background-color: #fff8e6;
            border-left: 4px solid #ffc107;
            padding: 18px 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .info-box h4 {
            color: #d97706;
            font-size: 16px;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
        }

        .info-box h4::before {
            margin-right: 8px;
        }

        .info-box ul {
            margin: 10px 0 0 0;
            color: #555555;
            font-size: 14px;
            line-height: 1.8;
        }

        .info-box ul li {
            margin-bottom: 6px;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .action-button {
            display: inline-block;
            padding: 16px 40px;
            background-color: #0B3F78;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px rgba(11, 63, 120, 0.3);
            margin: 0 10px 10px 0;
        }

        .action-button:hover {
            background-color: #1DA0B4;
        }

        .action-button.secondary {
            background-color: #1CBAA3;
            box-shadow: 0 4px 12px rgba(28, 186, 163, 0.3);
        }

        .action-button.secondary:hover {
            background-color: #1DA0B4;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer p {
            color: #666666;
            font-size: 14px;
            margin: 5px 0;
        }

        .footer a {
            color: #1DA0B4;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 30px 0;
        }

        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .header-icon {
                font-size: 48px;
            }

            .content h2 {
                font-size: 20px;
            }

            .booking-code {
                font-size: 28px;
                padding: 15px 20px;
                letter-spacing: 2px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                margin-bottom: 5px;
            }

            .action-button {
                display: block;
                margin: 10px 0;
            }

            .booking-details {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Booking Berhasil</h1>
            <p>Peminjaman ruangan anda berhasil dibuat</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Halo, [Nama User]!</h2>

            <div class="status-badge">DIBUAT</div>

            <p>Selamat! Peminjaman ruangan perpustakaan Anda telah berhasil diproses. Simpan kode booking ini dengan baik karena akan digunakan saat Anda tiba di perpustakaan.</p>

            <!-- Booking Code Section -->
            <div class="booking-code-section">
                <div class="booking-code-label">Kode Booking Anda</div>
                <div class="booking-code">LIB24A001</div>
                <div class="booking-code-note">
                    💡 Tunjukkan kode ini kepada petugas perpustakaan
                </div>
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <h3>Detail Peminjaman Ruangan</h3>
                <div class="detail-row">
                    <div class="detail-label">Kode Booking:</div>
                    <div class="detail-value highlight">LIB24A001</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nama Ruangan:</div>
                    <div class="detail-value">Ruang Diskusi A - Lt. 2</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Kapasitas:</div>
                    <div class="detail-value">8 Orang</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal:</div>
                    <div class="detail-value">Selasa, 17 Desember 2024</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Waktu:</div>
                    <div class="detail-value">09:00 - 11:00 WIB (2 Jam)</div>
                </div>
            </div>

            <!-- Important Info -->
            <div class="info-box">
                <h4>Informasi Penting</h4>
                <ul>
                    <li>Harap tiba <strong>15 menit sebelum</strong> waktu peminjaman dimulai</li>
                    <li>Bawa <strong>kartu identitas</strong> (KTP/Kartu Mahasiswa) untuk verifikasi</li>
                    <li>Kode booking hanya berlaku untuk tanggal dan waktu yang telah ditentukan</li>
                    <li>Check-in maksimal 30 menit setelah waktu mulai, atau booking akan dibatalkan otomatis</li>
                </ul>
            </div>

            <div class="divider"></div>

            <p style="text-align: center; color: #555555; font-size: 15px;">
                <strong>Perlu melakukan perubahan?</strong>
            </p>

            <!-- Action Buttons -->
            <div class="button-container">
                <a href="https://yourwebsite.com/booking/LIB24A001" class="action-button">
                    Lihat Detail Booking
                </a>
                <!-- ini diarahin ke booking aja  -->
                <a href="https://yourwebsite.com/booking/cancel/LIB24A001" class="action-button secondary">
                    Batalkan Booking
                </a>
            </div>

            <p style="font-size: 14px; color: #666666; text-align: center;">
                Jika Anda memiliki pertanyaan, silakan hubungi layanan perpustakaan kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Tim Support Anda</strong></p>
            <p>Email: <a href="mailto:support@simaru.com">support@simaru.com</a></p>
            <p>WhatsApp: <a href="https://wa.me/6289523133302">+62 895-2313-3302</a></p>
            <p style="margin-top: 20px; color: #999999; font-size: 12px;">
                © 2024 SIMARU. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>