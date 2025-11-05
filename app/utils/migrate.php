<?php

namespace App\Utils;
use App\Core\Database;
use PDOException;

class Migrate
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        try {
            $path = dirname(__DIR__) . '../../migrations';
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $content = file_get_contents($path . "/" . $file);
                    $this->db->getConnection()->exec($content);
                }
            }
            echo "Migrate success";
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
    }
}
