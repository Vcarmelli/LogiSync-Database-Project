<aside id="sidebar" class="expand">
    <div class="d-flex">
        <button id="toggle-btn" type="button">
            <i class="fa-solid fa-bars"></i> 
        </button>
        <div class="sidebar-logo">
            <a href="index.php">Project Name</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#forms" aria-expanded="false" aria-controls="forms">
                <i class="fa-solid fa-list"></i>
                <span>Forms</span>
            </a>
            <ul id="forms" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="forms.php?form=supplier" class="sidebar-link">
                        <i class="fa-solid fa-warehouse"></i>
                        <span>Add Supplier</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="forms.php?form=product" class="sidebar-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="forms.php?form=order" class="sidebar-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Add Order</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-chart-simple"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>
</aside>