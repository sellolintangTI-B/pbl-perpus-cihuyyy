<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Feedback extends Database
{
    public static function create($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO feedbacks (user_id, booking_id, rating, feedback) VALUES (:userId, :bookingId, :rating, :feedback)");
        $q->bindValue(':userId', $data['user_id']);
        $q->bindValue(':bookingId', $data['booking_id']);
        $q->bindValue(':rating', $data['rating']);
        $q->bindValue(':feedback', $data['feedback']);
        $q->execute();
        if ($q) return true;
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

    public static function get($params = [], $page = 1)
    {
        $where = [];
        $values = [];
        $conn = parent::getConnection();
        $stmt = "SELECT u.first_name || ' ' || u.last_name AS name, r.name AS room_name, r.floor,
        b.start_time, f.feedback, f.rating, b.booking_code
        FROM feedbacks AS f JOIN bookings AS b ON f.booking_id = b.id
        JOIN rooms AS r ON b.room_id = r.id
        JOIN users AS u ON f.user_id = u.id";

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if ($key === 'ruangan' && !empty($value)) {
                    $where[] = "r.id = :roomId";
                    $values[] = $value; 
                }

                if ($key === 'date' && !empty($value)) {
                    $where[] = "TO_CHAR(b.start_time, 'YYYY-MM') = :date";
                    $values[] = $value; 
                }
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= " WHERE $whereClauses ";
        }
        
        $stmt .= " LIMIT 4 OFFSET 4 * $page";
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getForExport($params = [])
    {
        $where = [];
        $values = [];
        $conn = parent::getConnection();
        $stmt = "SELECT u.first_name || ' ' || u.last_name AS name, r.name AS room_name, r.floor,
        b.start_time, f.feedback, f.rating, b.booking_code
        FROM feedbacks AS f JOIN bookings AS b ON f.booking_id = b.id
        JOIN rooms AS r ON b.room_id = r.id
        JOIN users AS u ON f.user_id = u.id";

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if ($key === 'ruangan' && !empty($value)) {
                    $where[] = "r.id = :roomId";
                    $values[] = $value; 
                }

                if ($key === 'date' && !empty($value)) {
                    $where[] = "TO_CHAR(b.start_time, 'YYYY-MM') = :date";
                    $values[] = $value; 
                }
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= " WHERE $whereClauses ";
        }
        
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function count($params)
    {
        $where = [];
        $values = [];
        $conn = parent::getConnection();
        $stmt = "SELECT COUNT(f.id) FROM feedbacks as f
        JOIN bookings AS b ON b.id = f.booking_id JOIN rooms AS r ON b.room_id = r.id";

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if ($key === 'ruangan' && !empty($value)) {
                    $where[] = "r.id = :roomId";
                    $values[] = $value; 
                }

                if ($key === 'date' && !empty($value)) {
                    $where[] = "TO_CHAR(b.start_time, 'YYYY-MM') = :date";
                    $values[] = $value; 
                }
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= " WHERE $whereClauses ";
        }
        
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }
}
