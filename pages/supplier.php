<?php
    require_once '../includes/database.php';
    session_start();
    $whichTable = "supplier"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiSync | Suppliers</title>
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
                <h1 class="me-auto fs-1">Suppliers</h1>
                <span><button id="view-btn" type="button" class="btn btn-view mx-5 active" data-table="supplier">View All</button></span>
                <span class="me-5"><button type="button" id="add-supplier" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dynamicFormModal" data-form="supplier">
                    <i class="fa-solid fa-user-pen"></i> Add Supplier</button>
                </span>
            </div>

            <!-- ADD Modal -->
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
                    Supplier table updated successfully.
                </div>
                <div id="alert-error" class="alert alert-danger d-none fade show" role="alert">
                    Invalid input. Please review the information provided and try again.
                </div>
            </div>
            
            
            <div class="card mx-5">
                <div class="card-header">
                    <form id="search" method="GET">
                        <div class="input-group mb-5">
                            <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control search-input" 
                                    placeholder="Search by Supplier ID or Supplier Name" required>
                            <input type="hidden" name="report" value="supplier" class="search-table">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div id="results"></div>
                    <table id="supplierTable" class="table table-hover default-table table-pad">
                        <thead class="table-head">
                            <tr>
                                <?php foreach (["Supplier ID", "Supplier Name", "Contact Person", "Contact Number"] as $columnName) { ?>
                                    <th><?php echo $columnName; ?></th>
                                <?php } ?>

                                <?php if ($_SESSION["type"] === 'admin'): ?>
                                    <th>Action</th>
                                <?php endif ?>
                            </tr>
                        </thead>

                        <tbody class="table-group-divider load-all">
                            <?php include '../components/get_all.php'; ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <div id="pagination-nav" class="d-flex justify-content-center mt-2 paging">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="#" data-page="<?php echo $i; ?>" data-table="<?php echo $whichTable;?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
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