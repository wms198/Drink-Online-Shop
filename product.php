<?php
$title = "Product";
include('session.php');
include('db.php');
include('head.php');
include('top.php');
?>

  <?php
  $sql = "SELECT * FROM Product where id = " . $_GET['id'] . " LIMIT 1";
  $result = $conn->query($sql);
  $product = $result->fetch_assoc();

  ?>
  <h3 class="center-text product-header text-font-family text-color-black" style="<?= $product['splashStyle'] ?>"><?= $product['productName'] ?></h3>

  <div id="content">
    <div class="product">
    <?= get_img($product) ?>
    <p></p>
  </div>

  <div class="productRight">
    <h4 class="text-font-family text-color font-size"><?= $product["ingredient"] ?></h4>
    <h4 class="text-font-family text-color font-size">$ <?= $product["price"] ?></h4>
    <div class="containerCart">
      <div class="quantityBar">
        <span class="product-hero_minus amount-modifier" onclick="decrease_item()">
          <span class="material-symbols-outlined text-color">arrow_left</span>
        </span>
        <input value="1" id="amount" name="amount" class="textCenter text-color text-font-family">
        <input type="number" value="<?= $product['id'] ?>" id="productId" style="display:none">
        <span class="product-hero_plus amount-modifier" onclick="increase_item()">
          <span class="material-symbols-outlined text-color">arrow_right</span>
        </span>
      </div>
      <button id="add" name="add" type="submit" class="productBtn black-outline" onclick="add_to_cart()">
        <span class="text-color text-font-family" >Add to Cart</span>
      </button>
    </div>
  </div>
</div>

<div class="commentContainer">
  <div class="commentTitle">
    <h2 class="text-color text-font-family" style="font-size: 30PX">We guess you'll also love</h2>
  </div>
  <div class="commentHero products">
    <?php
    $sql = "SELECT * FROM `Product` ORDER BY rand() LIMIT 2";
    $result = $conn->query($sql);
    $p = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $product1 = $p[0];
    $product2 = $p[1];
    ?>
    <div class="product">
      <div class="splash-wrapper">

        <img src="media/splash-black.svg" class="splash" style="<?= $product1['splashStyle'] ?>">
      </div>
      <a href="product.php?id=<?= $product1['id'] ?>">
        <?= get_img($product1) ?>
      </a>
    </div>

    <div class="product">
      <div class="splash-wrapper">
        <img src="media/splash-black.svg" class="splash" style="<?= $product2['splashStyle'] ?>">
      </div>
      <a href="product.php?id=<?= $product2['id'] ?>">
        <?= get_img($product2) ?>
      </a>
    </div>
  </div>
</div>

<?php include('footer.php') ?>