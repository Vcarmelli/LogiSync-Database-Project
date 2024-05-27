<?php

require_once __DIR__ . '/vendor/autoload.php';

if (isset($_POST['get'])) {
    $filterValues = $_GET['searchInput'];
    $whichTable = $_GET['searchTable'];
    $searchColumns = $_GET['searchColumns'];
}