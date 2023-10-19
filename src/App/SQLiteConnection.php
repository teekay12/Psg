<?php
namespace Kareem\Ta\App;

class SQLiteConnection {

    private $pdo;

    private static $instance;

    private function __construct(){
        try {
            $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
        } catch(\PDOException $e) {

        }
    }

    public static function getInstance(): self {
        if (!isset(self::$instance)) {
            self::$instance = new SQLiteConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}