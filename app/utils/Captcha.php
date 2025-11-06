<?php

namespace App\Utils;

class Captcha {
    public static function Generate()
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

        $code = [];

        $alphaLen = strlen($alphabet) - 2;

        for ($i=0; $i < 5 ; $i++) { 
            $n = rand(0, $alphaLen);
            $code[$i] = $alphabet[$n];
        }

        $code = implode($code);
        $_SESSION['captcha'] = $code;

        $width = 200;
        $height = 50;
        $image = imagecreatetruecolor($width, $height);
        
        $bg_color = imagecolorallocate($image, 11, 63, 120);
        $text_color = imagecolorallocate($image, 255, 255, 255);
        
        imagefill($image, 0, 0, $bg_color);
        
        imagestring($image, 5, 50, 15, $code, $text_color);
        
        header('Content-Type: image/jpeg');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        imagejpeg($image);
        imagedestroy($image);
        exit;
    }
}
