<?php
namespace app\models;
use App\Core\Database;
use Pdo;

class Room extends Database {

    public static function get()
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("SELECT * FROM rooms WHERE is_deleted = FALSE");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function create($data)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("INSERT INTO rooms (name, floor, min_capacity, max_capacity, description, requires_special_approval, room_img_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $x = 1;
        foreach($data as $key => $value) {
            $stmt->bindValue($x++, $value);
        }
        if($stmt->execute()) return true;
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
        if($stmt->execute()) return true;
        return false;
    } 

    public static function update($id, $data)
    {
        $conn = parent::getConnection();
        $query = "UPDATE rooms SET name = ?, floor = ?, min_capacity = ?, max_capacity = ?, description = ?, requires_special_approval = ?, is_operational = ? WHERE id = ?";
        if(isset($data['image'])) $query = "UPDATE rooms SET name = ?, floor = ?, min_capacity = ?, max_capacity = ?, description = ?, requires_special_approval = ?, is_operational = ?, room_img_url = ? WHERE id = ?";
        
        $stmt = $conn->prepare($query);
        $x = 1;
        foreach($data as $key => $value) {
            $stmt->bindValue($x++, $value);
        }
        $stmt->bindValue($x, $id);
        if($stmt->execute()) return true;
        return false;
    }

    public static function softDelete($id)
    {
        $conn = parent::getConnection();
        $stmt = $conn->prepare("UPDATE rooms SET is_deleted = true WHERE id = ?");
        $stmt->bindValue(1, $id);
        if($stmt->execute()) return true;
        return false;
    }
}