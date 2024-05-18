

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>HELLO </h1>
    <table>
        <thead>
            <tr>
                <th>ProductID</th>
                <th>ProductName</th>
                <th>SupplierID</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include './includes/database.php';

                $dbase = new Database();
                $stmt = $dbase->connect()->prepare('SELECT * FROM product');
                $stmt->execute();
                $counter = 0;
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row["ProductID"]; ?></td>
                        <td><?php echo $row["ProductName"]; ?></td>
                        <td><?php echo $row["SupplierID"]; ?></td>
                        <td><?php echo $row["Price"]; ?></td>
                    </tr>
                <?php } 
            ?>
        </tbody>
    </table>
</body>
</html>
