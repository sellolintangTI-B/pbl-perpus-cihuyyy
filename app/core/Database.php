<?php
namespace App\Core;
use Pdo;
use PDOException;

class Database {
    protected static $conn;

    public function __construct()
    {
        try {
            $DB_HOST = $_ENV['DB_HOST'];
            $DB_USERNAME = $_ENV['DB_USERNAME'];
            $DB_PASSWORD = $_ENV['DB_PASSWORD'];
            $DB_DBNAME = $_ENV['DB_DBNAME'];
            $DB_PORT = $_ENV['DB_PORT'];
            if(!self::$conn) {
                self::$conn =  new PDO("pgsql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DBNAME", $DB_USERNAME, $DB_PASSWORD );        
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
    }

    public static function getConnection()
    {
        if(!self::$conn) {
            new self();
        }
        return self::$conn;
    }

}