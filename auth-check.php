<?php
session_start();

// If admin is not logged in → redirect
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit();
}

// If admin is flagged for forced logout
if (isset($_SESSION['force_logout']) && $_SESSION['force_logout'] === true) {
  session_unset();
  session_destroy();
  header("Location: admin-login.php?session_expired=1");
  exit();
}
?>
