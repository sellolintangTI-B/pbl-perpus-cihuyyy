<?php

namespace App\Models;

use App\Core\Database;
use Pdo;

class Room extends Database
{

    public static function get($params = [])
    {
        $paramValues = [];
        $conn = parent::getConnection();
        $stmt = " SELECT * FROM rooms WHERE is_deleted = FALSE ";
        if (!empty($params)) {
            $stmt .= " AND id NOT IN ( SELECT room_id FROM bookings WHERE 
                start_time < TO_TIMESTAMP(:startTime, 'YYYY-MM-DD HH24:MI:SS') + (:duration || ' minutes')::INTERVAL
                AND end_time > TO_TIMESTAMP(:startTime, 'YYYY-MM-DD HH24:MI:SS'))";
            $paramValues['startTime'] = $params['startTime'];
            $paramValues['duration']  = $params['duration'];
            if (!empty($params['room'])) {
                $stmt .= " AND name ILIKE :roomName";
                $paramValues['roomName'] = "%{$params['room']}%";
            }
        }

        $q = $conn->prepare($stmt);
        $q->execute($paramValues);

        return $q->fetchAll(PDO::FETCH_OBJ);
    }

    public static function create($data)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("INSERT INTO rooms (name, floor, min_capacity, max_capacity, description, requires_special_approval, room_img_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $x = 1;
        foreach ($data as $key => $value) {
            $stmt->bindValue($x++, $value);
        }
        if ($stmt->execute()) return true;
        return false;
    }

    public static function getById($id)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function delete($id)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->bindValue(1, $id);
        if ($stmt->execute()) return true;
        return false;
    }

    public static function update($id, $data)
    {
        $conn = parent::getConnection();
        $query = "UPDATE rooms SET name = ?, floor = ?, min_capacity = ?, max_capacity = ?, description = ?, requires_special_approval = ?, is_operational = ? WHERE id = ?";
        if (isset($data['image'])) $query = "UPDATE rooms SET name = ?, floor = ?, min_capacity = ?, max_capacity = ?, description = ?, requires_special_approval = ?, is_operational = ?, room_img_url = ? WHERE id = ?";

        $stmt = $conn->prepare($query);
        $x = 1;
        foreach ($data as $key => $value) {
            $stmt->bindValue($x++, $value);
        }
        $stmt->bindValue($x, $id);
        if ($stmt->execute()) return true;
        return false;
    }

    public static function softDelete($id)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("UPDATE rooms SET is_deleted = true WHERE id = ?");
        $stmt->bindValue(1, $id);
        if ($stmt->execute()) return true;
        return false;
    }
}
