<?php
// app/includes/auth_check.php - ensure admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}
