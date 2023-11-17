<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="../../public/css/custom.css">
    </head>
    <body>
        <div class="container">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Street</th>
                            <th>Zipcode</th>
                            <th>Go</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parkings as $parking): ?>
                            <tr>
                                    <td><?= $parking["name"]?></td>
                                    <td><?= $parking["country"]?></td>
                                    <td><?= $parking["city"]?></td>
                                    <td><?= $parking["street"]?></td>
                                    <td><?= $parking["zipcode"]?></td>
                                    <td><a href="../../index.php/parking?id=<?= $parking["id"] ?>">Go</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>