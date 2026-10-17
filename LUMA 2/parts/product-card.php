<article class="product-card">
  <a class="product-image" href="product.php?id=<?php echo $id; ?>" aria-label="View <?php echo htmlspecialchars($plant['name']); ?>">
    <span class="more-details">MORE DETAILS</span>
  </a>
  <h3><?php echo htmlspecialchars($plant['name']); ?></h3>
  <p class="product-price">$<?php echo $plant['price']; ?></p>
  <span class="care-badge"><?php echo htmlspecialchars($plant['care']); ?></span>
</article>
