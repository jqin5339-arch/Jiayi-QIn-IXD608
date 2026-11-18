
<?php
function getProducts() {
    $config = require '/home1/staqwjmy/luma-db-config.php';

    $conn = new mysqli(
        $config['host'],
        $config['username'],
        $config['password'],
        $config['database']
    );

    $conn->set_charset('utf8mb4');

    $result = $conn->query(
        "SELECT * FROM products ORDER BY id ASC"
    );

    $products = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $products;
}