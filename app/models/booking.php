<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Booking extends Database{
    public static function create($data) 
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("INSERT INTO bookings (user_id, room_id, duration, start_time) VALUES (?, ?, ?, ? ) RETURNING id");
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
}