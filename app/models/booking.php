<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Booking extends Database{
    public static function create($data) 
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO bookings (user_id, room_id, start_time, duration, end_time , booking_code) VALUES (?, ?, ?, ?, ?, ?) RETURNING id");
        $i = 1;
        foreach($data as $key => $value) {
            if($key == "duration") {
                $q->bindValue($i, "$value minutes");
            }
            $q->bindValue($i, $value);
            $i++;
        }
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getByRoomId($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT b.start_time, b.start_time + (b.duration || ' minutes')::INTERVAL AS end_time, u.first_name || ' ' || u.last_name AS pic_name  FROM bookings AS b JOIN users AS u ON b.user_id = u.id
        WHERE b.room_id = ? ORDER BY start_time ASC");
        $q->bindValue(1, $id);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function checkSchedule($startTime, $duration)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM bookings WHERE start_time < TO_TIMESTAMP(:startTime, 'YYYY-MM-DD HH24:MI:SS') + (:duration || ' minutes')::INTERVAL AND end_time > TO_TIMESTAMP(:startTime2, 'YYYY-MM-DD HH24:MI:SS');");
        $q->bindValue(":startTime", $startTime);
        $q->bindValue(":duration", $duration);
        $q->bindValue(":startTime2", $startTime);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}