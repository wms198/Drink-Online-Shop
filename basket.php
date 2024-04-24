<?php
$title = "Product";
include('session.php');
include('db.php');
include('head.php');
include('top.php');
?>

<div>
  <h2 class="center-text product-header text-color text-font-family ">Your Cart</h2>
</div>
<div class="cart">
<div class="itemsDetailContainer">
  <?php
  $basket = get_or_create_basket($conn, $user_id);
  foreach ($basket['items'] as $product) {
  ?>
    <div class="itemsDetailImagin" id="product_<?= $product['id'] ?>">
      <div>
        <a href="product.php?id=<?= $product['id'] ?>">
          <?= get_img($product) ?>
        </a>
      </div>
      <div class="itemsDetailProduct text-font-family text-color" >
        <div>
          <div class="name">
            <a class="no-link-style" style="<?= $product['splashStyle'] ?> href="product.php?id=<?= $product['id'] ?>"><?= $product['productName'] ?></a>
          </div>
          <div class="itemsDetailProductDetails text-font-family ">
            <div>$ <?= $product['price'] ?></div>
            
            <div class="itemsDetailAmount">
              <input id="amount_product_<?= $product['id'] ?>" value="<?= $product['amount'] ?>"  style="<?= $product['splashStyle'] ?>" onchange="update_amount(<?= $product['id'] ?>)">
            </div>
            
            <div>$ <span id="amount_product_total_<?= $product['id'] ?>"><?= $product['totalPrice'] ?></span></div>
            
            <div>
              <span class="material-symbols-outlined" onclick="remove_item(<?= $product['id'] ?>)">
                delete
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }
  ?>

</div>
  <div class="itemsDetailCheckoutContainer">
    <div>
      <div class="text-color-green text-font-family font-size ">
        Subtotal
      </div>
      <div class="text-color text-font-family" >
        $ <span id="totalPrice"><?= number_format($basket['total_price'], 2) ?></span>
      </div>
    </div>
    <hr class="line">
    <span class="text-color text-font-family font-size">Once an order has been placed,<br class="text-color">we cannot cancel or make any changes to the shipping address.</span>
    <div class="itemsDetailCheckoutBar text-font-family ">
      <a href="addAddress.php" class="itemsDetailCheckout">Checkout</a>
      <a href="index.php" class="cotinueShopping">Continue Shopping</a>
    </div>
</div>
<?php include('footer.php') ?>