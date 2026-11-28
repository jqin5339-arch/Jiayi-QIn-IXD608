<?php

require_once __DIR__ . "/../lib/php/functions.php";
require_once __DIR__ . "/../lib/php/pdo.php";
initSession();

header("Cache-Control: no-store, no-cache, must-revalidate");

if (empty($_SESSION['admin_csrf'])) {
    $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
}
// Escape HTML
function adminEscape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Display a product in the product list
function productListItem($product) {

    $id = (int)$product['id'];
    $name = adminEscape($product['name']);
    $price = number_format((float)$product['price'], 2);
    $category = adminEscape($product['category'] ?? '');

    $thumbnail = rawurlencode(
        basename(trim($product['thumbnail'] ?? ''))
    );

    $imageHTML = $thumbnail !== '' ? "
        <img src='../images/$thumbnail'
             alt='$name'
             class='admin-card-photo'>
    " : "";

    return "
        <article class='admin-product-card'>

            <a class='admin-card-image'
               href='index.php?id=$id'>
                $imageHTML
            </a>

            <div class='admin-card-content'>

                <span class='small-note'>ID: $id</span>

                <h3>$name</h3>

                <p class='admin-card-category'>
                    $category
                </p>

                <p class='admin-card-price'>
                    \$$price
                </p>

                <a class='btn btn-secondary'
                   href='index.php?id=$id'>
                    EDIT PRODUCT
                </a>

            </div>

        </article>
    ";
}

