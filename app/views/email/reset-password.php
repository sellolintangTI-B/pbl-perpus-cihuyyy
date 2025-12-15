<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI',
                Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            background: linear-gradient(135deg, #0b3f78 0%, #1da0b4 100%);
            padding: 40px 20px;
            text-align: center;
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
            color: #0b3f78;
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

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .reset-button {
            display: inline-block;
            padding: 16px 40px;
            background-color: #1cbaa3;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px rgba(28, 186, 163, 0.3);
        }

        .reset-button:hover {
            background-color: #1da0b4;
        }

        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #1cbaa3;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #555555;
        }

        .link-text {
            word-break: break-all;
            color: #1da0b4;
            font-size: 14px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 15px 0;
        }

        .warning {
            color: #ff0051;
            font-size: 14px;
            font-weight: 600;
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
            color: #1da0b4;
            text-decoration: none;
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

            .reset-button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Reset Password</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Halo, Cahyadi!</h2>

            <p>
                Kami menerima permintaan untuk mereset password akun Anda.
                Jika Anda yang melakukan permintaan ini, silakan klik tombol
                di bawah untuk membuat password baru.
            </p>

            <div class="button-container">
                <a
                    href="#"
                    class="reset-button">
                    Reset Password
                </a>
            </div>

            <div class="info-box">
                <p>
                    <strong>Link ini akan kadaluarsa dalam 1 jam</strong>
                    demi keamanan akun Anda.
                </p>
            </div>

            <p>
                Jika tombol di atas tidak berfungsi, copy dan paste link dibawah ini ke browser anda
            </p>

            <div class="link-text">
                https://yourwebsite.com/reset-password?token=RESET_TOKEN_HERE
            </div>

            <p class="warning">
                ⚠️ Jika Anda tidak meminta reset password, abaikan email
                ini. Password Anda tidak akan berubah.
            </p>

            <p>
                Untuk keamanan akun Anda, jangan bagikan link ini kepada
                siapapun.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Tim Support Anda</strong></p>
            <p>
                Jika Anda memiliki pertanyaan, hubungi kami di
                <a href="mailto:support@simaru.com">support@simaru.com</a>
            </p>
            <p style="margin-top: 20px; color: #999999; font-size: 12px">
                © 2024 SIMARU. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>