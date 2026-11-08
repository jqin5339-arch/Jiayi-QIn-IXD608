
<?php
require_once __DIR__ . "/db.php";

$products = getProducts();

$category = $_GET["category"] ?? "All";
?>


<?php include "parts/head.php"; ?>
<?php include "parts/header.php"; ?>
<main class="container section">
  <span class="eyebrow">THE LUMA COLLECTION</span><h1>Shop Plants</h1><p>Find your perfect green companion.</p>
  <div class="shop-layout">
    <aside class="filter-card"><h3>Categories</h3>
      
<a href="products.php">All Plants</a>
<a href="products.php?category=Indoor">Indoor</a>
<a href="products.php?category=Hanging">Hanging</a>
<a href="products.php?category=Low%20Light">Low Light</a>
<a href="products.php?category=Statement">Statement</a>
<a href="products.php?category=Succulent">Succulent</a>

    </aside>
    <div class="shop-content"><div class="shop-banner">A little green goes a long way.</div><p class="eyebrow">SHOWING: <?php echo htmlspecialchars($category); ?></p>
      <div class="product-grid">
        
<?php foreach ($products as $plant) { ?>
    <?php
    $id = $plant["id"];

    if ($category == "All" || $plant["category"] == $category) {
        include "parts/product-card.php";
    }
    ?>
<?php } ?>

      </div>
      <p class="small-note">Some categories are placeholders for future products.</p>
    </div>
  </div>
</main>
<?php include "parts/footer.php"; ?>
