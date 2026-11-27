<article class="product-card">
  <a class="product-image"
     href="product.php?id=<?php echo (int)$id; ?>"
     aria-label="View <?php echo htmlspecialchars($plant['name']); ?>">
<?php
$image = basename($plant['thumbnail'] ?? '');
?>

<?php if ($image !== '') { ?>
  <img
    src="images/<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>?v=4"
    alt="<?php echo htmlspecialchars($plant['name'], ENT_QUOTES, 'UTF-8'); ?>"
    class="plant-photo"
  >
<?php } ?>



    <span class="more-details">MORE DETAILS</span>
  </a>

  <h3>
    <?php echo htmlspecialchars($plant['name']); ?>
  </h3>

  <p class="product-price">
    $<?php echo number_format((float)$plant['price'], 2); ?>
  </p>

  <span class="care-badge">
    <?php echo htmlspecialchars($plant['category']); ?>
  </span>
</article>
