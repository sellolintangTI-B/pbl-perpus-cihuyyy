<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class BookingLog extends Database
{

    public function index()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM booking_logs");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public static function getDetail($bookingId, $status)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM booking_logs where booking_id = ? AND status = ?");
        $q->bindValue(1, $bookingId);
        $q->bindValue(2, $status);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public static function getFinishedDetailByBookingId($bookingId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT created_at, status FROM booking_logs where booking_id = ? AND (status = 'finished' OR status = 'checked_in')");
        $q->bindValue(1, $bookingId);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function getCancelDetailByBookingId($bookingId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT bl.created_at, bl.reason, u.first_name || ' ' || u.last_name AS cancel_actor FROM booking_logs AS bl JOIN users AS u ON(bl.cancelled_by = u.id)  where booking_id = ? AND status = 'cancelled'");
        $q->bindValue(1, $bookingId);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function create($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO booking_logs (booking_id) VALUES (?)");
        $q->bindValue(1, $data);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function cancel($data)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO booking_logs (status, cancelled_by, reason, booking_id) VALUES ('cancelled', ?, ?, ?)");
        $q->bindValue(1, $data['user_id']);
        $q->bindValue(2, $data['reason']);
        $q->bindValue(3, $data['booking_id']);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function checkIn($bookingId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO booking_logs (status, booking_id) VALUES ('checked_in', ?)");
        $q->bindValue(1, $bookingId);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function checkOut($bookingId)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO booking_logs (status, booking_id) VALUES ('finished', ?)");
        $q->bindValue(1, $bookingId);
        $q->execute();
        if ($q) return true;
        return false;
    }

    public static function cancelAllBookingByDate($bookingId, $reason, $actor)
    {
        $insertQuery = [];
        $insertData = [];
        $conn = parent::getConnection();
        $n = 0;
        foreach ($bookingId as $item) {
            $insertQuery[] = "(:status$n, :cancelled_by$n, :reason$n, :bookingId$n)";
            $insertData["status$n"] = 'cancelled';
            $insertData["cancelled_by$n"] = $actor;
            $insertData["reason$n"] = $reason;
            $insertData["bookingId$n"] = $item;
            $n++;
        }
        $query = implode(', ', $insertQuery);
        $q = $conn->prepare("INSERT INTO booking_logs (status, cancelled_by, reason, booking_id) VALUES $query");
        $q->execute($insertData);
        if ($q) return true;
        return false;
    }

    public static function bulkCancel($bookingIds, $reason)
    {
        $values = [];
        $placeholder = [];
        $conn = parent::getConnection();
        $stmt = "INSERT INTO booking_logs (booking_id, reason, status) VALUES ";

        $counter = 1;
        foreach($bookingIds as $value) {
            $placeholder[] = "(:bookingId$counter, :reason$counter, 'cancelled')";
            $values["bookingId$counter"] = $value;
            $values["reason$counter"] = $reason;
            $counter++;
        }

        $stmt .= implode(',', $placeholder);

        $q = $conn->prepare($stmt);
        $q->execute($values);
        if ($q) return true;
        return false;
    }

    public static function getLateBookings()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT b.id, b.booking_code, b.start_time, u.email, b.user_id
            FROM bookings b JOIN users AS u ON b.user_id = u.id WHERE b.start_time <= ((NOW() AT TIME ZONE 'Asia/Jakarta') - INTERVAL '10 minutes')
            AND (SELECT status FROM booking_logs bl WHERE bl.booking_id = b.id ORDER BY bl.created_at DESC 
            LIMIT 1) = 'created';");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

}
