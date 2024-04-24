<?php
$title = "Login";
include('session.php');
include('db.php');
include('head.php');
//include('top.php');
//header("Location: https://www.google.de");
/*if(isset($_SESSION['user_id'])){
  echo $_SESSION['user_id'];
  echo "ok";
  header("Location: index.php");
}*/


$credentials_correct = true;
$passwords_match = true;



if ($_POST['action'] == 'login') {
  $user_id = login($conn, $_POST['email'], $_POST['password']);
  if ($user_id != 0) {
    header("Location: index.php");
  } else {
    $credentials_correct = false;
  }
} else if ($_POST['action'] == 'signup') {
  if (isset($_POST['password1']) && $_POST['password1'] == $_POST['password2']) {
    $user_id = sign_up($conn, $_POST['email'], $_POST['password1']);
    if ($user_id != 0) {
     header("Location: basket.php");
    } else {
      die("something bad look at logs");
    }
  } else {
    $passwords_match = false;
  }
}
$message = array(
  "Your password is wrong, please try again.",
  "You really dont remember?",
  "Just give up."
);
include('top.php');

if($credentials_correct == false || $passwords_match == false){
  $_SESSION['wrong_pw'] = intval($_SESSION['wrong_pw']) + 1;
}
if($_SESSION['wrong_pw'] > 3){
  $_SESSION['wrong_pw'] = 3;
}
?>
<h1  class="center-text product-header text-color text-font-family">Hello!</h1>

<div class="singupContainer">
  <div>
    <h2 class="text-color text-font-family">Login</h2>
    <form method="post" action="">
      <input hidden name="action" value="login" class="text-font-family">
      <input type="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?>" class="text-font-family text-color-darkgreen">
      <input type="password" name="password" placeholder="Password" class="text-font-family text-color-darkgreen">
      <div>
        <?php if (!$credentials_correct) ?>
        <button class="text-font-family">Login</button>
        <!--<a href="" class="no-link-style text-font-family">
          Forgot Password?-->
        </a>
      </div>
    </form>
  </div>
  <div class="border text-color"></div>
  <div>
    <h2 class="text-color text-font-family">Create an account</h2>
    <form method="post" action="">

      <input hidden name="action" value="signup">
      <div>
        <input type="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?>" class="text-font-family text-color-peachfuzz">
      </div>
      <div>
        <input type="password" name="password1" placeholder="Password" class="text-font-family text-color-darkgreen">
      </div>
      <div>
        <input type="password" name="password2" placeholder="Password repeat" class="text-font-family text-color-darkgreen">
      </div>
      <div>
        <button type="submit" class="text-font-family" >Sign Up</button>
      </div>
    </form>
  </div>
</div>
</div>
<div class="overlay" id="password-error">
  <div class="warningContainer">
    <div id="error-box" class="">
      <div style="margin-block: 26px"></div>
        <span id="error-message" class="text-font-family "><?php echo $message[$_SESSION['wrong_pw'] - 1]?></span>

        <button onclick="toggle_signup_error()" class="text-font-family">Got it</button>
    </div>
  </div>
</div>

<script>

function toggle_signup_error() {
  let alter = document.getElementById("password-error");
  alter.classList.toggle("show");
}
<?php 
if($credentials_correct == false || $passwords_match == false){
  echo 'const myTimeout = setTimeout(toggle_signup_error, 500);';
} 
?>
</script>
<?php include('footer.php') ?>