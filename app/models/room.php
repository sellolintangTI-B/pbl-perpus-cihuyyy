<?php

namespace App\Models;

use App\Core\Database;
use Pdo;

class Room extends Database
{

    public static function getALl($params = [], $page = 0) 
    {
        $where = [];
        $values = [];
        $conn = parent::getConnection();
        $stmt = "SELECT * FROM rooms WHERE is_deleted = false";
        if(!empty($params)) {
            foreach($params as $key => $value) {
                if($key === "name") {
                    $where[] = "name ILIKE :$key";
                    $values[] = "%$value%";
                } else {
                    $where[] = "$key = :$key";
                    $values[] = $value;
                }
            }
        }

        if(!empty($where)) {
            $whereClauses = implode(' AND ', $where);
            $stmt .= $whereClauses;
        }

        $stmt .= " LIMIT 15 OFFSET 15 * $page";
        $q = $conn->prepare($stmt);
        $q->execute($values);
        $data = $q->fetchALl(PDO::FETCH_OBJ);
        return $data;
    }

    public static function count()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT COUNT(id) FROM rooms");
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function get($params = [])
    {
        $paramValues = [];
        $conn = parent::getConnection();
        $stmt = " SELECT * FROM rooms WHERE is_deleted = FALSE ";
        if (!empty($params)) {

            if(!empty($params['start_time']) && !empty($params['duration'])) {
                $stmt .= " AND id NOT IN (SELECT room_id FROM bookings WHERE 
                    start_time < TO_TIMESTAMP(:start_time, 'YYYY-MM-DD HH24:MI:SS') + (:duration || ' minutes')::INTERVAL
                    AND end_time > TO_TIMESTAMP(:start_time, 'YYYY-MM-DD HH24:MI:SS'))";
                $paramValues['start_time'] = $params['start_time'];
                $paramValues['duration']  = $params['duration'];
            }
            
            if (!empty($params['room'])) {
                $stmt .= " AND name ILIKE :roomName";
                $paramValues['roomName'] = "%{$params['room']}%";
            }
        }

        $q = $conn->prepare($stmt);
        $q->execute($paramValues);
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
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
        $fields = [];
        $values = [];
        $conn = parent::getConnection();
        foreach($data as $key => $value) {
            $fields[] = "$key = :$key";
            $values[] = $value;
        }
        $fields = implode(', ', $fields);
        $values[] = $id;
        $query = "UPDATE rooms SET $fields WHERE id = :id";
        $stmt = $conn->prepare($query);
        if ($stmt->execute($values)) return true;
        return false;
    }

    public static function softDelete($id, $adminId)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("SELECT * FROM soft_delete_room_and_cancel_bookings(:roomId, :adminId)");
        $stmt->bindValue(':roomId', $id);
        $stmt->bindValue(':adminId', $adminId);
        if ($stmt->execute()) {
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }
        return false;
    }
}
