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
            <form id="query" method="post" action="./includes/retrieve.php" class="d-flex m-5 gap-3 align-items-center">
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Select Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-select" required>
                        <?php
                            include '../includes/database.php';
                            $dbase = new Database();
                            $stmt = $dbase->connect()->prepare('SELECT SupplierID, SupplierName FROM Supplier ORDER BY SupplierName;');
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['SupplierID'] . '">' . $row['SupplierName'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div><button id="querySupplier" name="querySupplier" type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></div>
            </form>
        </div>
        <div id="result"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../backend/index.js"></script>
    <script src="../backend/get.js"></script>
</body>
</html>