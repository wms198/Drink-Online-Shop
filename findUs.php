<?php
$title = "Findus";
include('session.php');
include('db.php');
include('head.php');
include('top.php');
?>

<body>
  <div class="center-text">
    <h1 style="color: white;
    font-family: Marhey;">Find us here</h1>
  </div>

  <div class="center-text" id="floating-panel">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24910.03878488757!2d-73.99382511699733!3d40.73527609323209!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259aeadd618df%3A0xdb28329e297402af!2sMacy&#39;s!5e1!3m2!1sen!2sde!4v1704800631414!5m2!1sen!2sde" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" id="map" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>


  <?php include('footer.php') ?>