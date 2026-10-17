<?php include "data.php"; ?>
<?php
$id = (int) ($_GET["id"] ?? 1);
$plant = $products[$id] ?? null;
?>
<?php include "parts/head.php"; ?>
<?php include "parts/header.php"; ?>
<main class="container section">
  <p class="breadcrumbs"><a href="index.php">Home</a> &gt; <a href="products.php">Shop Plants</a> &gt; Product Detail</p>
  <?php if ($plant) { ?>
    <div class="detail-layout">
      <div class="detail-gallery"><div class="thumbs"><div></div><div></div><div></div></div><div class="detail-image"></div></div>
      <div class="detail-info"><span class="eyebrow">LUMA COLLECTION</span><h1><?php echo htmlspecialchars($plant["name"]); ?></h1><p class="stars">☆☆☆☆☆</p><p class="detail-price">$<?php echo $plant["price"]; ?></p>
        <p>A beautiful plant to bring a little green into your everyday space.</p>
        <div class="info-box"><p><strong>Light:</strong> <?php echo htmlspecialchars($plant["light"]); ?></p><p><strong>Water:</strong> <?php echo htmlspecialchars($plant["water"]); ?></p><p><strong>Care:</strong> <?php echo htmlspecialchars($plant["care"]); ?></p></div>
        <label for="quantity">Quantity</label><input class="quantity" id="quantity" type="number" value="1" min="1">
        <div class="button-row"><a class="btn btn-secondary" href="products.php">BACK TO SHOP</a><a class="btn btn-primary" href="cart.php">VIEW SAMPLE CART</a></div>
        <p class="small-note">Cart is a visual sample for this assignment.</p>
      </div>
    </div>
  <?php } else { ?><h1>Plant not found</h1><a class="btn btn-primary" href="products.php">BACK TO SHOP</a><?php } ?>
</main>
<?php include "parts/footer.php"; ?>
