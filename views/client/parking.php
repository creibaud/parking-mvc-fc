<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Parking : <?= $parking["name"] ?></title>
        <link rel="stylesheet" href="../../public/css/custom.css">
    </head>
    <body>
        <div class="container">
            <h1>Parking : <?= $parking["name"] ?></h1>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Search</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>License Plate</th>
                            <th>Name</th>
                            <th>Reservation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($newPlaces as $place) :?>
                            <tr>
                                <form method="POST" action="../../index.php/parking/search/reservation">
                                    <input type="hidden" name="idReservation" value="<?= $place["id"] ?>">
                                    <input type="hidden" name="parkingID" value="<?= $parking["id"] ?>">
                                    <input type="hidden" name="placeName" value="<?= $place["name"] ?>">
                                    <td></td>
                                    <td><input type="text" name="licensePlate" required></td>
                                    <td><input type="hidden" name="startTime" value="<?= $startInput ?>" required><?= $startInput ?></td>
                                    <td><input type="hidden" name="endTime" value="<?= $endInput ?>" required><?= $endInput ?></td>
                                    <td><?= $place["name"]?></td>
                                    <td><input type="submit" value="Reserve"></td>
                                </form>

                            </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <form method="POST" action="../../index.php/parking/search">
                                <input type="hidden" name="idSearch" value="<?= $parking["id"] ?>">
                                <td><input type="submit" value="Search"></td>
                                <td><input type="time" name="startTime" value="<?= $startInput ?>" required></td>
                                <td><input type="time" name="endTime" value="<?= $endInput ?>" required></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </form>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <a href="../../index.php">Go Back</a>
        </div>
    </body>
</html>