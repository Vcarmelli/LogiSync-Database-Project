<aside id="sidebar" class="expand">
    <div class="d-flex sidebar-title">
        <button id="toggle-btn" type="button">
            <img src="../assets/logisync-logo.png" alt="LogiSync" height="40">
        </button>
        <div class="sidebar-logo">
            <a href="../index.php"><img src="../assets/logisync-logo-text.png" alt="LogiSync" height="60"></a>
        </div>
    </div>
    <div class="sidebar-pages">
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="../index.php" class="sidebar-link">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if ($view === 'admin'): ?>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#reports" aria-expanded="false" aria-controls="reports">
                    <i class="fa-solid fa-table"></i>
                    <span>Manage Logistics</span>
                </a>
                <ul id="reports" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../pages/supplier.php" class="sidebar-link">
                            <i class="fa-solid fa-warehouse"></i>
                            <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../pages/product.php" class="sidebar-link">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../pages/purchaseorder.php" class="sidebar-link">
                            <i class="fa-solid fa-clipboard-list"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php elseif ($view === 'guest'): ?>
            <li class="sidebar-item">
                <a href="../index.php" class="sidebar-link">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>WALA BLEH</span>
                </a>
            </li>   
            <?php endif ?>
            <li class="sidebar-item mt-5">
                <a href="../includes/logout.php" class="sidebar-link">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>  
        </ul> 
    </div>
</aside>