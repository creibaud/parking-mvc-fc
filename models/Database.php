<?php
    class Database {
        private static ?Database $instance = null;
        private PDO $conn;

        private function __construct() {
            $env = parse_ini_file(".env");
            $host = $env['HOST'];
            $db = $env['DB'];
            $user = $env['USER'];
            $pass = $env['PASS'];

            try {
                $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: ". $e->getMessage());
            }
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function save(string $sql, ?array $params = null) {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
    }
?>