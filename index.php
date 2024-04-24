  <?php
  $title = "Drinks";
  include('session.php');
  include('db.php');
  include('head.php');
  include('top.php');
  ?>

  <!--<img src="media/pinkbubble.jpg" alt="homepageHero" class="homepageHero">-->
  <div class="body">
    <div id="content">
      <div class="products">

        <?php
        $sql = "SELECT * FROM Product";
        $result = $conn->query($sql);


        if ($result->num_rows != 0) {
          // output data of each row
          while ($product = $result->fetch_assoc()) {
        ?>
            <div class="product">
              <h4 style="<?= $product['splashStyle'] ?>" class="text-font-family "><?= $product['productName'] ?></h4>
              <div class="splash-wrapper">
                <img src="media/splash-black.svg" class="splash" style="<?= $product['splashStyle'] ?>">
              </div>
              <a href="product.php?id=<?= $product['id'] ?>">
                <?= get_img($product) ?>
              </a>
            </div>
        <?php
          }
        } else {
          echo "No products in DB";
        }
        ?>
      </div>
    </div>
  </div>

  <!--<ul id="menu">
      <li class="link"><a href="basket.php">Basket</a></li>
      <li class="link"><a href="findUs.php">Find Us</a></li>
    </ul>-->

  <?php include('footer.php') ?>