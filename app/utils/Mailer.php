<?php
namespace App\Utils;

use app\error\CustomException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer { 

    private static function getConfiguredMailer() {
        $mail = new PHPMailer(true);
        
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;  
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
        $mail->Port = $_ENV['SMTP_PORT'];  
        // $mail->SMTPDebug = 4;
        
        $mail->setFrom('admin.perpustakaan@pnj.ac.id', 'Sistem Akademik');
        
        return $mail;
    }

    private static function renderTemplate($path, $data = []) 
    {
        $path = dirname(__DIR__) . '/views/email/' . $path;
        extract($data);

        ob_start();

        require $path;

        return ob_get_clean();
    }

    public static function send($to, $subject, $path, $data) {
        try {
            $mail = self::getConfiguredMailer();
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = self::renderTemplate($path, $data);
            // $mail->AltBody = strip_tags($data);

            return $mail->send();
        } catch (CustomException $e) {
            throw new CustomException("Static Mailer Error: " . $e->getErrorMessages());
        }
    }
}

new Mailer;