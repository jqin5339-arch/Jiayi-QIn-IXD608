<?php include "parts/head.php"; ?>
<?php include "parts/header.php"; ?>
<main class="container section"><h1>Checkout</h1><div class="steps"><strong>① Shipping</strong><span>→</span><span>② Payment</span><span>→</span><span>③ Review</span></div>
  <div class="checkout-layout"><section class="panel"><h3>Shipping Information</h3><form action="confirmation.php" method="get">
    <label for="full-name">Full Name</label><input id="full-name" name="name" type="text" placeholder="Your name" required>
    <label for="address">Address</label><input id="address" type="text" placeholder="Street address" required>
    <div class="form-columns"><div><label for="city">City</label><input id="city" type="text" required></div><div><label for="state">State</label><input id="state" type="text" required></div><div><label for="zip">ZIP Code</label><input id="zip" type="text" required></div></div>
    <p class="small-note">Classroom demo only. Do not enter real personal or payment details.</p><button class="btn btn-primary" type="submit">REVIEW SAMPLE ORDER →</button>
  </form></section><aside class="summary"><h3>Order Summary</h3><div class="cart-product"><div class="mini-image"></div><strong>Sample plant order</strong></div><div class="summary-line"><span>Subtotal</span><strong>$88.00</strong></div><div class="summary-line"><span>Shipping</span><span>$10.00</span></div><div class="summary-line total"><span>Total</span><strong>$98.00</strong></div></aside></div>
</main>
<?php include "parts/footer.php"; ?>
