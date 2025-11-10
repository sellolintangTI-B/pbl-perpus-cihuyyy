<?php

namespace App\Utils;

use App\Core\Database;
use PDO;

class DB extends Database
{
    public static function get($query, $params = [])
    {
        $conn = parent::getConnection();
        $q = $conn->prepare($query);
        if (!empty($params)) {
            foreach (array_values($params) as $index => $value) {
                $q->bindValue($index + 1, $value);
            }
        }
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}
