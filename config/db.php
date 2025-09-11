<?php
// ### config/db.php
class DB {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = getenv('HOST') ?: 'localhost';
        // Se for https usar database e usuario 'cervej01_sistema_monitor'
        if (isset($_SERVER['HTTPS'])) {
            $db = 'cervej01_sistema_monitor';
            $user = 'cervej01_sistema_monitor';
            $pass = getenv('PASSWORD') ?: 'Sistema@monitor';
        } else {
            $db = 'sistema_monitor';
            $user = 'root';
            $pass = getenv('PASSWORD') ?: '';
        }

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