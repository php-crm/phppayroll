<?php
/* 
=======================================================================
 PHPPayroll — Open Source HR & Payroll Management Software
 Version: 3.0
 License: MIT Open Source License
 Developed & Maintained By: PHPPayroll (https://www.phppayroll.com)
 
 Description:
 PHPPayroll is a Payroll and Human Resource Management platform
 available in two deployment models: PHPPayroll Open-Source, a free,
 self-hosted edition for essential HR and payroll operations, and
 PHPPayroll Cloud, a fully managed, enterprise-grade payroll system.
 PHPPayroll is designed to help organizations manage Employees,
 Attendance, Leaves, Payroll, and core HR workflows with simplicity,
 security, and speed.

 Core Modules Included (Open-Source Edition):
 - Employee Management
 - Attendance Tracking
 - Leave Management
 - Payroll Management
 - HR Dashboard
 - Secure Login

 This software is open for modification and extension.
 You are free to customize, improve, and commercially use the
 Open-Source edition without licensing fees, provided this
 copyright notice remains preserved.

 Website:
 https://www.phppayroll.com

 Live Demo:
 https://www.phppayroll.com/demo/

 Download:
 https://www.phppayroll.com/download/

 Community Contribution:
 Developers are welcome to contribute improvements, bug fixes,
 and enhancements to the Open-Source edition. Please visit our
 website for documentation, updates, and community support.

 Last Update: 14-12-2025
=======================================================================
*/

	
// app/controllers/ChangePasswordController.php

class ChangePasswordController
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;

        // authentication check
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    public function index()
    {
        $success = $_SESSION['success'] ?? null;
        $error   = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);

        include __DIR__ . '/../views/change_password/index.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: change_password.php");
            exit;
        }

        $current_pass = trim($_POST['current_password'] ?? '');
        $new_pass     = trim($_POST['new_password'] ?? '');
        $confirm_pass = trim($_POST['confirm_password'] ?? '');
        $user_id      = $_SESSION['user_id'];

        if ($current_pass === '' || $new_pass === '' || $confirm_pass === '') {
            $_SESSION['error'] = "All fields are required.";
            header("Location: change_password.php");
            exit;
        }

        if ($new_pass !== $confirm_pass) {
            $_SESSION['error'] = "New passwords do not match.";
            header("Location: change_password.php");
            exit;
        }

        // get current hash
        $sql  = "SELECT password_hash FROM phppayroll_users WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();

        if (!$user || !password_verify($current_pass, $user['password_hash'])) {
            $_SESSION['error'] = "Current password is incorrect.";
            header("Location: change_password.php");
            exit;
        }

        // update new password
        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql = "UPDATE phppayroll_users SET password_hash = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $new_hash, $user_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Password changed successfully.";
        header("Location: change_password.php");
        exit;
    }
}
