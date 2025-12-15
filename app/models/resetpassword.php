<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class ResetPassword extends Database {

    public static function store($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO reset_password (email, token) VALUES (? , ?)");
        $q->bindValue(1, $data['email']);
        $q->bindValue(2, $data['token']);
        $q->execute();
        if($q) return true;
        return false;
    }
            
    public static function getToken($token)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT  * FROM reset_password WHERE token = ?");
        $q->bindValue(1, $token);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function updateToken($token)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE reset_password SET is_used = TRUE WHERE token = :token");
        $q->bindValue(':token', $token);
        $q->execute();
        if($q) return true;
        return false;
    }
}