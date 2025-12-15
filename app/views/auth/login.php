<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Secure HRM Login Panel: <?php echo company_name; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="container">

    <!-- Logo Top -->
    <img src="<?php echo company_logo_home; ?>" alt="<?php echo company_name; ?>" class="logo-top">

    <!-- Login Form -->
    <div id="login-form" class="auth-form">

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
          <?php
          switch ($error) {
            case 'missing_fields':   echo "Please fill in all required fields."; break;
            case 'invalid_email':    echo "Invalid email address."; break;
            case 'password_mismatch':echo "Passwords do not match."; break;
            case 'db_error':         echo "Database error occurred. Try again."; break;
            case 'invalid_login':    echo "Invalid email or password."; break;
            case 'invalid_csrf':     echo "Security token expired. Please try again."; break;
            default:                 echo "An unknown error occurred.";
          }
          ?>
        </div>
      <?php endif; ?>	

      <h4 class="form-title">Login to Your Account</h4>

      <form action="index.php?a=doLogin" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
        <input type="text" name="website" class="honeypot">

        <div class="mb-3">
          <label class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>

  </div>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>