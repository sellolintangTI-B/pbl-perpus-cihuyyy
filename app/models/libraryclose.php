<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class LibraryClose extends Database
{
    public static function get()
    {
        $conn = parent::getConnection();
        $q = $conn->prepare("SELECT * FROM library_close_logs");
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function store()
    {
        $conn = parent::getConnection();
        // $q = $conn->prepare("INSERT INTO library_close_logs (")
    }

    
}