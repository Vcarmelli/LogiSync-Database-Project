<?php

class Database {
    public function connect() {
        try {
            $username = "root";
            $password = "";
            $db = new PDO('mysql:host=localhost;port=3306;dbname=supplier_product_db', $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Database connected!";
            return $db;

        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
            die();
        }
    }
}