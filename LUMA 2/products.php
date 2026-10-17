<?php include "data.php"; ?>
<?php $category = $_GET["category"] ?? "All"; ?>
<?php include "parts/head.php"; ?>
<?php include "parts/header.php"; ?>
<main class="container section">
  <span class="eyebrow">THE LUMA COLLECTION</span><h1>Shop Plants</h1><p>Find your perfect green companion.</p>
  <div class="shop-layout">
    <aside class="filter-card"><h3>Categories</h3>
      <a href="products.php">All Plants</a>
      <a href="products.php?category=Low+Light">Low Light</a>
      <a href="products.php?category=Easy+Care">Easy Care</a>
      <a href="products.php?category=Small+Space">Small Space</a>
      <a href="products.php?category=Pet+Friendly">Pet Friendly</a>
    </aside>
    <div class="shop-content"><div class="shop-banner">A little green goes a long way.</div><p class="eyebrow">SHOWING: <?php echo htmlspecialchars($category); ?></p>
      <div class="product-grid">
        <?php foreach ($products as $id => $plant) { ?>
          <?php if ($category == "All" || $plant["category"] == $category) { include "parts/product-card.php"; } ?>
        <?php } ?>
      </div>
      <p class="small-note">Some categories are placeholders for future products.</p>
    </div>
  </div>
</main>
<?php include "parts/footer.php"; ?>
