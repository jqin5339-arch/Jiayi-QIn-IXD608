<?php

require_once __DIR__ . "/pdo.php";

// Get recommended products by category
function getRecommendedProducts(
    $category,
    $excludeId = 0,
    $limit = 3
) {

    $conn = makePDOConn();

    $sql = "SELECT * FROM products
            WHERE category = :category
            AND id != :exclude_id
            ORDER BY date_create DESC, id DESC
            LIMIT :limit";

    $statement = $conn->prepare($sql);

    $statement->bindValue(
        ':category',
        $category,
        PDO::PARAM_STR
    );

    $statement->bindValue(
        ':exclude_id',
        (int)$excludeId,
        PDO::PARAM_INT
    );

    $statement->bindValue(
        ':limit',
        (int)$limit,
        PDO::PARAM_INT
    );

    $statement->execute();

    return $statement->fetchAll();
}

// Display a reusable recommendation section
function showRecommendedProducts(
    $title,
    $category,
    $excludeId = 0,
    $limit = 3
) {

    $products = getRecommendedProducts(
        $category,
        $excludeId,
        $limit
    );

    if (empty($products)) {
        return;
    }

    echo '<section class="container section recommended-section">';

    echo '<h2>' .
         htmlspecialchars($title, ENT_QUOTES, 'UTF-8') .
         '</h2>';

    echo '<div class="product-grid recommended-grid">';

    foreach ($products as $plant) {

        $id = (int)$plant['id'];

        include __DIR__ . "/../../parts/product-card.php";

    }

    echo '</div>';

    echo '</section>';
}
