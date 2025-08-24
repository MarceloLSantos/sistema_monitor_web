<?php
// ### config/db.php
class DB {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = getenv('HOST') ?: 'localhost';
        $db = getenv('DATABASE') ?: 'sistema_monitor';
        $user = getenv('DB_USER') ?: 'sistema_monitor';
        $pass = getenv('PASSWORD') ?: 'Sistema@monitor';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance->pdo;
    }
}
?>