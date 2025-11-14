<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class BookingParticipant extends Database {
    public static function bulkInsert($data)
    {
        $insertQuery = [];
        $insertData = [];
        $conn = parent::getConnection();
        $sql = "INSERT INTO booking_participants (booking_id, user_id) VALUES";
        $n = 0;
        foreach($data as $item) {
            $insertQuery[] = "(:bookingId$n, :userId$n)";
            foreach($item as $key => $value) {
                if($key == "booking_id") $insertData["bookingId$n"] = $value;
                if($key == "id") $insertData["userId$n"] = $value;
            }
            $n++;
        }
        $sql .= implode(', ', $insertQuery);
        $q = $conn->prepare($sql);
        $q->execute($insertData);
    }

    public static function getParticipantsByBookingId($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT u.first_name || ' ' || u.last_name AS name FROM booking_participants AS bp JOIN users AS u ON bp.user_id = u.id WHERE bp.booking_id = :id");
        $q->bindValue(':id', $id);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}