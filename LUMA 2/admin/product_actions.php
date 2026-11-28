<?php

require_once __DIR__ . "/../lib/php/functions.php";
require_once __DIR__ . "/../lib/php/pdo.php";

initSession();

header("Cache-Control: no-store, no-cache, must-revalidate");

// Enable only after protecting the admin directory
$allowWrites = false;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// CSRF protection
$token = $_POST['csrf_token'] ?? '';

if (!is_string($token) ||
    empty($_SESSION['admin_csrf']) ||
    !hash_equals($_SESSION['admin_csrf'], $token)) {
    http_response_code(403);
    exit("Invalid request.");
}

$action = $_POST['action'] ?? '';

switch ($action) {

    case "update":

        $id = filter_var(
            $_POST['id'] ?? '',
            FILTER_VALIDATE_INT
        );

        $name = trim($_POST['name'] ?? '');
        $price = $_POST['price'] ?? '';

        if (!$id || $id < 1 ||
            $name === '' ||
            !is_numeric($price) ||
            $price < 0) {
            exit("Invalid product information.");
        }

        try {

            $conn = makePDOConn();

            $sql = "UPDATE products SET
                        name = :name,
                        price = :price,
                        category = :category,
                        url = :url,
                        description = :description,
                        thumbnail = :thumbnail,
                        images = :images
                    WHERE id = :id";

            $statement = $conn->prepare($sql);

            $data = [
                'name' => $name,
                'price' => $price,
                'category' => $_POST['category'] ?? '',
                'url' => $_POST['url'] ?? '',
                'description' => $_POST['description'] ?? '',
                'thumbnail' => $_POST['thumbnail'] ?? '',
                'images' => $_POST['images'] ?? '',
                'id' => $id
            ];

            if ($allowWrites) {

                $statement->execute($data);
                $_SESSION['admin_message'] = "Product updated successfully!";

            } else {

                $_SESSION['admin_message'] = "Update request validated. Preview mode: database unchanged.";

            }

            session_write_close();

            header(
                "Location: index.php?id=" . $id .
                "&v=" . time(),
                true,
                303
            );

            exit;

        } catch (PDOException $e) {

            error_log($e->getMessage());
            http_response_code(500);
            exit("Unable to update product.");

        }

    case "create":

        $name = trim($_POST['name'] ?? '');
        $price = $_POST['price'] ?? '';

        if ($name === '' ||
            !is_numeric($price) ||
            $price < 0) {

            exit("Invalid product information.");
        }

        try {

            $conn = makePDOConn();

            $sql = "INSERT INTO products
                    (name, price, category, url,
                     description, thumbnail, images,
                     date_create, date_modify)
                    VALUES
                    (:name, :price, :category, :url,
                     :description, :thumbnail, :images,
                     NOW(), NOW())";

            $statement = $conn->prepare($sql);

            $data = [
                'name' => $name,
                'price' => $price,
                'category' => $_POST['category'] ?? '',
                'url' => $_POST['url'] ?? '',
                'description' => $_POST['description'] ?? '',
                'thumbnail' => $_POST['thumbnail'] ?? '',
                'images' => $_POST['images'] ?? ''
            ];

            if ($allowWrites) {

                $statement->execute($data);

                $newId = $conn->lastInsertId();

                $_SESSION['admin_message'] =
                    "Product created successfully!";

                $redirect = "index.php?id=" . $newId;

            } else {

                $_SESSION['admin_message'] =
                    "Create request validated. Preview mode: database unchanged.";

                $redirect = "index.php?id=new";

            }

            session_write_close();

            header(
                "Location: " . $redirect .
                "&v=" . time(),
                true,
                303
            );

            exit;

        } catch (PDOException $e) {

            error_log($e->getMessage());
            http_response_code(500);
            exit("Unable to create product.");

        }

    case "delete":

        $id = filter_var(
            $_POST['id'] ?? '',
            FILTER_VALIDATE_INT
        );

        if (!$id || $id < 1) {
            http_response_code(400);
            exit("Invalid product ID.");
        }

        try {

            $conn = makePDOConn();

            $sql = "DELETE FROM products
                    WHERE id = :id";

            $statement = $conn->prepare($sql);

            if ($allowWrites) {

                $statement->execute([
                    'id' => $id
                ]);

                $_SESSION['admin_message'] =
                    "Product deleted successfully!";

            } else {

                $_SESSION['admin_message'] =
                    "Delete request validated. Preview mode: database unchanged.";

            }

            session_write_close();

            header(
                "Location: index.php?v=" . time(),
                true,
                303
            );

            exit;

        } catch (PDOException $e) {

            error_log($e->getMessage());
            http_response_code(500);
            exit("Unable to delete product.");

        }

    default:

        header("Location: index.php");
        exit;
}
