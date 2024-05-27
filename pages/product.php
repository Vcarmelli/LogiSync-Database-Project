<?php
    $show = isset($_GET['report']) ? $_GET['report'] : 'Supplier';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiSync | Products</title>
    <link rel="icon" type="image/x-icon" href="../assets/logisync-logo-color.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/style.css">    
</head>
<body>
    <div class="wrapper">
        <?php include '../components/sidebar.php'; ?>
        <div class="main">
            <div class="d-flex align-items-center mt-3">
                <h1 class="me-auto fs-1">Products</h1>
                <span class="me-5"><button type="submit" id="add-product" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dynamicFormModal" data-form="product">
                    <i class="fa-solid fa-user-pen"></i> Add Product</button>
                </span>
            </div>

            <!-- Modal -->
            <div class="modal fade mt-5" id="dynamicFormModal" tabindex="-1" aria-labelledby="dynamicFormModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content px-4 py-3" id="modalContent"></div>
                </div>
            </div>

            <!-- EDIT Modal -->
            <div class="modal fade mt-2" id="dynamicEditModal" tabindex="-1" aria-labelledby="dynamicEditModalLabel" aria-hidden="true">
                <div class="modal-dialog d-flex justify-self-center modal-lg">
                    <div class="modal-content px-4 py-3" id="editModalContent"></div>
                </div>
            </div>

            <!-- DELETE Modal -->
            <div class="modal fade mt-5" id="dynamicDeleteModal" tabindex="-1" aria-labelledby="dynamicDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog d-flex justify-self-center modal-lg">
                    <div class="modal-content px-4 py-3" id="deleteModalContent"></div>
                </div>
            </div>

             <!-- Alerts -->
            <div class="container w-50">
                <div id="alert-success" class="alert alert-success d-none fade show" role="alert">
                    Product table updated successfully.
                </div>
                <div id="alert-error" class="alert alert-danger d-none fade show" role="alert">
                    Invalid input. Please review the information provided and try again.
                </div>
            </div>
            

            <div class="card m-5">
                <div class="card-header">Products Table</div>
                <div class="card-body">
                    <div>
                        <form id="search" action="" method="GET">
                            <div class="input-group mb-5">
                                <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control search-input" 
                                        placeholder="Search by ID or Product Name" required>
                                <input type="hidden" name="report" value="product" class="search-table">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                    <div id="results"></div>

                    <table id="productTable" class="table table-hover default-table table-pad">
                        <thead class="table-head">
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
                            
                            $firstColumn = null;
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                                if ($row) {
                                    foreach ($row as $column => $value) {
                                        $firstColumn = $column; ?>
                                        <tr>
                                            <input class="rowID" type="hidden" value="<?php echo $row[$firstColumn]; ?>">
                                            <?php foreach ($row as $value) { ?>
                                                <td><?php echo $value; ?></td>
                                            <?php } ?>
                                            <?php $whichTable = "product"; 
                                                  include '../components/edit_delete.php'; ?>
                                        </tr>
                                        <?php break; 
                                    }
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../backend/index.js"></script>
    <script src="../backend/script.js"></script>
    <script src="../backend/get.js"></script>
    
</body>
</html>