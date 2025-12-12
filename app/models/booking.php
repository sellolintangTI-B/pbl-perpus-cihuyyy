<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Booking extends Database
{

    public static function get($params, $page)
    {

        $where = [];
        $values = [];

        $conn = parent::getConnection();
        $stmt = "SELECT * FROM v_booking_details";

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'status':
                    $where[] = "$key = :$key";
                    $values[] = $value;
                    break;
                case 'start_time':
                    $where[] = "TO_CHAR($key, 'YYYY-MM-DD') ILIKE :$key";
                    $values[] = "%$value%";
                    break;
                default:
                    $where[] = "$key = :$key";
                    $values[] = $value;
                    break;
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= " WHERE " . $whereClauses;
        }

        $stmt .= " ORDER BY last_status_update DESC LIMIT 15 OFFSET 15 * $page";
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getForExport($params)
    {

        $where = [];
        $values = [];

        $conn = parent::getConnection();
        $stmt = "SELECT * FROM v_booking_details";

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'status':
                    $where[] = "$key = :$key";
                    $values[] = $value;
                    break;
                case 'start_time':
                    $where[] = "TO_CHAR($key, 'YYYY-MM-DD') ILIKE :$key";
                    $values[] = "%$value%";
                    break;
                default:
                    $where[] = "$key = :$key";
                    $values[] = $value;
                    break;
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= " WHERE " . $whereClauses;
        }
        $stmt .= " ORDER BY last_status_update DESC";
        
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
        $stmt = "SELECT COUNT(booking_id) FROM v_booking_details";

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'status':
                    $where[] = "$key = :$key";
                    $values[] = $value;
                    break;
                case 'start_time':
                    $where[] = "TO_CHAR($key, 'YYYY-MM-DD') ILIKE :$key";
                    $values[] = "%$value%";
                    break;
                default:
                    $where[] = "$key = :$key";
                    $values[] = $value;
                    break;
            }
        }

        if (!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= " WHERE " . $whereClauses;
        }

        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function create($data)
    {
        $conn = parent::getConnection();
        $fields = implode(',', array_keys($data));
        $placeholder = implode(',', array_fill(0, count($data), '?'));
        $q = $conn->prepare("INSERT INTO bookings ($fields) VALUES ($placeholder) RETURNING id");
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
        FROM bookings AS b LEFT JOIN users AS u ON b.user_id = u.id
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
        $q = $conn->prepare("SELECT * FROM v_booking_details WHERE booking_id = :id");
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
        $q = $conn->prepare("SELECT DISTINCT ON(b.id) b.*, u.email FROM bookings AS b JOIN booking_logs AS bl ON b.id = bl.booking_id 
            LEFT JOIN users AS u ON b.user_id = u.id
            WHERE TO_CHAR(b.start_time, 'YYYY-MM-DD') = :date AND bl.status 
            NOT IN ('checked_in', 'cancelled', 'finished')
            ORDER BY b.id, bl.created_at DESC");
        $q->bindValue(":date", $date);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getDataForLineChart()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT TO_CHAR(start_time, 'YYYY') AS year, TO_CHAR(start_time, 'MM') AS month, COUNT(id) FROM bookings 
        GROUP BY year, month ORDER BY year ASC, month ASC");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public static function getDataForRoomsPerYearChart()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT r.name as name, extract(year from b.start_time) as year, count (b.id) from bookings b join rooms r on (b.room_id=r.id) group by name, year order by name asc");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public static function getBookingCount()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("select count(*) from bookings");
        $q->execute();
        $data = $q->fetchColumn();
        return $data;
    }
}
