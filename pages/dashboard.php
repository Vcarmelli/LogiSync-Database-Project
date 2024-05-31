<?php
    $view = isset($_GET['view']) ? $_GET['view'] : 'guest'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiSync | Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../assets/logisync-logo-color.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/style.css">  
</head>
<body>
    <div class="wrapper">
        <?php include '../components/sidebar.php'; ?>
        <div class="main chart-page">
            <div class="">
                <?php if(isset($_SESSION["userid"])): ?>        
                    <span><h1 class="m-3 fs-1">Welcome, <?php echo $_SESSION["username"]; ?></h1></span>
                    <a href="./includes/logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>  
                    <h1 class="m-3 fs-1">Dashboard</h1>
                <?php endif ?>    
            </div>
            
            <div class="container d-flex ms-2">
                <div class="d-flex flex-column align-items-start flex-wrap"id="left-charts">
                    <div class="d-flex align-items-start">
                        <div class="card counts">
                            <div class="counts-img"><i class="fa-solid fa-warehouse"></i></div>
                            <div class="counts-title">Suppliers</div>
                            <div class="counts-num sup-count"></div>
                        </div>

                        <div class="card counts">
                            <div class="counts-img"><i class="fa-solid fa-spray-can-sparkles"></i></div>
                            <div class="counts-title">Products</div>
                            <div class="counts-num pro-count"></div>
                        </div>

                        <div class="card counts">
                            <div class="counts-img"><i class="fa-solid fa-clipboard-list "></i></div>
                            <div class="counts-title">Order</div>
                            <div class="counts-num ord-count"></div>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <div class="card chart count-chart">
                            <div class="counts-title my-3">Overall Count</div>
                            <div class="counts-num"><canvas id="overallChart"></canvas></div>
                        </div>
                        <div class="card chart range-chart">
                            <div class="counts-title my-3">Price Ranges</div>
                            <div class="counts-num"><canvas id="priceDistributionChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column" id="right-charts">                    
                    <div class="card chart top-suppliers-chart">
                        <div class="counts-title ">Top Suppliers</div>
                        <div class="counts-num"><canvas id="ordersPerSupplierChart" class="top-suppliers"></canvas></div>
                    </div>
                    
                    <div class="card chart line-chart">
                        <div class="counts-title">Orders per Month</div>
                        <div class="counts-num"><canvas id="ordersPerMonthChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../backend/dashboard.js"></script>
    <script src="../backend/index.js"></script>
    <script src="../backend/script.js"></script>
    <script src="../backend/get.js"></script>
    
</body>
</html>
