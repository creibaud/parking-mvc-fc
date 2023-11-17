<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard | Place : <?= $place["name"] ?></title>
        <link rel="stylesheet" href="../../../public/css/custom.css"/>
    </head>
    <body>
        <div class="container">
            <h1>Place : <?= $place["name"] ?></h1>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Edit</th>
                            <th>ID</th>
                            <th>License Plate</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                            <th>Download PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <form method="POST" action="../../dashboard/editReservation">
                                    <input type="hidden" name="placeID" value="<?= $place["id"] ?>">
                                    <td><input type="submit" value="Edit"></td>
                                    <td><input type="hidden" name="idPatchReservation" value="<?= $reservation["id"] ?>"><?= $reservation["id"] ?></td>
                                    <td><input type="text" name="licensePlate" value="<?= $reservation["license_plate"]?>" required></td>
                                    <td><input type="time" name="startTime" value="<?= $reservation["start_time"]?>" required></td>
                                    <td><input type="time" name="endTime" value="<?= $reservation["end_time"]?>" required></td>
                                </form>
                                <form method="POST" action="../../dashboard/deleteReservation">
                                    <input type="hidden" name="placeID" value="<?= $place["id"]?>">
                                    <input type="hidden" name="idDeleteReservation" value="<?= $reservation["id"]?>">
                                    <td><input type="submit" value="Delete"></td>
                                </form>
                                <form method="POST" action="../../dashboard/goToPDF">
                                    <input type="hidden" name="idPDFReservation" value="<?= $reservation["id"]?>">
                                    <input type="hidden" name="parkingID" value="<?= $place["parking_id"]?>">
                                    <input type="hidden" name="placeName" value="<?= $place["name"] ?>">
                                    <td><input type="submit" value="Reservation"></td>
                                </form>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <form method="POST" action="../../dashboard/addReservation">
                                <input type="hidden" name="placeID" value="<?= $place["id"] ?>">
                                <td></td>
                                <td></td>
                                <td><input type="text" name="licensePlate" required></td>
                                <td><input type="time" name="startTime" required></td>
                                <td><input type="time" name="endTime" required></td>
                                <td><input type="submit" value="Add"></td>
                                <td></td>
                            </form>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <a href="../../dashboard/parking?id=<?= $place["parking_id"] ?>">Go Back</a>
        </div>
    </body>
</html>