<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['status'] === 'activated' ? 'Akun Diaktifkan' : 'Akun Dinonaktifkan' ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .email-container {
            max-width: 600px;
            margin: 100px auto;
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
            background-color: #E8F5F3;
            color: #1CBAA3;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .status-badge.deactivated {
            background-color: #FFE5ED;
            color: #FF0051;
        }

        .account-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #1CBAA3;
        }

        .account-details.deactivated {
            border-left: 4px solid #FF0051;
        }

        .account-details h3 {
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

        .reason-box {
            background-color: #fff5f5;
            border: 2px solid #FF0051;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .reason-box h3 {
            color: #FF0051;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .reason-box h3::before {
            margin-right: 8px;
            font-size: 20px;
        }

        .reason-box p {
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

            .account-details {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Pemberitahuan ! </h1>
        </div>

        <!-- Content -->
        <div class="content">
            <?php if ($data['status'] === 'activated'): ?>
                <p><?= $data['message'] ?></p>
            <?php else: ?>
                <p><?= $data['message'] ?></p>
            <?php endif; ?>

            <div class="divider"></div>

            <?php if ($data['status'] === 'activated'): ?>
                <p style="text-align: center; color: #555555; font-size: 15px;">
                    <strong>Selamat bergabung kembali!</strong><br>
                    Anda sekarang dapat melakukan booking ruangan dan menggunakan semua fitur kami.
                </p>

                <!-- Action Buttons -->
                <div class="button-container">
                    <a href="<?= URL ?>/user/booking/index" class="action-button">
                        Mulai Booking
                    </a>
                    <a href="<?= URL ?>/user/profile" class="action-button secondary">
                        Lihat Profil
                    </a>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: #555555; font-size: 15px;">
                    <strong>Butuh bantuan?</strong><br>
                    Jika Anda merasa ada kesalahan atau ingin mengaktifkan kembali akun Anda, silakan hubungi tim support kami.
                </p>

                <!-- Action Buttons -->
                <div class="button-container">
                    <a href="mailto:support@simaru.com" class="action-button">
                        Hubungi Support
                    </a>
                </div>
            <?php endif; ?>

            <p style="font-size: 14px; color: #666666;">
                Jika Anda memiliki pertanyaan lebih lanjut mengenai status akun Anda, jangan ragu untuk menghubungi tim support kami.
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