<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class LibraryClose extends Database
{
    public static function get()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT u.first_name || ' ' || u.last_name AS name, l.* FROM library_close_logs l JOIN users AS u ON l.created_by = u.id");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function store($data)
    {
        $params = [];
        $values = [];
        $field = [];
        $conn = parent::getConnection();
        foreach($data as $key => $value) {
            $field[] = $key;
            $params[] = ":$key";
            $values[] = $value;
        }
        $implodeField = implode(', ', $field);
        $implodeParams = implode(', ', $params);

        $stmt = "INSERT INTO library_close_logs ($implodeField) VALUES ($implodeParams)";
        $q = $conn->prepare($stmt);
        $q->execute($values);
        if($q) return true;
        return false;
    }

    public static function delete($id)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("DELETE FROM library_close_logs WHERE id = ?");
        $q->bindValue(1, $id);
        $q->execute();
        if($q) return true;
        return false;
    }

    
}