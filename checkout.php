<?php
$title = "Checkout";
include('session.php');
include('db.php');
include('head.php');
if ($user_id == 0) {
  header("Location: signup.php");
} else {
  $result = make_basket_final($conn, $user_id);
}
include('top.php');

?>

<div>
  <h2 class="center-text text-font-family text-color">Thank you for your purchase.</h2>
  <!--<a href="logout.php" class="center-text checkOut text-font-family">Logout</a>-->

</div>

<?php include('footer.php') ?>