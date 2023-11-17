<?php
    require_once("/var/www/parking-crud-fc-mvc/models/Database.php");

    class Place {
        private static ?Place $instance = null;
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
            $sql = "CREATE TABLE IF NOT EXISTS places (
                        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        name INT NOT NULL,
                        is_occupied TINYINT(1) NOT NULL,
                        parking_id INT NOT NULL,
                        FOREIGN KEY (parking_id) REFERENCES parkings(id)
                    );";
            $this->db->save($sql);
        }

        public function createPlace(string $name, int $isOccupied, int $parkingID) {
            $sql = "INSERT INTO places (name, is_occupied, parking_id) VALUES (?,?,?);";
            $params = [$name, $isOccupied, $parkingID];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function getAllPlace(int $parkingID) {
            $sql = "SELECT * FROM places WHERE parking_id =?;";
            $params = [$parkingID];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPlaceById(int $id) {
            $sql = "SELECT * FROM places WHERE id =?;";
            $params = [$id];
            $stmt = $this->db->save($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updatePlace(int $id, int $isOccupied) {
            $sql = "UPDATE places SET is_occupied =? WHERE id =?;";
            $params = [$isOccupied, $id];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }

        public function deletePlace(int $name, int $parkingID) {
            $sql = "DELETE FROM places WHERE name =? AND parking_id=?;";
            $params = [$name, $parkingID];
            $stmt = $this->db->save($sql, $params);
            return $stmt;
        }
    }
?>