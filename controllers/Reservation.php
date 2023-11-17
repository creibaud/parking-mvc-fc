<?php
    require_once("/var/www/parking-crud-fc-mvc/models/Parking.php");
    require_once("/var/www/parking-crud-fc-mvc/models/Reservation.php");
    require_once("/var/www/parking-crud-fc-mvc/vendor/setasign/fpdf/fpdf.php");

    class ReservationController {
        private static ?ReservationController $instance = null;
        private Reservation $reservation;

        private function __construct() {
            $this->reservation = Reservation::getInstance();
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function add($path, $placeID) {
            $licensePlate = $_POST['licensePlate'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];

            if (strtotime($startTime) < strtotime($endTime)) {
                if (isset($placeID) && isset($licensePlate) && isset($startTime) && isset($endTime)) {
                    $stmt = $this->reservation->createReservation($placeID, $licensePlate, $startTime, $endTime);
                    if ($stmt) {
                        header('Location: /index.php'. $path . '?id='. $placeID);
                    }
                }
            }
        }

        public function getAll($path) {
            $reservations = $this->reservation->getAllReservation($_POST['placeID']);
            require_once("/var/www/parking-crud-fc-mvc/views". $path. ".php");
        }

        public function update($path, int $id) {
            $placeID = $_POST['placeID'];
            $licensePlate = $_POST['licensePlate'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];

            if (isset($id) && isset($licensePlate) && isset($startTime) && isset($endTime)) {
                $stmt = $this->reservation->updateReservation($id, $licensePlate, $startTime, $endTime);
                if ($stmt) {
                    header('Location: /index.php'. $path . '?id='. $placeID);
                }
            }
        }

        public function delete($path, int $id) {
            $placeID = $_POST['placeID'];
            if (isset($id)) {
                $stmt = $this->reservation->deleteReservation($id);
                if ($stmt) {
                    header('Location: /index.php'. $path . '?id='. $placeID);
                }
            }
        }

        public function goToPDF($path, int $id) {
            $parkingID = $_POST['parkingID'];
            $parkings = Parking::getInstance();
            $parking = $parkings->getParkingById($parkingID);
            $parkingName = $parking["name"];
            $parkingCountry = $parking["country"];
            $parkingCity = $parking["city"];
            $parkingStreet = $parking["street"];
            $parkingZipcode = $parking["zipcode"];
            $placeName = $_POST['placeName'];

            if (isset($id)) {
                $reservation = $this->reservation->getReservationById($id);
                $pdf = new FPDF();
                $pdf->AddPage();

                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Reservation', 0, 1, 'C');
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 10, 'Parking Name: '. $parkingName, 0, 1, 'L');
                $pdf->Cell(0, 10, 'Country: '. $parkingCountry, 0, 1, 'L');
                $pdf->Cell(0, 10, 'City: '. $parkingCity, 0, 1, 'L');
                $pdf->Cell(0, 10, 'Street: '. $parkingStreet, 0, 1, 'L');
                $pdf->Cell(0, 10, 'Reservation ID: '. $reservation["id"], 0, 1, 'L');
                $pdf->Cell(0, 10, 'Place : '. $placeName, 0, 1, 'CL');
                $pdf->Cell(0, 10, 'License Plate : '. $reservation["license_plate"], 0, 1, 'L');
                $pdf->Cell(0, 10, 'Start Time : '. $reservation["start_time"], 0, 1, 'L');
                $pdf->Cell(0, 10, 'End Time : '. $reservation["end_time"], 0, 1, 'L');
                $pdf->Ln();
                require_once("/var/www/parking-crud-fc-mvc/views". $path. ".php");
            }
        }

        public function clientPDF($path, int $placeID) {
            $licensePlate = $_POST['licensePlate'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];

            if (strtotime($startTime) < strtotime($endTime)) {
                if (isset($placeID) && isset($licensePlate) && isset($startTime) && isset($endTime)) {
                    $stmt = $this->reservation->createReservation($placeID, $licensePlate, $startTime, $endTime);
                    $reservation = $this->reservation->getLastIndexedReservations($placeID);
                    $this->goToPDF($path, $reservation["id"]);
                }
            }
        }
    }
?>