<?php
require_once __DIR__ . "/lib/php/functions.php";
initSession();
if (isset($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    $removeStyle = $_GET['potStyle'] ?? 'Ceramic';
    
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], function($item) use ($removeId, $removeStyle) {
            return !($item->id == $removeId && $item->potStyle == $removeStyle);
        }));
    }
  session_write_close();
header('Location: cart.php?v=' . time(), true, 303);
exit;
}

// 2. 从数据库获取商品并建立关联索引
$allProducts = getProducts();
$productsAssoc = [];
foreach ($allProducts as $p) {
    $productsAssoc[(int)$p['id']] = $p;
}

// 3. 获取购物车中的对象数组
$cartItems = getCart();

$subtotal = 0;
$totalItems = 0;
$displayCart = [];

foreach ($cartItems as $cartItem) {
    $pid = (int)$cartItem->id;
    
    if (isset($productsAssoc[$pid])) {
        $product = $productsAssoc[$pid];
        $qty = (int)$cartItem->amount;
        $price = (float)$product['price'];
        $itemSubtotal = $price * $qty;

        $product['quantity'] = $qty;
        $product['potStyle'] = $cartItem->potStyle;
        $product['subtotal'] = $itemSubtotal;

        $subtotal += $itemSubtotal;
        $totalItems += $qty;
        $displayCart[] = $product;
    }
}

// 有商品时运费 $10.00，空购物车时 $0.00
$shipping = count($displayCart) > 0 ? 10.00 : 0.00;
$total = $subtotal + $shipping;
?>

<?php include "parts/head.php"; ?>
<!-- CART_VERSION_1127_V2 -->
<?php include "parts/header.php"; ?>

<main class="container section">

    <h1>Your Cart</h1>

    <p class="small-note">
        Review your selected plants and pot styles.
    </p>

    <div class="cart-layout">

        <div class="cart-items">

            <div class="cart-head">
                <span>Item</span>
                <span>Price</span>
                <span>Quantity</span>
                <span>Total</span>
            </div>

            <?php if (empty($displayCart)) { ?>
                <div class="cart-row">
                    <p>Your cart is currently empty.</p>
                </div>
            <?php } else { ?>
                <?php foreach ($displayCart as $product) { ?>
                    <div class="cart-row">

                        <div class="cart-product">
                            <div class="mini-image"></div>
                            <div>
                                <strong>
                                    <?php echo htmlspecialchars($product["name"]); ?>
                                </strong>
                                <br>
                                <span class="small-note">Style: <?php echo htmlspecialchars($product["potStyle"]); ?></span>
                                <br>
                                <a href="cart.php?remove=<?php echo (int)$product['id']; ?>&potStyle=<?php echo urlencode($product['potStyle']); ?>" class="small-note" style="color: #999; text-decoration: underline;">
                                    Remove
                                </a>
                            </div>
                        </div>

                        <span>
                            $<?php echo number_format((float)$product["price"], 2); ?>
                        </span>

                        <span>
                            <?php echo (int)$product["quantity"]; ?>
                        </span>

                        <span>
                            $<?php echo number_format((float)$product["subtotal"], 2); ?>
                        </span>

                    </div>
                <?php } ?>
            <?php } ?>

            <a class="text-link" href="products.php">
                ← Continue shopping
            </a>

        </div>

        <aside class="summary">

            <h3>Order Summary</h3>

            <p><?php echo $totalItems; ?> <?php echo $totalItems === 1 ? 'item' : 'items'; ?></p>

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

            <?php if (!empty($displayCart)) { ?>
                <a class="btn btn-primary full" href="checkout.php">
                    CHECKOUT
                </a>
            <?php } ?>

        </aside>

    </div>

</main>

<?php include "parts/footer.php"; ?>
