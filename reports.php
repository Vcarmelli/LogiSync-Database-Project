<?php
    $formToShow = isset($_GET['report']) ? $_GET['report'] : 'supplier'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">  
</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="main">
            <h1>
                <?php echo ($formToShow === 'supplier') ? 'List of Supplier and their Products' : 'List of Orders'; ?>
            </h1>
            <div class="container w-75">
                <table class="table table-striped table-hover table-bordered rounded">
                <?php if ($formToShow === 'supplier'): ?>
                    <thead class="table-dark">
                        <tr>
                            <?php foreach (["Product ID", "Product Name", "Supplier ID", "Price"] as $columnName) { ?>
                                <th><?php echo $columnName; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    <?php
                        include './includes/database.php';

                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT * FROM product');
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <?php foreach ($row as $value) { ?>
                                    <td><?php echo $value; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } 
                    ?>
                    </tbody>
                <?php elseif ($formToShow === 'order'): ?>
                    <thead class="table-dark">
                        <tr>
                            <?php foreach (["Order ID", "Supplier ID", "Order Date", "Delivery Date"] as $columnName) { ?>
                                <th><?php echo $columnName; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    <?php
                        include './includes/database.php';

                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT * FROM purchaseorder');
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <?php foreach ($row as $value) { ?>
                                    <td><?php echo $value; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } 
                    ?>
                    </tbody>
                <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/backend/index.js"></script>
</body>
</html>