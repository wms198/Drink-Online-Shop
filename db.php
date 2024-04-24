<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drink";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
error_log("DB connected");

function add_to_cart($conn, $user_id, $prodcutId, $amount, $is_total = false)
{
  //$id=orderId
  //$basket = array('id' => 0, 'items' => array(), 'total_items' => 0, 'total_price' => 0);
  $b = get_or_create_basket($conn, $user_id);
  if ($amount != 0) {
    $new_item = true;
    foreach ($b['items'] as $i) {
      if ($prodcutId == $i['id']) {
        $new_amount= $amount + $i["amount"];
        if($is_total){
          $new_amount= $amount;
        }
        $new_item = false;
        $sql = "UPDATE `OrderDetail` SET amount = " . $new_amount . " WHERE orderId = " . $b['id'] . " and productId = " . $i['id'];
        error_log($sql);
        $result = $conn->query($sql);
      }
    }
    if ($new_item) {
      $sql = "INSERT INTO `OrderDetail` (orderId, productId, amount) VALUES (" . $b['id'] . "," . $prodcutId . "," . $amount . ")";
      $result =  $conn->query($sql);
    }
  } else if($is_total) {
    $sql = "DELETE FROM `OrderDetail` WHERE orderId = " . $b['id'] . " and productId = " . $prodcutId;
    error_log($sql);
    $result = $conn->query($sql);
  }
  $b = get_or_create_basket($conn, $user_id);
  return $b;
}


function get_or_create_basket($conn, $user_id)
{
  $basket = array('id' => 0, 'items' => array(), 'total_items' => 0, 'total_price' => 0);

  if ($user_id == 0) {
    $sql = "SELECT id FROM `Order` where userId is null and sessionId ='" . session_id() . "'"; // not logged in
  } else {
    $sql = "SELECT id FROM `Order` where orderDate is null and userId =" . $user_id; // logged in
  }
  //echo $sql;
  $result = $conn->query($sql);
  if ($result->num_rows == 0) {
    $basket_id = create_basket($conn, $user_id);
    $basket['id'] = $basket_id;
    return $basket;
  }
  $basket['id'] = $result->fetch_assoc()['id'];
  $sql = "SELECT d.amount, p.* , d.amount * p.price as totalPrice FROM OrderDetail as d join Product as p on d.productId = p.id where d.orderId =" . $basket['id'];
  $result = $conn->query($sql);

  while ($i = $result->fetch_assoc()) {

    array_push($basket['items'], $i);
    $basket['total_items'] += $i['amount'];
    $basket['total_price'] += $i['totalPrice'];
  }
  return $basket;
}

function create_basket($conn, $user_id)
{
  if ($user_id == 0) {
    $sql = "INSERT INTO `Order` (sessionId) VALUES ('" . session_id() . "')";
  } else {
    $sql = "INSERT INTO `Order` (userId, sessionId) VALUES (" . $user_id . ",  '" . session_id() . "')";
  }
  if ($conn->query($sql) === TRUE) {
    return $conn->insert_id;
  } else {
    error_log("Error: " . $sql . "\n" . $conn->error);
  }
}

function sign_up($conn, $email, $password)
{
  $pw_hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO `User` (email, password) VALUES ('" . $email . "', '" . $pw_hash . "')";

  if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['wrong_pw'] = 0;
    merge_baskets($conn, $user_id);
    return $user_id;
  } else {
    error_log("Error: " . $sql . "\n" . $conn->error);
    return 0;
  }
}

function login($conn, $email, $password)
{
  $sql = "SELECT id, firstName, password from `User` where email = '" . $email . "'";
  $result = $conn->query($sql);
  if ($result->num_rows == 0) {
    return 0;
  }
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = intval($user['id']);
    $_SESSION['firstName'] = $user['firstName'];
    $_SESSION['user_is_logged_id'] = true;
    $_SESSION['wrong_pw'] = 0;
    merge_baskets($conn, $user['id']);
    return $user['id'];
  } else {
    return 0;
  }
}

function merge_baskets($conn, $user_id){
  $basket_not_logged_in = get_or_create_basket($conn, 0);
  foreach($basket_not_logged_in['items'] as $i){
    #error_log("Adding: " . $i['id'] . " - ". $i['amount']. " for basket: ". $basket_of_logged_in_user['id']);
    add_to_cart($conn, $user_id, $i['id'], $i['amount']);
  };
  clear_basket($conn, $basket_not_logged_in['id']);
}

function clear_basket($conn, $basket_id){
  $sql = "DELETE FROM `OrderDetail` WHERE orderId = " . $basket_id;
  error_log($sql);
  $conn->query($sql);
}

function user_info($conn, $user_id, $firstName, $lastName, $company, $street, $city, $country, $postcode, $telefone)
{
  $sql = "update `User` set firstName = '" . $firstName .
    "', lastName = '" . $lastName .
    "', company = '" . $company .
    "', street = '" . $street .
    "', city = '" . $city .
    "', country = '" . $country .
    "', postcode = '" . $postcode .
    "', telefone = '" . $telefone .
    "' where id = " . $user_id;
  echo $sql;
  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    error_log("Error: " . $sql . "\n" . $conn->error);
    return false;
  }
}

function get_user_info($conn, $user_id){
  $sql="SELECT * FROM `User` where id =" .$user_id;
  $info = $conn->query($sql);
  if ($info->num_rows != 0){
    return $info->fetch_assoc(); 
  }
  if($info->num_rows == 0){
    echo "Please sign up first.";  
  }
}




function get_img_src($p)
{
  return "media/product/DRINK/" . $p['image'];
}

function get_img($p)
{
  return '<img class="product-image" src="' . get_img_src($p) . '" alt="' . $p['productName'] . '">';
}


function make_basket_final($conn, $user_id)
{
  $basket = get_or_create_basket($conn, $user_id);
  $sql = "UPDATE `order`
          SET orderDate = NOW()
          WHERE id = " . $basket["id"];
  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    error_log("Error: " . $sql . "\n" . $conn->error);
    return false;
  }
}

function NOT_USED_total_amount_update($conn, $user_id, $amount)
{

  $basket = array('id' => 0, 'total_amount' => 0);
  if ($user_id != 0) {
    $sql = "SELECT id FROM `Order` where userId =" . $user_id;
  }
  $result = $conn->query($sql);
  $basket['id'] = $result->fetch_assoc()['id'];


  $sql = "SELECT d.orderId, d.amount from orderDetail as d inner join product as p on d.productId = p.id where d.orderId =" . $basket['id'];
  $result = $conn->query($sql);

  while ($i = $result->fetch_assoc()) {
    $basket['total_amount'] += $i['amount'];
  }
  return $basket['total_amount'];
}
