<?php
    require_once("/var/www/parking-crud-fc-mvc/models/Parking.php");
    require_once("/var/www/parking-crud-fc-mvc/models/Place.php");
    require_once("/var/www/parking-crud-fc-mvc/models/Reservation.php");

    class ParkingController {
        private static ?ParkingController $instance = null;
        private Parking $parking;
        private Place $place;
        private Reservation $reservation;

        private function __construct() {
            $this->parking = Parking::getInstance();
            $this->place = Place::getInstance();
            $this->reservation = Reservation::getInstance();
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function add($path) {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $zipcode = $_POST['zipcode'];
            $capacity = $_POST['capacity'];
                
            if (isset($name) && isset($country) && isset($city) && isset($street) && isset($zipcode) && isset($capacity)) {
                $stmt = $this->parking->createParking($name, $country, $city, $street, $zipcode, $capacity);
                $parking = $this->parking->getLastIndex();
                $actualID = $parking['id'];
                if ($stmt) {
                    for ($i = 0; $i < $capacity; $i++) {
                        $this->place->createPlace($i + 1, 0, $actualID);
                    }
                    header('Location: /index.php'. $path);
                }
            }
        }

        public function getAll($path) {
            $parkings = $this->parking->getAllParking();
            require_once("/var/www/parking-crud-fc-mvc/views/" . $path . ".php");
        }

        public function getById($path, int $id) {
            if (isset($id)) {
                $parking = $this->parking->getParkingById($id);
                $places = $this->place->getAllPlace($id);
                foreach ($places as $place) {
                    $reservations = $this->reservation->getAllReservation($place['id']);
                    $actualTime = strtotime(date('h:i:s')) + 3600;
                    foreach ($reservations as $reservation) {
                        if (strtotime($reservation['start_time']) <= $actualTime && strtotime($reservation['end_time']) >= $actualTime) {
                            $this->place->updatePlace($place['id'], 1);
                        } else {
                            $this->place->updatePlace($place['id'], 0);
                        }
                    }
                }
                $newPlaces = $this->place->getAllPlace($id);
                $startInput = "";
                $endInput = "";
                require_once("/var/www/parking-crud-fc-mvc/views". $path . ".php");
            }
        }

        public function search($path, int $parkingID) {
            $start = $_POST['startTime'];
            $end = $_POST['endTime'];
            $tmp = [];

            if (isset($parkingID) && isset($start) && isset($end)) {
                $places = $this->place->getAllPlace($parkingID);
                foreach ($places as $place) {
                    $reservations = $this->reservation->getAllReservation($place['id']);
                    $count = $this->reservation->countReservations($place['id']);
                    if ($count > 0) {
                        foreach ($reservations as $reservation) {
                            if (strtotime($reservation['start_time']) > strtotime($end)) {
                                array_push($tmp, $place);
                            } else if (strtotime($reservation['end_time']) < strtotime($start)) {
                                array_push($tmp, $place);
                            }
                        }
                    } else {
                        if ($place['is_occupied'] == 0) {
                            array_push($tmp, $place);
                        }
                    }
                }

                $parking = $this->parking->getParkingById($parkingID);
                $newPlaces = $tmp;
                $startInput = $start;
                $endInput = $end;
                require_once("/var/www/parking-crud-fc-mvc/views". $path . ".php");
            }
        }

        public function update($path, int $id) {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $zipcode = $_POST['zipcode'];
            $capacity = $_POST['capacity'];
            $oldCapacity = $_POST['actualCapcity'];
            $isOkToDelete = false;

            if (isset($name) && isset($country) && isset($city) && isset($street) && isset($zipcode) && isset($capacity)) {
                if ($oldCapacity <= $capacity) {
                    for ($i = $oldCapacity; $i < $capacity; $i++) {
                        $this->place->createPlace($i + 1, 0, $id);
                    }
                    $isOkToDelete = true;
                } else if ($oldCapacity > $capacity) {
                    $places = $this->place->getAllPlace($id);
                    for ($i = $oldCapacity; $i > $capacity; $i--) {
                        $place = $places[$i - 1];
                        $reservationCount = $this->reservation->countReservations($place['id']);
                        if ($reservationCount == 0) {
                            $this->place->deletePlace($i, $id);
                            $isOkToDelete = true;
                        } else {
                            $isOkToDelete = false;
                            break;
                        }
                    }
                }

                if ($isOkToDelete) {
                    $this->parking->updateParking($id, $name, $country, $city, $street, $zipcode, $capacity);
                    header('Location: /index.php'. $path);
                }
            }
        }

        public function delete($path, int $id) {
            if (isset($id)) {
                $parking = $this->parking->getParkingById($id);
                $capacity = $parking['capacity'];
                $places = $this->place->getAllPlace($id);

                foreach ($places as $place) {
                    $this->reservation->deleteAllReservation($place['id']);
                    $this->place->deletePlace($place['name'], $id);
                }

                $stmt = $this->parking->deleteParking($id);
                if ($stmt) {
                    header('Location: /index.php'. $path);
                }
            }
        }
    }
?>