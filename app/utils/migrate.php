<?php
require_once("../core/Database.php");
$db = new Database;


try {
    $path = dirname(__DIR__) . '/migrations';
    $files = scandir($path);
    foreach($files as $file) {
        if($file !== '.' && $file !== '..') {
            $content = file_get_contents($path . "/" . $file);
            $db->conn->exec($content);
        }
    }
    echo "Migrate success";
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}