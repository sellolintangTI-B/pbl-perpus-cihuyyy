<?php
class Database {
    public $conn;
    private $DB_HOST = "localhost";
    private $DB_USERNAME = "postgres";
    private $DB_PASSWORD = "farrelpostgres";
    private $DB_DBNAME = "pbl";
    private $DB_PORT = "5431";

    public function __construct()
    {
        try {
            $this->conn =  new PDO("pgsql:host=$this->DB_HOST;port=$this->DB_PORT;dbname=$this->DB_DBNAME", $this->DB_USERNAME, $this->DB_PASSWORD );        
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
    }
}