
<?php
require_once __DIR__ . "/db.php";

// Sample cart for Module 10
$cartIds = [1, 2];
$cart = [];

foreach (getProducts() as $product) {
    if (in_array((int)$product["id"], $cartIds, true)) {
        $cart[] = $product;
    }
}

$subtotal = 0;

foreach ($cart as $product) {
    $subtotal += (float)$product["price"];
}

$shipping = 10;
$total = $subtotal + $shipping;
?>

<?php include "parts/head.php"; ?>
<?php include "parts/header.php"; ?>

<main class="container section">

    <h1>Your Cart</h1>

    <p class="small-note">
        Sample cart for page navigation practice.
    </p>

    <div class="cart-layout">

        <div class="cart-items">

            <div class="cart-head">
                <span>Item</span>
                <span>Price</span>
                <span>Quantity</span>
                <span>Total</span>
            </div>

            <?php foreach ($cart as $product) { ?>

                <div class="cart-row">

                    <div class="cart-product">
                        <div class="mini-image"></div>

                        <strong>
                            <?php echo htmlspecialchars($product["name"]); ?>
                        </strong>
                    </div>

                    <span>
                        $<?php echo number_format((float)$product["price"], 2); ?>
                    </span>

                    <span>1</span>

                    <span>
                        $<?php echo number_format((float)$product["price"], 2); ?>
                    </span>

                </div>

            <?php } ?>

            <a class="text-link" href="products.php">
                ← Continue shopping
            </a>

        </div>

        <aside class="summary">

            <h3>Order Summary</h3>

            <p><?php echo count($cart); ?> sample items</p>

            <div class="summary-line">
                <span>Subtotal</span>
                <strong>
                    $<?php echo number_format($subtotal, 2); ?>
                </strong>
            </div>

            <div class="summary-line">
                <span>Shipping</span>
                <span>
                    $<?php echo number_format($shipping, 2); ?>
                </span>
            </div>

            <div class="summary-line total">
                <span>Total</span>
                <strong>
                    $<?php echo number_format($total, 2); ?>
                </strong>
            </div>

            <a class="btn btn-primary full" href="checkout.php">
                CHECKOUT
            </a>

        </aside>

    </div>

</main>

<?php include "parts/footer.php"; ?>
