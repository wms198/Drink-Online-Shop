<body>
  <div class="menu-container" id="menu-container" onclick="toggleMenu()">
    <div class="left"></div>
      <div class="right">    
        <ul id="right_menu">
          <li class="link" ><a class="link1 text-font-family" href="index.php">Homepage</a></li>
          <li class="link"><a class="link1 text-font-family" href="basket.php">Basket</a></li>
          <li class="link"><a class="link1 text-font-family" href="findUs.php">Find Us</a></li>
        </ul>
      </div>
    </div>

    <div id="header" class="">
     <!-- <img class="bg-image" src="media/pinkbubble.jpg">-->
      <div class="burger-wrapper">
        <div class="menu" id="burger" onclick="toggleMenu()">
          <div></div><div></div></div>
      </div>
      <div class="logo"><a href="index.php" class="">Spindrift</a></div>
      <div class="flex login-basket">
      <div>
  
      
    <?php
    //echo "basket id: ".get_or_create_basket($conn, $user_id)['id'];
    if ($user_id == 0) {
    ?>
      <a href="signup.php" >
        <span class="material-symbols-outlined">
          login
        </span>
      </a>
    <?php
    } else {
    ?>
      <a href="logout.php">
        <span class="material-symbols-outlined">
          logout
        </span>
      </a>
    <?php
    }
    ?>
    
    </div>
    <div>
      <a href="basket.php">
        <span class="material-symbols-outlined">
          add_shopping_cart
        </span>
        <span id="totalAmount"></span>
      </a>
    </div>
  </div>
  
</div>
<p     style="color: #579c7c;
    text-align: center;
    font-family: Marhey;
    font-size: 20px;
">just sparkling water & real squezzed fruit</p>