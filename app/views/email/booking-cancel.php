<?php
use Carbon\Carbon;
$startTime = Carbon::parse($data['booking']->start_time);
$endTime = Carbon::parse($data['booking']->end_time);
$hours = $startTime->diff($endTime);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Dibatalkan</title>
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
            font-size: 48px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
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
            background-color: #FFE5ED;
            color: #FF0051;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 25px;
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
            font-weight: 600;
        }

        .detail-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            flex: 0 0 140px;
            font-weight: 600;
            color: #555555;
            font-size: 14px;
        }

        .detail-value {
            flex: 1;
            color: #333333;
            font-size: 14px;
        }

        .cancellation-reason {
            background-color: #fff5f5;
            border: 2px solid #FF0051;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .cancellation-reason h3 {
            color: #FF0051;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .cancellation-reason h3::before {
            margin-right: 8px;
            font-size: 20px;
        }

        .cancellation-reason p {
            margin: 0;
            color: #333333;
            font-size: 15px;
            line-height: 1.6;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .action-button {
            display: inline-block;
            padding: 16px 40px;
            background-color: #1CBAA3;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px rgba(28, 186, 163, 0.3);
            margin: 0 10px 10px 0;
        }

        .action-button:hover {
            background-color: #1DA0B4;
        }

        .action-button.secondary {
            background-color: #0B3F78;
            box-shadow: 0 4px 12px rgba(11, 63, 120, 0.3);
        }

        .action-button.secondary:hover {
            background-color: #1DA0B4;
        }

        .info-box {
            background-color: #e8f5f3;
            border-left: 4px solid #1CBAA3;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #555555;
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

            .content h2 {
                font-size: 20px;
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
            <h1>Peminjaman Dibatalkan</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Halo, <?= $data['name'] ?>!</h2>

            <div class="status-badge">PEMINJAMAN DIBATALKAN</div>

            <p>Kami informasikan bahwa peminjaman Anda telah <strong>dibatalkan</strong>. Berikut adalah detail booking yang dibatalkan:</p>

            <!-- Booking Details -->
            <!-- Booking Details -->
            <div class="booking-details">
                <h3>Detail Peminjaman Ruangan</h3>
                <div class="detail-row">
                    <div class="detail-label">Kode Booking:</div>
                    <div class="detail-value highlight"><?= $data['booking']->booking_code ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nama Ruangan:</div>
                    <div class="detail-value"><?= $data['booking']->room_name ?> - Lt. <?= $data['booking']->floor ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal:</div>
                    <div class="detail-value"><?= Carbon::parse($data['booking']->start_time)->translatedFormat('D, d M Y') ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Waktu:</div>
                    <div class="detail-value"><?= $startTime->format('H:i') ?> - <?= $endTime->format('H:i') ?> WIB</div>
                </div>
            </div>

            <!-- Cancellation Reason -->
            <div class="cancellation-reason">
                <h3>Alasan Pembatalan</h3>
                <p><?= $data['reason'] ?></p>
            </div>
            <div class="divider"></div>

            <p style="text-align: center; color: #555555; font-size: 15px;">
                <strong>Masih butuh layanan kami?</strong><br>
                Anda bisa membuat booking baru dengan waktu yang berbeda.
            </p>

            <!-- Action Buttons -->
            <div class="button-container">
                <a href="<?= URL ?>/user/booking/index" class="action-button">
                    Booking Lagi
                </a>
            </div>

            <p style="font-size: 14px; color: #666666;">
                Jika Anda memiliki pertanyaan lebih lanjut mengenai pembatalan ini, jangan ragu untuk menghubungi tim support kami.
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