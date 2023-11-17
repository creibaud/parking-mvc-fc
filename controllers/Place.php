<?php
    require_once("/var/www/parking-crud-fc-mvc/models/Place.php");
    require_once("/var/www/parking-crud-fc-mvc/models/Reservation.php");

    class PlaceController {
        private static ?PlaceController $instance = null;
        private Place $place;
        private Reservation $reservation;

        private function __construct() {
            $this->place = Place::getInstance();
            $this->reservation = Reservation::getInstance();
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function getById($path, int $id) {
            if (isset($id)) {
                $place = $this->place->getPlaceById($id);
                $reservations = $this->reservation->getAllReservation($id);
                $actualTime = strtotime(date('h:i:s')) + 3600;
                foreach ($reservations as $reservation) {
                    if (strtotime($reservation['end_time']) < $actualTime) {
                        $this->reservation->deleteReservation($reservation['id']);
                    }
                }
                $reservations = $this->reservation->getAllReservation($id);
                require_once("/var/www/parking-crud-fc-mvc/views". $path. ".php");
            }
        }
    }
?>