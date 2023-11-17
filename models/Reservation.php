<?php
    require_once("/var/www/parking-crud-fc-mvc/models/Database.php");

    class Reservation {
        private static ?Reservation $instance = null;
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
            $sql = "CREATE TABLE IF NOT EXISTS reservations (
                        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        place_id INT NOT NULL,
                        license_plate VARCHAR(255) NOT NULL,
                        start_time TIME NOT NULL,
                        end_time TIME NOT NULL,
                        FOREIGN KEY (place_id) REFERENCES places(id)
                    );";
            $this->db->save($sql);
        }

        public function createReservation(int $placeID, string $licensePlate, string $startTime, string $endTime) {
            $sql = "INSERT INTO reservations (place_id, license_plate, start_time, end_time) 
                    VALUES (?,?,?,?);";
            $params = [$placeID, $licensePlate, $startTime, $endTime];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function getAllReservation(int $placeID) {
            $sql = "SELECT * FROM reservations WHERE place_id =?;";
            $params = [$placeID];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getReservationById(int $id) {
            $sql = "SELECT * FROM reservations WHERE id =?;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateReservation(int $id, string $licensePlate, string $startTime, string $endTime) {
            $sql = "UPDATE reservations SET license_plate =?, start_time =?, end_time =? WHERE id =?;";
            $params = [$licensePlate, $startTime, $endTime, $id];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function deleteReservation(int $id) {
            $sql = "DELETE FROM reservations WHERE id =?;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function deleteAllReservation($placeID) {
            $sql = "DELETE FROM reservations WHERE place_id =?;";
            $params = [$placeID];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function countReservations($id) {
            $sql = "SELECT COUNT(*) FROM reservations WHERE place_id =?;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetchColumn();
        }

        public function getLastIndexedReservations($id) {
            $sql = "SELECT * FROM reservations WHERE place_id =? ORDER BY id DESC LIMIT 1;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>