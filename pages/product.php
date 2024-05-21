<?php
    $show = isset($_GET['report']) ? $_GET['report'] : 'Supplier';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="wrapper">
        <?php include '../components/sidebar.php'; ?>
        <div class="main">
            <div><h1>List of Products</h1></div>

            <div class="container p-5">
                <div>
                    <form id="search" action="" method="GET">
                        <div class="input-group mb-5">
                            <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control search-input" 
                                    placeholder="Search by ID or Product Name" required>
                            <input type="hidden" name="report" value="product" class="search-table">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <div id="results"></div>
                </div>

                <table class="table table-striped table-hover table-bordered rounded default-table">
                    <thead class="table-dark">
                        <tr>
                            <?php foreach (["Product ID", "Product Name", "Supplier ID", "Price", "Action"] as $columnName) { ?>
                                <th><?php echo $columnName; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    <?php
                        require_once '../includes/database.php';

                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT * FROM product');
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <?php foreach ($row as $value) { ?>
                                    <td><?php echo $value; ?></td>
                                <?php } ?>
                                <?php include '../components/edit_delete.php'; ?>
                            </tr>
                        <?php }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../backend/index.js"></script>
    <script src="../backend/get.js"></script>
</body>
</html>