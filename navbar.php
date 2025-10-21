<?php
// navbar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav>
  <div class="nav-left">
    <a href="index.php">
      <img src="img/logo1.png" alt="BottleSort" class="nav-logo">
    </a>
  </div>

  <div class="nav-center">
    <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
      <img src="img/home.png" class="nav-icon" alt=""> Home
    </a>
    <a href="about.php" class="<?= $current_page == 'about.php' ? 'active' : '' ?>">
      <img src="img/about.png" class="nav-icon" alt=""> About
    </a>
    <a href="analytics.php" class="<?= $current_page == 'analytics.php' ? 'active' : '' ?>">
      <img src="img/analytics.png" class="nav-icon" alt=""> Analytics
    </a>
    <a href="prototype.php" class="<?= $current_page == 'prototype.php' ? 'active' : '' ?>">
      <img src="img/prototype.png" class="nav-icon" alt=""> System
    </a>
    <a href="team.php" class="<?= $current_page == 'team.php' ? 'active' : '' ?>">
      <img src="img/team.png" class="nav-icon" alt=""> Team
    </a>
    <a href="contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">
      <img src="img/contact.png" class="nav-icon" alt=""> Contact Us
    </a>
  </div>

  <div class="nav-right">
    <a href="admin-login.php" class="nav-right-link">
      <img src="img/admin.png" class="nav-icon" alt=""> Admin
    </a>
  </div>
</nav>