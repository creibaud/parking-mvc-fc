<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard | Parking : <?= $parking["name"] ?></title>
        <link rel="stylesheet" href="../../public/css/custom.css">
    </head>
    <body>
        <div class="container">
            <h1>Parking : <?= $parking["name"] ?></h1>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Is Occupied</th>
                            <th>Go</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($newPlaces as $place) :?>
                            <tr>
                                <td><?= $place["id"]?></td>
                                <td><?= $place["name"]?></td>
                                <td><?= $place["is_occupied"]?></td>
                                <td><a href="../../index.php/dashboard/parking/place?id=<?= $place["id"]?>">Go</a></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <a href="../../index.php/dashboard">Go Back</a>
        </div>
    </body>
</html>