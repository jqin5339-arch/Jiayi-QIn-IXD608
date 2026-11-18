<?php
require_once __DIR__ . "/db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$plant = null;

if ($id !== null && $id !== false && $id > 0) {
    foreach (getProducts() as $product) {
        if ((int)$product["id"] === $id) {
            $plant = $product;
            break;
        }
    }
}
?>

<?php include "parts/head.php"; ?>
<?php include "parts/header.php"; ?>

<main class="container section">

  <p class="breadcrumbs">
    <a href="index.php">Home</a> &gt;
    <a href="products.php">Shop Plants</a> &gt;
    Product Detail
  </p>

  <?php if ($plant) { ?>

    <div class="detail-layout">

<div class="detail-gallery">
  <?php
    // Multiple image filenames separated by commas
    $images = array_values(array_filter(array_map(
      function ($filename) {
        return basename(trim($filename));
      },
      explode(",", $plant["images"] ?? "")
    )));
  ?>

  <div class="detail-image" id="plant-gallery"
       data-images="<?php echo htmlspecialchars(json_encode($images), ENT_QUOTES, 'UTF-8'); ?>">

    <?php if (count($images) > 0) { ?>
      <img
        id="main-plant-photo"
        src="images/<?php echo rawurlencode($images[0]); ?>"
        alt="<?php echo htmlspecialchars($plant["name"], ENT_QUOTES, 'UTF-8'); ?>"
        class="detail-photo"
      >
    <?php } ?>

    <?php if (count($images) > 1) { ?>
      <button type="button" class="gallery-arrow gallery-prev"
              id="gallery-prev" aria-label="Previous photo">
        &#10094;
      </button>

      <button type="button" class="gallery-arrow gallery-next"
              id="gallery-next" aria-label="Next photo">
        &#10095;
      </button>

      <span class="gallery-count" id="gallery-count"></span>
    <?php } ?>

  </div>
</div>

<script>
(function () {
  const gallery = document.getElementById("plant-gallery");
  const photo = document.getElementById("main-plant-photo");
  if (!gallery || !photo) return;

  const images = JSON.parse(gallery.dataset.images || "[]");
  if (images.length <= 1) return;

  let current = 0;
  const counter = document.getElementById("gallery-count");

  function showPhoto(index) {
    current = (index + images.length) % images.length;
    photo.src = "images/" + encodeURIComponent(images[current]);
    counter.textContent = (current + 1) + " / " + images.length;
  }

  document.getElementById("gallery-next")
    .addEventListener("click", () => showPhoto(current + 1));

  document.getElementById("gallery-prev")
    .addEventListener("click", () => showPhoto(current - 1));

  showPhoto(0);
})();
</script>


      <div class="detail-info">

        <span class="eyebrow">LUMA COLLECTION</span>

        <h1>
          <?php echo htmlspecialchars($plant["name"]); ?>
        </h1>

        <p class="stars">☆☆☆☆☆</p>

        <p class="detail-price">
          $<?php echo number_format((float)$plant["price"], 2); ?>
        </p>

        <p>
          <?php echo htmlspecialchars($plant["description"]); ?>
        </p>

        <div class="info-box">
          <p>
            <strong>Category:</strong>
            <?php echo htmlspecialchars($plant["category"]); ?>
          </p>
          <p>
            <strong>Product ID:</strong>
            <?php echo (int)$plant["id"]; ?>
          </p>
        </div>

        <!-- 提交给 cart_actions.php 处理的表单 -->
        <form action="cart_actions.php" method="POST">
          <input type="hidden" name="action" value="add-to-cart">
          <input type="hidden" name="product-id" value="<?php echo (int)$plant["id"]; ?>">
          <input type="hidden" name="product-pot-style" value="Ceramic">

          <label for="quantity">Quantity</label>
          <input
            class="quantity"
            id="quantity"
            name="product-amount"
            type="number"
            value="1"
            min="1"
          >

          <div class="button-row">
            <a class="btn btn-secondary" href="products.php">
              BACK TO SHOP
            </a>

            <button type="submit" class="btn btn-primary">
              ADD TO CART
            </button>
          </div>
        </form>

        <p class="small-note">
          Cart is a visual sample for this assignment.
        </p>

      </div>
    </div>

  <?php } else { ?>

    <h1>Plant not found</h1>

    <a class="btn btn-primary" href="products.php">
      BACK TO SHOP
    </a>

  <?php } ?>

</main>

<?php include "parts/footer.php"; ?>
