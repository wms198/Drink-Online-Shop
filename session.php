<?php
session_start();
$user_id = 0;
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  error_log("User logged in: " . $user_id);
} else {
  error_log("unknown user: " . $user_id . " - " . session_id());
}
