<?php
namespace app\models;
use App\Core\Database;
use Pdo;

class Room extends Database {

    public function get()
    {
        $stmt = $this->conn->prepare("SELECT * FROM rooms");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO rooms (name, floor, min_capacity, max_capacity, requires_special_approval, room_img_url) VALUES (?, ?, ?, ?, ?, ?)");
        $x = 1;
        foreach($data as $key => $value) {
            $stmt->bindValue($x++, $value);
        }
        if($stmt->execute()) return true;
        return false;
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->bindValue(1, $id);
        if($stmt->execute()) return true;
        return false;
    } 

    public function update($id, $data)
    {
        $query = "UPDATE rooms SET name = ?, floor = ?, min_capacity = ?, max_capacity = ?, requires_special_approval = ? WHERE id = ?";
        if(isset($data['image'])) $query = "UPDATE rooms SET name = ?, floor = ?, min_capacity = ?, max_capacity = ?, requires_special_approval = ?, room_img_url = ? WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $x = 1;
        foreach($data as $key => $value) {
            $stmt->bindValue($x++, $value);
        }
        $stmt->bindValue($x, $id);
        if($stmt->execute()) return true;
        return false;
    }
}