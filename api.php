<?php
include('session.php');
include('db.php');
header("Content-Type: application/json");

// https://stackoverflow.com/a/24468752

// encode: object/array/thing -> string
// decode: string -> object/array/thing

$data = json_decode(file_get_contents('php://input'), true);
error_log("api data: " . json_encode($data));
$op =  $data["operation"];

if ($op == "addToCart") {
  $basket = add_to_cart($conn, $user_id, $data['id'], $data['amount'], $data['is_total']);
  //json_encode($basket):turn $basket (=array) into a string
  echo json_encode($basket);
} else if ($op == "getBasket") {
  echo json_encode(get_or_create_basket($conn, $user_id));
} else if ($op == "removeFromCart") {
  die("not implemented!");
}
