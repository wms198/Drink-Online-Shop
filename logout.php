<?php
include('session.php');
include('db.php');
session_destroy();
header('Location: index.php');
