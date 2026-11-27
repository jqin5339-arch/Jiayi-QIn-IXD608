<?php
require_once __DIR__ . "/db.php";

header("Content-Type: application/json; charset=utf-8");

try {
    $products = getProducts();

    // Read API request
    $type = $_GET["type"] ?? "products_all";
    $search = trim($_GET["search"] ?? "");

    switch ($type) {

        case "product_search":
            $products = array_filter(
                $products,
                function ($plant) use ($search) {
                    return stripos(
                        $plant["name"],
                        $search
                    ) !== false;
                }
            );
            break;

case "product_filter":
    $category = trim($_GET["category"] ?? "All");

    $allowedCategories = [
        "All",
        "Indoor",
        "Hanging",
        "Low Light",
        "Statement",
        "Succulent"
    ];

    if (!in_array($category, $allowedCategories, true)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid category"]);
        exit;
    }

    if ($category !== "All") {
        $products = array_filter(
            $products,
            function ($plant) use ($category) {
                return $plant["category"] === $category;
            }
        );
    }
    break;

case "product_sort":
    $sort = $_GET["sort"] ?? "price_asc";

    $allowedSorts = [
        "price_asc",
        "price_desc",
        "name_asc",
        "name_desc"
    ];

    if (!in_array($sort, $allowedSorts, true)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid sort"]);
        exit;
    }

    usort($products, function ($a, $b) use ($sort) {
        switch ($sort) {
            case "price_asc":
                return (float)$a["price"] <=> (float)$b["price"];

            case "price_desc":
                return (float)$b["price"] <=> (float)$a["price"];

            case "name_asc":
                return strcasecmp($a["name"], $b["name"]);

            case "name_desc":
                return strcasecmp($b["name"], $a["name"]);
        }

        return 0;
    });
    break;

        case "products_all":
            break;

        default:
            http_response_code(400);
            echo json_encode([
                "error" => "Invalid request type"
            ]);
            exit;
    }

    echo json_encode(array_values($products));

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Unable to load products"
    ]);
}
