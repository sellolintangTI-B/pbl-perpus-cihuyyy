<?php

namespace App\Models;
use App\Core\Database;
use PDO;

class Feedback extends Database {
    public static function create($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO feedbacks (user_id, booking_id, rating, feedback) VALUES (:userId, :bookingId, :rating, :feedback)");
        $q->bindValue(':userId', $data['user_id']);
        $q->bindValue(':bookingId', $data['booking_id']);
        $q->bindValue(':rating', $data['rating']);
        $q->bindValue(':feedback', $data['feedback']);
        $q->execute();
        if($q) return true;
        return false;
    }

    public static function getByBookingIdAndUserId($id, $userId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM feedbacks WHERE booking_id = :bookingId AND user_id = :userId");
        $q->bindValue(":bookingId", $id);
        $q->bindValue(":userId", $userId);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function get()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM feedbacks");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}