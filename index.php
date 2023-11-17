<?php
    require_once("/var/www/parking-crud-fc-mvc/controllers/Parking.php");
    require_once("/var/www/parking-crud-fc-mvc/controllers/Place.php");
    require_once("/var/www/parking-crud-fc-mvc/controllers/Reservation.php");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parkingController = ParkingController::getInstance();
    $placeController = PlaceController::getInstance();
    $reservationController = ReservationController::getInstance();

    if ("/index.php" == $uri) {
        $parkingController->getAll("/client/home");
    } else if ("/index.php/parking" == $uri && $_SERVER['REQUEST_METHOD'] == "GET") {
        $parkingController->getById("/client/parking", $_GET['id']);
    } else if ("/index.php/parking/search" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $parkingController->search("/client/parking", $_POST['idSearch']);
    } else if ("/index.php/parking/search/reservation" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $reservationController->clientPDF("/client/reservationPDF", $_POST['idReservation']);
    } else if ("/index.php/dashboard/addParking" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $parkingController->add("/dashboard");
    } else if ("/index.php/dashboard" == $uri && $_SERVER['REQUEST_METHOD'] == "GET") {
        $parkingController->getAll("/admin/dashboard");
    } else if ("/index.php/dashboard/editParking" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $parkingController->update("/dashboard", $_POST['idPatchParking']);
    } else if ("/index.php/dashboard/deleteParking" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $parkingController->delete("/dashboard", $_POST['idDeleteParking']);
    } else if ("/index.php/dashboard/parking" == $uri && $_SERVER['REQUEST_METHOD'] == "GET") {
        $parkingController->getById("/admin/parking", $_GET['id']);
    } else if ("/index.php/dashboard/parking/place" == $uri && $_SERVER['REQUEST_METHOD'] == "GET") {
        $placeController->getById("/admin/place", $_GET['id']);
    } else if ("/index.php/dashboard/addReservation" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $reservationController->add("/dashboard/parking/place", $_POST['placeID']);
    } else if ("/index.php/dashboard/editReservation" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $reservationController->update("/dashboard/parking/place", $_POST['idPatchReservation']);
    } else if ("/index.php/dashboard/deleteReservation" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $reservationController->delete("/dashboard/parking/place", $_POST['idDeleteReservation']);
    } else if ("/index.php/dashboard/goToPDF" == $uri && $_SERVER['REQUEST_METHOD'] == "POST") {
        $reservationController->goToPDF("/admin/reservationPDF", $_POST['idPDFReservation']);
    } else {
        header("HTTP/1.1 404 Not Found");
    }
?>