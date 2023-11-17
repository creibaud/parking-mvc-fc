<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="../../public/css/custom.css">
    </head>
    <body>
        <div class="container">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Edit</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Street</th>
                            <th>Zipcode</th>
                            <th>Capacity</th>
                            <th>Action</th>
                            <th>Go</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parkings as $parking): ?>
                            <tr>
                                <form method="POST" action="../../index.php/dashboard/editParking">
                                    <input type="hidden" name="actualCapcity" value="<?= $parking["capacity"]?>">
                                    <td><input type="submit" value="Edit"></td>
                                    <td><input type="hidden" name="idPatchParking" value="<?= $parking["id"] ?>"><?= $parking["id"] ?></td>
                                    <td><input type="text" name="name" value="<?= $parking["name"]?>" required></td>
                                    <td><input type="text" name="country" value="<?= $parking["country"]?>" required></td>
                                    <td><input type="text" name="city" value="<?= $parking["city"]?>" required></td>
                                    <td><input type="text" name="street" value="<?= $parking["street"]?>" required></td>
                                    <td><input type="number" name="zipcode" value="<?= $parking["zipcode"]?>" min="0" max="99999" required></td>
                                    <td><input type="number" name="capacity" value="<?= $parking["capacity"]?>" min="0" max="99999" required></td>
                                </form>
                                <form method="POST" action="../../index.php/dashboard/deleteParking">
                                    <input type="hidden" name="idDeleteParking" value="<?= $parking["id"]?>">
                                    <td><input type="submit" value="Delete"></td>
                                </form>
                                    <td><a href="../../index.php/dashboard/parking?id=<?= $parking["id"] ?>">Go</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <form method="POST" action="../../index.php/dashboard/addParking">
                                <td></td>
                                <td></td>
                                <td><input type="text" name="name" required></td>
                                <td><input type="text" name="country" required></td>
                                <td><input type="text" name="city" required></td>
                                <td><input type="text" name="street" required></td>
                                <td><input type="number" name="zipcode" min="0" max="99999" required></td>
                                <td><input type="number" name="capacity" min="0" max="99999" required></td>
                                <td><input type="submit" value="Add"></td>
                                <td></td>
                            </form>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>