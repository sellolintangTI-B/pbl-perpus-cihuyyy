<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Booking extends Database
{

    public static function get()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT DISTINCT ON (b.id) b.id, u.first_name || ' ' || u.last_name AS pic_name, b.booking_code ,r.name, b.start_time, b.end_time, bl.status
        FROM bookings AS b JOIN users AS u ON b.user_id = u.id
        JOIN rooms AS r ON b.room_id = r.id
		JOIN booking_logs AS bl ON b.id = bl.booking_id ORDER BY b.id, bl.created_at DESC");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public static function create($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO bookings (user_id, room_id, start_time, duration, end_time , booking_code) VALUES (?, ?, ?, ?, ?, ?) RETURNING id");
        $i = 1;
        foreach ($data as $key => $value) {
            if ($key == "duration") {
                $q->bindValue($i, "$value minutes");
            }
            $q->bindValue($i, $value);
            $i++;
        }
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getByRoomId($id, $date)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT b.start_time, b.start_time + (b.duration || ' minutes')::INTERVAL AS end_time, u.first_name || ' ' || u.last_name AS pic_name 
        FROM bookings AS b JOIN users AS u ON b.user_id = u.id
        WHERE b.room_id = ? AND b.start_time::date = ? ORDER BY start_time ASC");
        $q->bindValue(1, $id);
        $q->bindValue(2, $date);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function checkSchedule($startTime, $duration, $roomId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM bookings WHERE start_time < TO_TIMESTAMP(:startTime, 'YYYY-MM-DD HH24:MI:SS') + (:duration || ' minutes')::INTERVAL 
        AND end_time > TO_TIMESTAMP(:startTime2, 'YYYY-MM-DD HH24:MI:SS') AND room_id = :roomId;");
        $q->bindValue(":startTime", $startTime);
        $q->bindValue(":duration", $duration);
        $q->bindValue(":startTime2", $startTime);
        $q->bindValue(":roomId", $roomId);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function checkUserActiveBooking($userId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT *
            FROM (
                SELECT DISTINCT ON (b.id)
                    b.id AS booking_id,
                    b.user_id AS pic_id,
                    b.booking_code AS booking_code,
                    r.name AS room_name,
                    r.floor,
                    u.first_name || ' ' || u.last_name AS pic,
                    b.start_time,
                    b.end_time,
                    r.room_img_url,
                    bl.status AS latest_status
                FROM bookings AS b
                JOIN booking_logs AS bl ON b.id = bl.booking_id
                JOIN booking_participants AS bp ON b.id = bp.booking_id
                JOIN rooms AS r ON b.room_id = r.id
                JOIN users AS u ON b.user_id = u.id
                WHERE bp.user_id = :userId 
                ORDER BY b.id, bl.created_at DESC
            ) AS latest
            WHERE NOT latest.latest_status IN ('cancelled', 'finished');
            ");
        $q->bindValue(':userId', $userId);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getUserBookingHistory($userId, $status = "")
    {
        $conn = parent::getConnection();
        $statusClause = "";
        if ($status == 'semua') $statusClause = "bl.status IN ('finished', 'cancelled')";
        if ($status == 'cancelled') $statusClause = "bl.status IN ('cancelled')";
        if ($status == 'finished') $statusClause = "bl.status IN ('finished')";

        $stmt = "SELECT DISTINCT ON (b.id) b.id, bl.status, r.name, b.start_time, b.end_time, b.booking_code, r.floor, f.created_at AS feedback_created_at
        FROM bookings AS b JOIN booking_logs AS bl ON b.id = bl.booking_id
        JOIN booking_participants AS bp ON b.id = bp.booking_id 
        LEFT JOIN feedbacks AS f ON b.id = f.booking_id AND f.user_id = :userId
        JOIN rooms AS r ON b.room_id = r.id WHERE bp.user_id = :userId
        AND $statusClause ORDER BY b.id, bl.created_at";
        $q = $conn->prepare($stmt);
        $q->bindValue(':userId', $userId);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getById($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT DISTINCT ON (b.id) b.id,b.booking_code, bl.status, u.first_name || ' ' || u.last_name AS pic,r.room_img_url, r.name, r.floor, r.requires_special_approval, b.start_time, b.end_time, b.user_id AS pic_id, bl.created_at, r.id as room_id
        FROM bookings AS b JOIN booking_logs AS bl ON b.id = bl.booking_id
        JOIN users AS u ON b.user_id = u.id
        JOIN booking_participants AS bp ON b.id = bp.booking_id 
        JOIN rooms AS r ON b.room_id = r.id WHERE b.id = :id ORDER BY b.id, bl.created_at DESC");
        $q->bindValue(':id', $id);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getActiveBookingByBookingCode($bookingCode)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM 
            (SELECT DISTINCT ON (b.id) b.id, b.booking_code, bl.status, b.start_time, b.end_time, r.name, r.floor FROM bookings AS b JOIN booking_logs AS bl ON b.id = bl.booking_id
            JOIN rooms AS r ON b.room_id = r.id
            ORDER BY b.id, bl.created_at DESC) 
            AS active WHERE active.booking_code = :bookingCode");
        $q->bindValue(":bookingCode", $bookingCode);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function edit($id, $data)
    {
        $values = [];
        $field = [];
        $conn = parent::getConnection();
        $stmt = "UPDATE bookings SET ";

        foreach ($data as $key => $value) {
            $field[] = "$key = :$key";
            $values[] = $value;
        }

        $implodedField = implode(', ', $field);
        $stmt .= "$implodedField WHERE id = '$id' RETURNING id";
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $id = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getAllBookingsYear()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT DISTINCT ON(TO_CHAR(start_time, 'YYYY')) TO_CHAR(start_time, 'YYYY') AS year FROM bookings");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getBookingForCancelByDate($date)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT DISTINCT ON(b.id) * FROM bookings AS b JOIN booking_logs AS bl ON b.id = bl.booking_id 
            WHERE TO_CHAR(b.start_time, 'YYYY-MM-DD') = :date AND bl.status NOT IN ('checked_in', 'cancelled', 'finished')
            ORDER BY b.id, bl.created_at DESC
            ");
        $q->bindValue(":date", $date);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}
