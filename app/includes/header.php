<?php
// app/includes/header.php - top navigation bar
$adminName = $_SESSION['admin_name'] ?? ($_SESSION['user_name'] ?? 'User');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Secure Payroll Login Panel: <?php echo company_name; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./css/login.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
      <img src="<?php echo company_logo; ?>" alt="<?php echo company_name; ?>"  height="30" class="me-2"><?php echo company_name; ?> </a>
    <div class="d-flex align-items-center">
      <span class="navbar-text text-white me-3">
        Welcome, <?= htmlspecialchars($adminName) ?>
      </span>
      <a href="index.php?a=logout" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

