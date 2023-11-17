<?php
    require_once("/var/www/parking-crud-fc-mvc/models/Database.php");

    class Parking {
        private static ?Parking $instance = null;
        private Database $db;

        private function __construct() {
            $this->db = Database::getInstance();
            $this->createTable();
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function createTable() {
            $sql = "CREATE TABLE IF NOT EXISTS parkings (
                        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        name VARCHAR(255) NOT NULL,
                        country VARCHAR(255) NOT NULL,
                        city VARCHAR(255) NOT NULL,
                        street VARCHAR(255) NOT NULL,
                        zipcode INT NOT NULL,
                        capacity INT NOT NULL
                    );";
            $this->db->save($sql);
        }

        public function createParking(string $name, string $country, string $city, string $street, int $zipcode, int $capacity) {
            $sql = "INSERT INTO parkings (name, country, city, street, zipcode, capacity) VALUES (?,?,?,?,?,?);";
            $params = [$name, $country, $city, $street, $zipcode, $capacity];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function getLastIndex() {
            $sql = "SELECT * FROM parkings ORDER BY id DESC LIMIT 1;";
            $stmt = $this->db->save($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getAllParking() {
            $sql = "SELECT * FROM parkings;";
            $stmt = $this->db->save($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getParkingById(int $id) {
            $sql = "SELECT * FROM parkings WHERE id =?;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateParking(int $id, string $name, string $country, string $city, string $street, int $zipcode, int $capacity) {
            $sql = "UPDATE parkings SET name =?, country =?, city =?, street =?, zipcode =?, capacity=? WHERE id =?;";
            $params = [$name, $country, $city, $street, $zipcode, $capacity, $id];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function deleteParking(int $id) {
            $sql = "DELETE FROM parkings WHERE id =?;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }
    }
?>