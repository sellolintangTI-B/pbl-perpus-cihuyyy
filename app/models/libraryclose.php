<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class LibraryClose extends Database
{
    public static function get($page = 1)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT u.first_name || ' ' || u.last_name AS name, l.* FROM library_close_logs l JOIN users AS u ON l.created_by = u.id LIMIT 15 OFFSET 15 * $page");
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

    public static function getByDate($date)
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM library_close_logs WHERE close_date = :date");
        $q->bindValue(':date', $date);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function count()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT COUNT(id) FROM library_close_logs");
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data;
    }


    
}