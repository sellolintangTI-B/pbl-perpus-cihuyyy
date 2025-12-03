<?php
namespace App\Utils;

use app\error\CustomException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer { 
    
    private static function getConfiguredMailer() {
        $mail = new PHPMailer(true);
        
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST']; 
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USERNAME'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['SMTP_PORT'];
        
        $mail->setFrom('admin.perpustakaan@pnj.ac.id', 'Sistem Akademik');
        
        return $mail;
    }

    public static function send($to, $subject, $body) {
        try {
            $mail = self::getConfiguredMailer();

            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            return $mail->send();
        } catch (CustomException $e) {
            throw new CustomException("Static Mailer Error: " . $e->getErrorMessages());
        }
    }
}