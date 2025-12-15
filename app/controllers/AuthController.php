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



class AuthController
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // GET /index.php  or /index.php?a=login
    public function login()
    {
        // simple CSRF token
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $error = $_GET['error'] ?? null;

        include __DIR__ . '/../views/auth/login.php';
    }

    // POST /index.php?a=doLogin
    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        // CSRF check
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            header('Location: index.php?error=invalid_csrf');
            exit;
        }

        // honeypot check
        if (!empty($_POST['website'])) {
            // bot
            header('Location: index.php?error=unknown');
            exit;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            header('Location: index.php?error=missing_fields');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?error=invalid_email');
            exit;
        }

        // yahan apna users table ka query lagao
        $sql  = "SELECT id, password_hash FROM phppayroll_users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            header('Location: index.php?error=db_error');
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            header('Location: index.php?error=invalid_login');
            exit;
        }

        // login success
        $_SESSION['user_id'] = $user['id'];

        header('Location: dashboard.php');
        exit;
    }

    // optional: logout action
    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }
	

	
}
