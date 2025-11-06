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

        return $code;

    }
}