// Display product information and edit form
function showProductPage($product) {

    $isNew = empty($product['id']);

    $id = adminEscape($product['id'] ?? '');
    $name = adminEscape($product['name'] ?? '');
    $price = adminEscape($product['price'] ?? '');
    $category = adminEscape($product['category'] ?? '');
    $description = adminEscape($product['description'] ?? '');
    $url = adminEscape($product['url'] ?? '');
    $thumbnail = adminEscape($product['thumbnail'] ?? '');
    $images = adminEscape($product['images'] ?? '');

    $title = $isNew ? "Add New Product" : $name;
    $formTitle = $isNew ? "New Product" : "Edit Product";
    $buttonText = $isNew ? "ADD PRODUCT" : "SAVE CHANGES";
$action = $isNew ? "create" : "update";
$csrfToken = adminEscape($_SESSION['admin_csrf']);
$buttonDisabled = "";

    // Thumbnail
    $thumbnailHTML = "";

    if (!empty($product['thumbnail'])) {
        $filename = rawurlencode(
            basename(trim($product['thumbnail']))
        );

        $thumbnailHTML = "
            <img class='admin-thumbnail'
                 src='../images/$filename'
                 alt='$name'>
        ";
    }

    // Product images
    $imageList = array_filter(
        array_map(
            'trim',
            explode(',', $product['images'] ?? '')
        )
    );

    $imagesHTML = "";

    foreach ($imageList as $image) {
        $filename = rawurlencode(basename($image));

        $imagesHTML .= "
            <img src='../images/$filename' alt='$name'>
        ";
    }

    // Delete button for existing products
 
$deleteButton = $isNew ? "" : "
    <form action='product_actions.php'
          method='POST'
          onsubmit=\"return confirm('Are you sure you want to delete this product?');\">

        <input type='hidden'
               name='action'
               value='delete'>

        <input type='hidden'
               name='id'
               value='$id'>

        <input type='hidden'
               name='csrf_token'
               value='$csrfToken'>

        <button type='submit'
                class='btn btn-danger'>
            DELETE
        </button>

    </form>
";


    $preview = $isNew ? "
        <h2>Product Preview</h2>
        <p>New product information will appear here after saving.</p>
    " : "
        <h2>$name</h2>

        <p><strong>Product ID:</strong> $id</p>
        <p><strong>Price:</strong> \$$price</p>
        <p><strong>Category:</strong> $category</p>

        <h3>Description</h3>
        <p>$description</p>

        <h3>Thumbnail</h3>
        $thumbnailHTML

        <h3 style='margin-top:24px;'>Product Images</h3>

        <div class='admin-images'>
            $imagesHTML
        </div>
    ";

    return "
        <div class='admin-toolbar'>
            <a class='btn btn-secondary' href='index.php'>
                &larr; BACK
            </a>

            $deleteButton
        </div>

        <h1>$title</h1>

        <div class='admin-layout'>

            <section class='panel'>
                $preview
            </section>

            <section class='panel'>

                <h2>$formTitle</h2>

              <form class='admin-form'
      action='product_actions.php'
      method='POST'>

    <input type='hidden'
           name='action'
           value='$action'>

    <input type='hidden'
           name='csrf_token'
           value='$csrfToken'>

                    <input type='hidden'
                           name='id'
                           value='$id'>

                    <label for='name'>Product Name</label>
                    <input id='name'
                           name='name'
                           type='text'
                           value='$name'>

                    <label for='price'>Price</label>
                    <input id='price'
                           name='price'
                           type='number'
                           min='0'
                           step='0.01'
                           value='$price'>

                    <label for='category'>Category</label>
                    <input id='category'
                           name='category'
                           type='text'
                           value='$category'>

                    <label for='url'>URL</label>
                    <input id='url'
                           name='url'
                           type='text'
                           value='$url'>

                    <label for='description'>Description</label>
                    <textarea id='description'
                              name='description'>$description</textarea>

                    <label for='thumbnail'>Thumbnail</label>
                    <input id='thumbnail'
                           name='thumbnail'
                           type='text'
                           value='$thumbnail'>

                    <label for='images'>Product Images</label>
                    <textarea id='images'
                              name='images'>$images</textarea>

                    <p class='small-note'>
                        Separate image filenames with commas.
                    </p>

                    <div class='button-row'>
                      <button type='submit'
        class='btn btn-primary'
        $buttonDisabled>
    $buttonText
</button>
                    </div>

                </form>

            </section>

        </div>
    ";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUMA | Product Admin</title>

    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="admin.css?v=1127v4">
</head>

<body>

    <header class="site-header">
        <div class="container header-inner">

            <a class="logo" href="index.php">
                Product Admin
            </a>

            <nav class="main-nav">
                <a href="index.php">Product List</a>
                <a href="index.php?id=new">Add New Product</a>
            </nav>

        </div>
    </header>

    <main class="container section">


<?php

        if (isset($_SESSION['admin_message'])) {

    echo "<div class='admin-message'>" .
         adminEscape($_SESSION['admin_message']) .
         "</div>";

    unset($_SESSION['admin_message']);
}

if (!isset($_GET['id'])) {

    // Show all products, newest first
    $conn = makePDOConn();

    $statement = $conn->query(
        "SELECT * FROM products
         ORDER BY date_create DESC, id DESC"
    );

    $products = $statement->fetchAll();

           echo "<h1>Product List</h1>";

echo "<p class='small-note'>" .
     count($products) .
     " products in your store</p>";

echo "<div class='admin-product-grid'>";

echo array_reduce(
    $products,
    function($result, $product) {
        return $result . productListItem($product);
    },
    ""
);

echo "</div>";

        } elseif ($_GET['id'] === 'new') {

            // Create an empty product
            $product = [
                'id' => '',
                'name' => '',
                'price' => '',
                'category' => '',
                'url' => '',
                'description' => '',
                'thumbnail' => '',
                'images' => ''
            ];

            echo showProductPage($product);

        } else {

            // Find an individual product
            $products = getProducts();
            $id = (int)$_GET['id'];
            $selectedProduct = null;

            foreach ($products as $product) {
                if ((int)$product['id'] === $id) {
                    $selectedProduct = $product;
                    break;
                }
            }

            if ($selectedProduct !== null) {
                echo showProductPage($selectedProduct);
            } else {
                echo "<p>Product not found.</p>";
            }

        }

        ?>

    </main>

</body>
</html>
