<?php
// admin-login.php
session_start();

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    // Destroy all session data
    $_SESSION = array();
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page with logout message
    header('Location: admin-login.php?msg=logged_out');
    exit();
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin-dashboard.php');
    exit();
}

// Handle login form submission
$error = '';
$success = '';

// Check for messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'logged_out') {
        $success = 'You have been successfully logged out.';
    } elseif ($_GET['msg'] == 'session_expired') {
        $error = 'Your session has expired due to inactivity. Please log in again.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Replace with your actual credentials or database check
    // IMPORTANT: In production, use password_hash() and password_verify()
    $correct_username = 'admin';
    $correct_password = 'admin123';
    
    if ($username === $correct_username && $password === $correct_password) {
        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        
        // Optional: Set session timeout (30 minutes of inactivity)
        ini_set('session.gc_maxlifetime', 1800);
        
        // Redirect to dashboard
        header('Location: admin-dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Administrator Login | BottleSort</title>
  <link rel="icon" type="image/svg+xml" href="img/logo8.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- AOS animation library -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">

  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* ---------------------- LOGIN SECTION ---------------------- */
    .login-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 3rem 2rem;
      gap: 2rem;
    }

    .logo-outside {
      width: 300px;
      max-width: 90vw;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.95);
      color: #004e44;
      padding: 2.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 420px;
      text-align: center;
    }

    .login-box h2 {
      margin-bottom: 1.5rem;
      color: #004e44;
      font-size: 1.8rem;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 0.9rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      font-family: 'Open Sans', sans-serif;
      transition: border-color 0.3s ease;
    }

    .login-box input[type="text"]:focus,
    .login-box input[type="password"]:focus {
      outline: none;
      border-color: #004e44;
    }

    .login-box button {
      width: 100%;
      padding: 0.9rem;
      background: #004e44;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
      font-family: 'Open Sans', sans-serif;
    }

    .login-box button:hover {
      background: #007a6e;
    }

    /* Error and Success Messages */
    .error-message {
      background: #fee;
      color: #c00;
      padding: 0.75rem;
      border-radius: 5px;
      margin-bottom: 1rem;
      text-align: center;
      font-weight: 600;
      border: 1px solid #fcc;
    }

    .success-message {
      background: #efe;
      color: #0a0;
      padding: 0.75rem;
      border-radius: 5px;
      margin-bottom: 1rem;
      text-align: center;
      font-weight: 600;
      border: 1px solid #cfc;
    }

    /* ---------------------- MEDIA QUERIES ---------------------- */
    @media (max-width: 768px) {
      .login-container {
        padding: 2rem 1rem;
      }

      .login-box {
        padding: 2rem;
      }

      .logo-outside {
        width: 200px;
      }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="login-container">
  <img src="img/logo2.png" alt="BottleSort Logo" class="logo-outside" data-aos="fade-down">
  
  <div class="login-box" data-aos="zoom-in">
    <h2>Administrator Login</h2>
    
    <?php if ($success): ?>
      <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username or Email" required autofocus>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Log In</button>
    </form>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });
</script>
</body>
</html>