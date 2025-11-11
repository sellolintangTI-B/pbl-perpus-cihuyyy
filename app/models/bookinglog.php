<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class BookingLog extends Database {

    public function index()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM booking_logs");
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
        if($q) return true;
        return false;
    }

}