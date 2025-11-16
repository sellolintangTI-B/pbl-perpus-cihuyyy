<?php 

namespace App\Models;

use App\Core\Database;
use PDO;

class Suspension extends Database
{
    public static function checkSupensionsByUserId($userId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM suspensions WHERE user_id = ?");
        $q->bindValue(1, $userId);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function create($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO suspensions (user_id, suspend_count) VALUES (?, ?) RETURNING suspend_count");
        $q->bindValue(1, $data['user_id']);
        $q->bindValue(2, $data['point']);
        $q->execute();
        if($q) {
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }

    public static function update($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("UPDATE suspensions SET suspend_count = ? WHERE id = ? RETURNING suspend_count");
        $q->bindValue(1, $data['point']);
        $q->bindValue(2, $data['id']);
        $q->execute();
        if($q) {
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }
}