<?php
require_once('database\config.php');
class Database
{
    private static $instance;
    private $pdo;
    private function __construct()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ошибка подключения к базе данных: " . $e->getMessage();
            exit();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }
}